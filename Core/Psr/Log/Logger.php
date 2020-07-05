<?php

namespace Core\Psr\Log;

use Core\Psr\Log\AbstractLogger;
use Core\Psr\Log\LogLevel;

/**
 * Class Logger
 * @package Core\Psr\Log
 */
class Logger extends  AbstractLogger
{
    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return void
     */
    public function log($level, $message, array $context = array())
    {
        $logFile = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .  self::LOGFILE_PATH;

        if (!$handle = fopen($logFile, 'a+')) {
            throw new \ErrorException("The log file " . $logFile . " cannot be opened");
        }

        $message = date('[Y-m-d H:i:s]') . "[$level] " . $this->interpolate($message, $context) . "\n";

        if (fwrite($handle, $message) === false) {
            throw new \ErrorException("Cannot write to file " . $logFile);
        }

        fclose($handle);
    }

    /**
     * Interpolates context values into the message placeholders.
     *
     * @param string $message
     * @param array $context
     * @return string
     */
    private function interpolate($message, array $context = array())
    {
        $replace = array();
        foreach ($context as $key => $val) {
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        return strtr($message, $replace);
    }
}
