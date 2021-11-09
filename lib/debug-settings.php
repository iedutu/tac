<?php
if(!isset($_SESSION['debug'])) {
	$_SESSION['debug'] = Utils::$DEBUG;
}

if(isset($_GET['debug'])) {
	if($_GET['debug'] == '1024') {
		$_SESSION['debug'] = true;
	}
	else {
		$_SESSION['debug'] = false;
	}
}

if($_SESSION['debug']) {
    DB::debugMode();
    DB::$logfile = $_SERVER['DOCUMENT_ROOT'].'/../log/db_'.date(Utils::$PHP_DATE_FORMAT).'.log';

    error_reporting ( E_ALL );
	ini_set ( 'display_errors', TRUE );
	ini_set ( 'display_startup_errors', TRUE );

	/*
	DB::debugMode('my_debugmode_handler'); // run this function after each successful command

	function my_debugmode_handler($params) {
		$var = "SQL(".$_SESSION['sql_index'].")";
		$_SESSION[$var] = $params['query']." (".$params['runtime'].")";
		$_SESSION['sql_index'] = $_SESSION['sql_index'] + 1;
	}
	*/
}
?>