<?php
/**
 * Author: Aslangeri Mokaev
 * Email: aslangery@3davinci.ru
 */

namespace Raiffeisen\Http;

use Raiffeisen\Exception\InvalidRequestException;
use Raiffeisen\Exception\RuntimeException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class RequestAbstract
 * @package Raiffeisen\Http
 */
abstract class RequestAbstract implements RequestInterface
{
    protected string $liveUrl = 'https://e-commerce.raiffeisen.ru/';
    protected string $testUrl = 'https://test.ecom.raiffeisen.ru/';

    /**
     * The request parameters
     *
     * @var array
     */
    protected array $parameters = [];

    protected string $secretKey = '';

    protected bool $testMode = false;

    /**
     * An associated ResponseInterface.
     *
     * @var ResponseInterface|null
     */
    protected ?ResponseInterface $response = null;

    /**
     * @var string
     */
    protected string $responseClassName;

    /**
     * @var HttpClientInterface
     */
    protected HttpClientInterface $client;

    abstract public function getMethodName();

    /**
     * RequestAbstract constructor.
     * @param HttpClientInterface $client
     * @param string $responseClassName
     */
    public function __construct(HttpClientInterface $client, string $responseClassName = '\Raiffeisen\Http\RestResponse')
    {
        $this->client = $client;
        $this->responseClassName = $responseClassName;
    }

    /**
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * @param string $secretKey
     * @return RequestAbstract
     */
    public function setSecretKey(string $secretKey): RequestAbstract
    {
        $this->secretKey = $secretKey;
        return $this;
    }


    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return string
     */
    protected function getUrl(): string
    {
        $url = (false === $this->getTestMode()) ? $this->liveUrl : $this->testUrl;

        return $url . $this->getMethodName();
    }


    /**
     * @return boolean
     */
    public function getTestMode(): ?bool
    {
        return $this->testMode;
    }

    /**
     * @param bool $value
     * @return RequestAbstract
     */
    public function setTestMode(bool $value): RequestAbstract
    {
        $this->testMode = $value;
        return $this;
    }

    /**
     * Return parameters listed in $keys
     * Return all parameters if $keys empty
     *
     * @param array $keys
     * @return array
     */
    public function getParameters(array $keys = []): array
    {
        if (empty($keys)) {

            return $this->parameters;
        } else {
            $params = [];
            foreach ($keys as $key) {
                $params[$key] = $this->getParameter($key);
            }

            return $params;
        }
    }

    /**
     * Get a single parameter.
     *
     * @param string $key
     * @return mixed
     */
    protected function getParameter(string $key)
    {
        return $this->parameters[$key] ?? null;
    }

    /**
     * Set a single parameter
     *
     * @param string $key
     * @param mixed $value
     * @return RequestAbstract
     */
    protected function setParameter(string $key, $value): RequestAbstract
    {
        if (null !== $this->response) {
            throw new RuntimeException('Request cannot be modified after it has been sent!');
        }
        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * Validate the request.
     *
     * @throws InvalidRequestException
     */
    protected function validate()
    {
        $parameters = func_get_args();
        foreach ($parameters as $key) {
            if (! isset($this->parameters[$key]) || empty($this->parameters[$key])) {
                throw new InvalidRequestException("The $key parameter is required");
            }
        }
    }

    /**
     * Initialize a request with a given array of parameters
     *
     * @param array $parameters
     * @return RequestAbstract
     */
    public function initialize(array $parameters): RequestAbstract
    {
        foreach ($parameters as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        return $this;
    }

    public function getRequestUrl(): string
    {
        return $this->getUrl() . '?' . http_build_query($this->getParameters());
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    public function send(): ResponseInterface
    {
        $httpResponse = $this->client->request(
            'POST',
            $this->getUrl(),
            [
                'auth_bearer' => $this->getSecretKey(),
                'body' => $this->getParameters()
            ],
        );

        $body = $httpResponse->toArray();
        $responseClassName = $this->responseClassName;

        return $this->response = new $responseClassName($this, $body, $httpResponse->getStatusCode());
    }
}