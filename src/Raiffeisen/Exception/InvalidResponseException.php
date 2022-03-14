<?php
/**
 * Author: Aslangeri Mokaev
 * Email: aslangery@3davinci.ru
 */

namespace Raiffeisen\Exception;

class InvalidResponseException extends \Exception
{
    public function __construct($message = 'Invalid response from Raiffeisen gateway', $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}