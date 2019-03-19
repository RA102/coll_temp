<?php

namespace common\utils;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Yii;
use yii\log\Logger as YiiLogger;

/**
 * Psr-3 compatible wrapper for Yii2 logger
 * Class Logger
 */
class Logger implements LoggerInterface
{
    const LOGS_LEVELS_MAP = [
        LogLevel::INFO    => YiiLogger::LEVEL_INFO,
        LogLevel::ERROR   => YiiLogger::LEVEL_ERROR,
        LogLevel::WARNING => YiiLogger::LEVEL_WARNING,
    ];

    private $namespace;

    /**
     * Logger constructor.
     * @param string $namespace
     */
    public function __construct(string $namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function emergency($message, array $context = array())
    {
        throw new \Exception("Not supported");
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function alert($message, array $context = array())
    {
        throw new \Exception("Not supported");
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function critical($message, array $context = array())
    {
        throw new \Exception("Not supported");
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function error($message, array $context = array())
    {
        throw new \Exception("Not supported");
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function warning($message, array $context = array())
    {
        Yii::warning($message, $this->namespace);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function notice($message, array $context = array())
    {
        Yii::info($message, $this->namespace);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function info($message, array $context = array())
    {
        Yii::info($message, $this->namespace);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function debug($message, array $context = array())
    {
        Yii::debug($message, $this->namespace);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function log($level, $message, array $context = array())
    {
        if (key_exists($level, self::LOGS_LEVELS_MAP)) {
            Yii::getLogger()->log($message, self::LOGS_LEVELS_MAP[$level], $this->namespace);
        } else {
            $this->debug($message);
        }
    }
}