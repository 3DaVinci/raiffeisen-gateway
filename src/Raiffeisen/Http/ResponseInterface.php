<?php
/**
 * Author: Aslangeri Mokaev
 * Email: aslangery@3davinci.ru
 */

namespace Raiffeisen\Http;

/**
 * Interface ResponseInterface
 * @package Raiffeisen\Http
 */
interface ResponseInterface
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful(): bool;

    /**
     * Does the response require a redirect?
     *
     * @return mixed
     */
    public function getData();

    /**
     * @return RequestInterface|null
     */
    public function getRequest(): ?RequestInterface;

    /**
     * Response code
     *
     * @return null|string A response code from Raiffeisen gateway
     */
    public function getCode(): ?string;

    /**
     * Raiffeisen error code
     *
     * @return int|null
     */
    public function getErrorCode(): ?int;

    /**
     * Raiffeisen error message
     *
     * @return string
     */
    public function getErrorMessage(): string;
}