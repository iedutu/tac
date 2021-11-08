<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class AppLogger
{
    private Logger $logger;
    private static string $path = '/home/sites/cat.rohel.ro/log/httpd';
    public static function getLogger(): Logger
    {
        if(empty($logger)) {
            $logger = new Logger('cat.rohel.ro');
            $logger->pushHandler(new StreamHandler(self::$path.'/app_'.date(Utils::$PHP_DATE_FORMAT).'.log', Logger::WARNING));
        }

        return $logger;
    }
}
