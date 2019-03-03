<?php

namespace common\exceptions;

use Throwable;

class TranslatableException extends \Exception
{
    const DEFAULT_ERROR_MESSAGE = 'Generic';

    public function __construct(
        $i18MessageKey = self::DEFAULT_ERROR_MESSAGE,
        $params = [],
        $code = 0,
        Throwable $previous = null
    ) {
        $message = \Yii::t('app/error', $i18MessageKey);
        parent::__construct($message, $code, $previous);
    }
}