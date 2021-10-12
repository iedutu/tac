<?php
session_start();

include "../lib/settings.php";
include "../lib/db-settings.php";
require "../lib/functions.php";

require_once '../lib/debug.php';

date_default_timezone_set ( 'Europe/Bucharest' );

if($_POST['id']) {
	/* Changes related to the report dates*/
	$_SESSION['debug_1'] = $_POST['id'].' - '.$_POST['value'];
	if(($_POST['id'] == 'start_date_reports') || ($_POST['id'] == 'end_date_reports')) {
		$date_regex = '/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/';
		if(!preg_match($date_regex, $_POST['value'])) {
			echo '[Wrong date format]';
			return;
		}
		
		if($_POST['id'] == 'start_date_reports') {
			$start_date_reports = date('Y-m-d', strtotime($_POST['value']));
			$end_date_reports = date('Y-m-d', strtotime($_SESSION['end_date_reports_plm']));
			
			if($start_date_reports > $end_date_reports) {
				echo '[Date mismatch]';
				return;
			}

			$_SESSION['start_date_reports_plm'] = $_POST['value'];
		}
		
		if($_POST['id'] == 'end_date_reports') {
			$end_date_reports = date('Y-m-d', strtotime($_POST['value']));
			$start_date_reports = date('Y-m-d', strtotime($_SESSION['start_date_reports_plm']));
			
			if($start_date_reports > $end_date_reports) {
				echo '[Date mismatch]';
				return;
			}

			$_SESSION['end_date_reports_plm'] = $_POST['value'];
		}

		echo $_POST['value'];
		return;
	}

	/* Changes related to the app dates*/
	if(($_POST['id'] == 'loading_date') || ($_POST['id'] == 'unloading_date') || ($_POST['id'] == 'expiration') || ($_POST['id'] == 'availability')) {
		$date_regex = '/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/';

		if(!preg_match($date_regex, $_POST['value'])) {
			echo '[Wrong date format]';
			return;
		}
	}

	if($_SESSION['app'] == 'cargo') {
		DB::update ( 'cargo_request', array (
									$_POST['id'] => $_POST['value'],
									'operator' => $_SESSION['operator'],
									), "id=%d", $_SESSION['cargo_id'] );

		Utils::cargo_audit ('cargo_request', $_POST['id'], $_SESSION['cargo_id'], $_POST['value'] );
		DB::commit();
	}
	
	if($_SESSION['app'] == 'truck') {
		DB::update ( 'cargo_truck', array (
									$_POST['id'] => $_POST['value'],
									'operator' => $_SESSION['operator'],
									), "id=%d", $_SESSION['truck_id'] );

		Utils::cargo_audit ('cargo_truck', $_POST['id'], $_SESSION['truck_id'], $_POST['value'] );
		DB::commit();
	}	
	
	echo $_POST['value'];
}
?>