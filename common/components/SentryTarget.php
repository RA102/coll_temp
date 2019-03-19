<?php

namespace common\components;

use Sentry;
use yii\helpers\VarDumper;
use yii\log\Logger;
use yii\log\Target;

class SentryTarget extends Target
{
    public $dsn;

    public function init()
    {
        parent::init();

        if (!$this->dsn) {
            throw new \Exception('Dsn not configured');
        }

        Sentry\init([
            'dsn'             => $this->dsn,
            'max_breadcrumbs' => 30
        ]);
    }

    /**
     * Exports log [[messages]] to a specific destination.
     * Child classes must implement this method.
     */
    public function export()
    {
        foreach ($this->messages as $message) {
            list($context, $level, $category, $timestamp) = $message;
            if ($context instanceof \Throwable || $context instanceof \Exception) {
                Sentry\captureException($context);
                continue;
            }

            $data = [
                'level'     => static::getLevelName($level),
                'timestamp' => $timestamp,
                'tags'      => [
                    'category' => $category,
                ],
            ];
            if ($data['level'] === 'error') {
                if (isset($context['msg'])) {
                    $data['message'] = $context['msg'];
                    $extra = $context;
                    unset($extra['msg']);
                    $data['extra'] = $extra;
                } else {
                    // If the message is not a string, log it with VarDumper::export,
                    // like the other log targets in Yii.
                    $data['message'] = is_string($context) ? $context : VarDumper::export($context);
                    if (is_array($context)) {
                        // But if it's an array, also send it as an array,
                        // so that it can be displayed nicely in Sentry.
                        $data['extra'] = $context;
                    }
                }

                Sentry\captureEvent($data);
            }
        }
    }

    /**
     * Maps a Yii Logger level to a Sentry log level.
     *
     * @param integer $level The message level, e.g. [[\yii\log\Logger::LEVEL_ERROR]], [[\yii\log\Logger::LEVEL_WARNING]].
     * @return string Sentry log level.
     */
    public static function getLevelName($level)
    {
        static $levels = [
            Logger::LEVEL_ERROR         => 'error',
            Logger::LEVEL_WARNING       => 'warning',
            Logger::LEVEL_INFO          => 'info',
            Logger::LEVEL_TRACE         => 'debug',
            Logger::LEVEL_PROFILE_BEGIN => 'debug',
            Logger::LEVEL_PROFILE_END   => 'debug',
        ];
        return isset($levels[$level]) ? $levels[$level] : 'error';
    }
}