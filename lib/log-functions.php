<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class AppLogger
{
    private static Logger $logger;

    public static function getLogger(): Logger
    {
        if(empty(self::$logger)) {
            self::$logger = new Logger('cat.rohel.ro');
            self::$logger->pushHandler(new StreamHandler($_SERVER['DOCUMENT_ROOT'].'/../log/app_'.date(Utils::$PHP_DATE_FORMAT).'.log', Logger::DEBUG));
        }

        return self::$logger;
    }
}
