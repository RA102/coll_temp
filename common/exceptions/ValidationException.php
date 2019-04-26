<?php

namespace common\exceptions;

class ValidationException extends \RuntimeException
{

    public $errors = [];

    /**
     * Errors have to be in format [attributeName => [errorMessage1, errorMessage2]]
     * ValidationException constructor.
     * @param string $message
     * @param int $code
     * @param array $errors
     * @param \Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, $errors = [], \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }
}