<?php
session_start ();

include "../lib/settings.php";
include "../lib/db-settings.php";
require "../lib/functions.php";

require_once '../lib/debug.php';

if(!isset($_SESSION['sql_index'])) {
	$_SESSION['sql_index'] = 0;
}

$rpath = "/";
$page = 1;

if(isset($_GET['default'])) {
	if($_GET['default'] == 1) {
		$_SESSION['default'] = 1;
	}
	else {
		$_SESSION['default'] = 0;
	}
}

if(!isset($_SESSION['limba'])) {
	$_SESSION['limba'] = 'ro_RO';
}

if ((isset($_GET['language'])) && (($_GET['language'] == 'en_GB') || ($_GET['language'] == 'ro_RO') || ($_GET['language'] == 'el_GR'))) {
	unset($_SESSION['limba']);
	$_SESSION['limba'] = $_GET['language'];
}

setlocale(LC_ALL, $_SESSION['limba']);
bindtextdomain("messages", '../locale');
textdomain("messages");
bind_textdomain_codeset("messages", 'UTF-8');

if (! isset ( $_SESSION ['operator_id'] )) {
	include "login.php";
} else {
	if((isset ( $_GET ['page'])) && ($_GET ['page'] == 'logout')) {
		Utils::logout();
		header ( 'Location: index.php?page=login' );
	}

	if(Utils::authorized(null, Utils::$ADMIN)) {
		include 'admin.php';
	}
	else {
		if(Utils::authorized(null, Utils::$QUERY)) {
			if(! isset( $_SESSION["update_done"] )) {
				Utils::cargoUpdateStatuses();
			}

			if (! isset ( $_GET ['page'] )) {
				if (isset ( $_SESSION ['app'] )) {
					include $_SESSION ['app'].".php";
				}
				else {
					$_SESSION['app'] = 'cargo';
					include "cargo.php";
				}
			} else {
				if($_GET ['page'] == 'cargo') {
					$_SESSION['app'] = 'cargo';
				}
				
				if($_GET ['page'] == 'truck') {
					$_SESSION['app'] = 'truck';
				}
				
				if(($_GET ['page'] == 'new') || ($_GET ['page'] == 'details')) {
					if (isset ( $_GET ['type'] )) {
						if($_GET ['type'] == 'cargo') {
							$_SESSION['app'] = 'cargo';
						}
						else {
							$_SESSION['app'] = 'truck';
						}
					}
					
					include $_GET ['page'].'_'.$_SESSION['app'].'.php';
				}
				else {
					include $_GET ['page'] . '.php';
				}
			}
		}
	}
}

include "../footer.php";

?>
