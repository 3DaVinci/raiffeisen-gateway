<?php
/**
 * Author: Aslangeri Mokaev
 * Email: aslangery@3davinci.ru
 */

namespace Raiffeisen\Http;

use Raiffeisen\Entity\Receipt;
use Raiffeisen\Exception\InvalidRequestException;

/**
 * Class RegisterOrderRequest
 * @package Raiffeisen\Http
 */
class PayRequest extends RequestAbstract
{
    /**
     * Идентификатор магазина.
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setPublicId(string $value): RequestAbstract
    {
        return $this->setParameter('publicId', $value);
    }
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

    /**
     * Сумма платежа в рублях
     *
     * @param float $value
     * @return RequestAbstract
     */
    public function setAmount(float $value): RequestAbstract
    {
        return $this->setParameter('amount', $value);
    }

    /**
     * Адрес, на который требуется перенаправить пользователя в случае успешной оплаты. Адрес должен быть указан полностью,
     * включая используемый протокол (например, https://test.ru вместо tes t.ru). В противном случае пользователь будет
     * перенаправлен по адресу следующего вида: http://<ад рес_платёжного_шлюза>/<адрес_продавца>.
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setSuccessUrl(string $value): RequestAbstract
    {
        return $this->setParameter('successUrl', $value);
    }

    /**
     * Адрес, на который требуется перенаправить пользователя в случае неуспешной оплаты. Адрес должен быть указан полностью,
     * включая используемый протокол (например, https://test.ru вместо tes t.ru). В противном случае пользователь будет
     * перенаправлен по адресу следующего вида: http://<ад рес_платёжного_шлюза>/<адрес_продавца>.
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setFailUrl(string $value): RequestAbstract
    {
        return $this->setParameter('failUrl', $value);
    }


    /**
     * Продолжительность жизни заказа в секундах.
     * В случае если параметр не задан, будет использовано значение, указанное в настройках мерчанта или время по
     * умолчанию (1200 секунд = 20 минут).
     *
     * @param int $value
     * @return RequestAbstract
     */
    public function setSessionTimeoutSecs(int $value): RequestAbstract
    {
        return $this->setParameter('sessionTimeoutSecs', $value);
    }

    /**
     * Enum: "ru" "en"
     * Выбор языка формы, по умолчанию ru
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setLocale(string $value): RequestAbstract
    {
        return $this->setParameter('locale', $value);
    }

    /**
     * Комментарий
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setComment(string $value): RequestAbstract
    {
        return $this->setParameter('comment', mb_substr($value, 0, 140));
    }

    /**
     * Enum: "ONLY_SBP" "ONLY_ACQUIRING"
     * Выбор метода оплаты. Если значение не передано, отображается общая форма
     * @param $value
     * @return RequestAbstract
     */
    public function setPaymentMethod($value): RequestAbstract
    {
        return $this->setParameter('paymentMethod', $value);
    }

    /**
     * Данные чека. Объект обязателен, если подключена фискализация чеков.
     * При отсутствии объекта receipt чек не будет создан
     *
     * @param Receipt $value
     * @return RequestAbstract
     */
    public function setReceipt(Receipt $value): RequestAbstract
    {
        return $this->setParameter('receipt', json_encode($value->toArray()));
    }

    /**
     * @throws InvalidRequestException
     */
    public function validate()
    {
        parent::validate('orderId', 'amount', 'successUrl');
    }

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        return 'pay';
    }

    public function send(): ResponseInterface
    {
        $httpResponse = $this->client->request(
            'GET',
            $this->getRequestUrl(),
            []
        );

        $responseClassName = $this->responseClassName;

        return $this->response = new $responseClassName($this, [], $httpResponse->getStatusCode());
    }
}