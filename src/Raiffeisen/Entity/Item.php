<?php
/**
 * Author: Aslangeri Mokaev
 * Email: aslangery@3davinci.ru
 */

namespace Raiffeisen\Entity;

class Item extends AbstractEntity
{
    const WITHOUT_VAT = 'none';
    const VAT_0       = 'vat0';
    const VAT_10      = 'vat10';
    const VAT_10_110  = 'vat110';
    const VAT_20      = 'vat20';
    const VAT_20_120  = 'vat120';

    const PAYMENT_OBJECT_PRODUCT = 'commodity';
    const PAYMENT_OBJECT_EXCISE = 'excise';
    const PAYMENT_OBJECT_JOB = 'job';
    const PAYMENT_OBJECT_SERVICE = 'service';
    const PAYMENT_OBJECT_PAYMENT = 'payment';
    const PAYMENT_OBJECT_ANOTHER = 'another';
    /**
     * Наименование товара, работы, услуги, иного предмета расчета
     * @var string
     */
    protected string $name = '';

    /**
     * Цена за единицу товара, работы, услуги, иного предмета расчета в рублях (8 символов на целую часть, 2 - на дробную)
     * @var float
     */
    protected float $price = 0;

    /**
     * Количество.
     * @var float
     */
    protected float $quantity = 1;

    /**
     * Сумма в рублях (8 символов на целую часть, 2 - на дробную).
     * @var float
     */
    protected float $amount = 0;

    /**
     * Единица измерения товара, работы, услуги, иного предмета расчета.
     * @var string
     */
    protected string $measurementUnit = '';

    /**
     * Номенклатурный код товара. Будет преобразован в 16-ричное представлении с пробелами или в формате GS1 DataMatrix.
     * Например, "00 00 00 00 12 00 AB 00" или "010463003407001221CMK45BrhN0WLf"
     * @var string
     */
    protected string $nomenclatureCode = '';

    /**
     * Enum: "none" "vat0" "vat10" "vat110" "vat20" "vat120"
     * Ставка НДС на позицию чека
     * @var string
     */
    protected string $vatType;

    /**
     * Enum: "commodity" "excise" "job" "service" "payment" "another"
     * Признак предмета расчёта (товар, подакцизный товар, работа, услуга, платеж, иной предмет расчета).
     * Если значение не передано, то заполняется на стороне выбранного ОФД в соответствии с установленным протоколом
     * @var string
     */
    protected string $paymentObject = '';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Item
     */
    public function setName(string $name): Item
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Item
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param float $quantity
     * @return Item
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return Item
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getMeasurementUnit(): string
    {
        return $this->measurementUnit;
    }

    /**
     * @param string $measurementUnit
     * @return Item
     */
    public function setMeasurementUnit(string $measurementUnit): Item
    {
        $this->measurementUnit = $measurementUnit;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomenclatureCode(): string
    {
        return $this->nomenclatureCode;
    }

    /**
     * @param string $nomenclatureCode
     * @return Item
     */
    public function setNomenclatureCode(string $nomenclatureCode): Item
    {
        $this->nomenclatureCode = implode(' ', str_split(bin2hex($nomenclatureCode), 2));
        return $this;
    }

    /**
     * @return string
     */
    public function getVatType(): string
    {
        return $this->vatType;
    }

    /**
     * @param string $vatType
     * @return Item
     */
    public function setVatType(string $vatType): Item
    {
        $this->vatType = $vatType;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentObject(): string
    {
        return $this->paymentObject;
    }

    /**
     * @param string $paymentObject
     * @return Item
     */
    public function setPaymentObject(string $paymentObject): Item
    {
        $this->paymentObject = $paymentObject;
        return $this;
    }
}