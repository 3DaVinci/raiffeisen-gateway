# Библиотека для работы с платежным шлюзом Райффайзен банка. Интерфейс REST.

[![Build Status](https://api.travis-ci.org/3DaVinci/sberbank-gateway.png?branch=master)](https://travis-ci.org/3DaVinci/sberbank-gateway)

## Установка

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Возможности

 - registerOrder - запрос формы оплаты
 - orderStatus - запрос состояния заказа
 - paymentCancellation - запрос отмены оплаты заказа
 - refund - запрос возврата средств оплаты заказа

## Пример использования

```php
<?php

$gateway = new \Raiffaisen\RestGateway([
            'secretKey' => '',
            'publicId' => '',
            'testMode' => false,
        ]);

$request = $gateway->pay([
        'orderId' => 1,
        'amount' => 120.00,
        'returnUrl' => 'https://server/applicaton_context/finish.html'
    ]);
```
