<?php
/**
 * Author: Aslangeri Mokaev
 * Email: aslangery@3davinci.ru
 */

namespace Raiffeisen;

use Raiffeisen\Http\RequestAbstract;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class RestGateway implements GatewayInterface
{
    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $httpClient;

    /**
     * @var array
     */
    private array $parameters;

    /**
     * RestGateway constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->httpClient = HttpClient::create();
        $this->parameters = array_replace($this->getDefaultParameters(), $parameters);
    }

    /**
     * Запрос состояния заказа
     *
     * @param array $parameters
     * @return RequestAbstract
     */
    public function orderStatus(array $parameters = []): RequestAbstract
    {
        return $this->createRequest('CheckStatus', $parameters);
    }

    /**
     * Запрос открытия формы заказа
     *
     * @param array $parameters
     * @return RequestAbstract
     */
    public function pay(array $parameters = []): RequestAbstract
    {
        return $this->createRequest('Pay', $parameters);
    }

    /**
     * Запрос отмены оплаты заказа
     *
     * @param array $parameters
     * @return RequestAbstract
     */
    public function paymentCancellation(array $parameters = []): RequestAbstract
    {
        return $this->createRequest('PaymentCancellation', $parameters);
    }

    /**
     * Запрос возврата средств оплаты заказа
     *
     * @param array $parameters
     * @return RequestAbstract
     */
    public function refund(array $parameters = []): RequestAbstract
    {
        return $this->createRequest('Refund', $parameters);
    }

    /**
     * @return array
     */
    public function getParameters() : array
    {
        return $this->parameters;
    }

    /**
     * @return array
     */
    public function getDefaultParameters() : array
    {
        return [
            'secretKey' => '',
            'publicId' => '',
            'testMode' => false,
        ];
    }

    /**
     * @param string $className
     * @param array $parameters
     * @return RequestAbstract
     */
    private function createRequest(string $className, array $parameters) : RequestAbstract
    {
        $classRequest = '\Raiffeisen\Http\\'.$className.'Request';
        $classResponse = '\Raiffeisen\Http\\'.$className.'Response';
        /** @var RequestAbstract $requestObj */
        $requestObj = new $classRequest($this->httpClient, $classResponse);

        return $requestObj->initialize(array_replace($this->getParameters(), $parameters));
    }
}