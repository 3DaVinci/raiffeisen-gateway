<?php

namespace Raiffeisen\Http;

class CheckStatusRequest extends RequestAbstract
{
    /**
     * Номер (идентификатор) заказа в системе магазина, уникален для каждого магазина в пределах системы
     *
     * @param string|int $value
     * @return RequestAbstract
     */
    public function setOrderId($value): RequestAbstract
    {
        return $this->setParameter('orderId', $value);
    }

    public function getMethodName()
    {
        return 'api/payment/v1/orders/';
    }

    public function send(): ResponseInterface
    {
        $httpResponse = $this->client->request(
            'GET',
            $this->getUrl() . $this->getParameter('orderId'),
            [
                'auth_bearer' => $this->getSecretKey(),
            ],
        );

        $body = $httpResponse->toArray();
        $responseClassName = $this->responseClassName;

        return $this->response = new $responseClassName($this, $body, $httpResponse->getStatusCode());
    }
}