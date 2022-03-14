<?php
/**
 * Author: Aslangeri Mokaev
 * Email: aslangery@3davinci.ru
 */

namespace Raiffeisen\Entity;

class Receipt extends AbstractEntity
{
    /**
     * Уникальный номер чека. Если значение не передано, то заполняется номером заказа (orderId)
     */
    protected string $receiptNumber = '';

    /**
     * Данные о покупателе. Массив:
     * [
     *      'email' => 'test@example.ru',
     *      'name' => 'Иванов Иван Иванович'
     * ]
     * @var array|null
     */
    protected ?array $customerDetails = null;

    /**
     * Позиции чека (не более 100 объектов)
     * @var array|Item[]
     */
    protected array $items = [];

    /**
     * @return string
     */
    public function getReceiptNumber(): string
    {
        return $this->receiptNumber;
    }

    /**
     * @param $receiptNumber
     * @return Receipt
     */
    public function setReceiptNumber($receiptNumber): Receipt
    {
        $this->receiptNumber = $receiptNumber;
        return $this;
    }

    /**
     * @return array
     */
    public function getCustomerDetails(): array
    {
        return $this->customerDetails;
    }

    /**
     * @param mixed $customerDetails
     * @return Receipt
     */
    public function setCustomerDetails(array $customerDetails): Receipt
    {
        $this->customerDetails = $customerDetails;
        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param Item[]|array $items
     * @return Receipt
     */
    public function setItems(array $items): Receipt
    {
        foreach ($items as $cartItem) {
            if ($cartItem instanceof AbstractEntity) {
                $this->items['items'][] = $cartItem->toArray();
            } else {
                $this->items['items'][] = $cartItem;
            }
        }

        return $this;
    }


}