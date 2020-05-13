<?php
/**
 * @copyright 2010-2013 JTL-Software GmbH
 * @package Jtl\Connector\Core
 */

namespace Jtl\Connector\Core\Logger;

use Jtl\Connector\Core\Config\RuntimeConfig;
use Jtl\Connector\Core\Config\ConfigOptions;
use Jtl\Connector\Core\IO\Path;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger as MonoLogger;

class Logger
{
    const CHANNEL_CHECKSUM = 'checksum';
    const CHANNEL_GLOBAL = 'global';
    const CHANNEL_LINKER = 'linker';
    const CHANNEL_RPC = 'rpc';
    const CHANNEL_SESSION = 'session';

    const INFO = 'info';
    const WARNING = 'warning';
    const DEBUG = 'debug';
    const ERROR = 'error';

    protected static $logLevelMappings = [
        self::INFO => MonoLogger::INFO,
        self::WARNING => MonoLogger::WARNING,
        self::ERROR => MonoLogger::ERROR,
        self::DEBUG => MonoLogger::DEBUG,
    ];

    /**
     * @param string $message
     * @param string $level
     * @param string $channel
     * @return boolean
     */
    public static function write(string $message, string $level = self::INFO, string $channel = self::CHANNEL_GLOBAL): void
    {
        $runtimeConfig = RuntimeConfig::getInstance();

        $logLevelOption = $runtimeConfig->get(ConfigOptions::LOG_LEVEL, self::INFO);
        $logLevel = MonoLogger::INFO;
        if (isset(self::$logLevelMappings[$logLevelOption])) {
            $logLevel = self::$logLevelMappings[$logLevelOption];
        }

        $log = self::getLogger($channel);
        if (!$log->isHandling($logLevel)) {
            $path = Path::combine(CONNECTOR_DIR, 'logs', sprintf('%s.log', $channel));
            $log->pushHandler(new RotatingFileHandler($path, 2, $logLevel));
        }

        $log->log($level, $message);
    }

    /**
     * @param \Throwable $exception
     * @param string $level
     * @param string $channel
     */
    public static function writeException(\Throwable $exception, string $level = self::ERROR, string $channel = self::CHANNEL_GLOBAL)
    {
        self::write(self::createExceptionInfos($exception, false), $level, $channel);
        self::write($exception->getMessage(), $level, $channel);
        self::write($exception->getTraceAsString(), self::DEBUG, $channel);
    }

    /**
     * @param \Throwable $exception
     * @param bool $maskFilePath
     * @param string|null $additionalMessage
     * @return string
     */
    public static function createExceptionInfos(\Throwable $exception, bool $maskFilePath, string $additionalMessage = null): string
    {
        $file = $exception->getFile();
        if ($maskFilePath) {
            $file = sprintf('...%s', substr($file, strlen(CONNECTOR_DIR)));
        }

        $infos = sprintf(
            "%s (Code: %s) in %s:%s",
            get_class($exception),
            $exception->getCode(),
            $file,
            $exception->getLine()
        );

        if (is_string($additionalMessage)) {
            $infos .= sprintf(' - %s', $additionalMessage);
        }

        return $infos;
    }

    /**
     * Gets the current logger
     *
     * @param string $channel The log channel
     * @return MonoLogger
     */
    public static function getLogger($channel): MonoLogger
    {
        return LoggerFactory::get($channel);
    }
}
