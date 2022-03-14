<?php
/**
 * Author: Aslangeri Mokaev
 * Email: aslangery@3davinci.ru
 */

namespace Raiffeisen;

interface GatewayInterface
{
    public function getDefaultParameters() : array;
}