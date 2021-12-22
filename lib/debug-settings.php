<?php
$debug = Utils::$DEBUG;

if(isset($_GET['debug'])) {
	if($_GET['debug'] == '1024') {
		$debug = true;
	}
}

if($debug) {
    DB::debugMode();

    // $log_path = $_SERVER['DOCUMENT_ROOT'] . '/../log'; // remote
    $log_path = '/usr/local/var/log/httpd'; // localhost

    DB::$logfile = $log_path.'/db_'.date(Utils::$PHP_DATE_FORMAT).'.log';
}
else {
    DB::debugMode(false);
}