<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class AppLogger
{
    private static Logger $logger;

    public static function getLogger(): Logger
    {
        // $log_path = $_SERVER['DOCUMENT_ROOT'] . '/../log'; // remote
        $log_path = '/usr/local/var/log/httpd'; // localhost

        if(empty(self::$logger)) {
            self::$logger = new Logger('cat.rohel.ro');
            if(Utils::$DEBUG) {
                self::$logger->pushHandler(new StreamHandler($log_path.'/app_' . date(Utils::$PHP_DATE_FORMAT) . '.log', Logger::DEBUG));
            }
            else {
                self::$logger->pushHandler(new StreamHandler($log_path.'/app_' . date(Utils::$PHP_DATE_FORMAT) . '.log', Logger::WARNING));
            }
        }

        return self::$logger;
    }
}
