<?php

namespace common\services\exceptions;

use Throwable;

class DomainException extends \Exception
{
    public $i18nMessageKey;

    /**
     * DomainException constructor.
     * @param string $message
     * @param int $code
     * @param string $i18nMessageKey
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $i18nMessageKey = 'Generic', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->i18nMessageKey = $i18nMessageKey;
    }
}