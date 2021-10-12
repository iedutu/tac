<?php
session_start();

if (! isset ( $_SESSION ['operator_id'] )) {
	header ( 'Location: index.php?page=login' );
	exit ();
}

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

include "../lib/settings.php";
include "../lib/db-settings.php";
require "../lib/functions.php";
require_once '../lib/debug.php';

date_default_timezone_set ( 'UTC' );

if (Utils::authorized ( 'main', Utils::$REPORTS )) {
	if (isset ( $_GET ['action'] )) {	
		$condition = '';
		$separator = '';

		if($_SESSION['operator_class']['turkey']) {
			$condition = $condition.'turkey = 1';
			$separator = ' OR ';
		}
		if($_SESSION['operator_class']['greece']) {
			$condition = $condition.$separator.'greece = 1';
			$separator = ' OR ';
		}
		if($_SESSION['operator_class']['serbia']) {
			$condition = $condition.$separator.'serbia = 1';
			$separator = ' OR ';
		}
		if($_SESSION['operator_class']['romania']) {
			$condition = $condition.$separator.'romania = 1';
		}
	
		if($_SESSION['operator_class']['moldova']) {
			$condition = $condition.$separator.'moldova = 1';
		}
	
		$_path = $_SERVER ['HTTP_HOST'] . 'new/';
		date_default_timezone_set ( 'Europe/Bucharest' );
		
		$spreadsheet = new Spreadsheet ();
		try {
			if ($_GET ['action'] == 1) {
				if ($_SESSION['app'] == 'cargo') {
					$spreadsheet->getProperties()->setCreator("ROHEL Web Team")->setLastModifiedBy("ROHEL Web Team")->setTitle("Cargo report " . date("d/m/Y"))->setSubject("Cargo report")->setDescription("List of all registered cargo at rohel.ro")->setKeywords("cargo hauliers")->setCategory("Cargo");

					$spreadsheet->setActiveSheetIndex(0)
						->setCellValue('A1', 'From')
						->setCellValue('B1', 'To')
						->setCellValue('C1', 'Client')
						->setCellValue('D1', 'Loading from')
						->setCellValue('E1', 'Unloading to')
						->setCellValue('F1', 'Loading on')
						->setCellValue('G1', 'Unloading on')
						->setCellValue('H1', 'Goods description')
						->setCellValue('I1', 'Number of collies')
						->setCellValue('J1', 'Gross weight')
						->setCellValue('K1', 'Volume')
						->setCellValue('L1', 'Loading meters')
						->setCellValue('M1', 'Freight')
						->setCellValue('N1', 'PIC')
						->setCellValue('O1', 'Expiration')
						->setCellValue('P1', 'Acceptance')
						->setCellValue('Q1', 'Accepted by')
						->setCellValue('R1', 'Plate number')
						->setCellValue('S1', 'AMETA')
						->setCellValue('T1', 'Status')
						->setCellValue('U1', 'Creation date')
						->setCellValue('V1', 'Last change date')
						->setCellValue('W1', 'URL');

					$results = DB::query("SELECT * FROM cargo_request WHERE
											(
												originator in (SELECT username FROM cargo_users WHERE " . $condition . ") OR
												recipient in (SELECT username FROM cargo_users WHERE " . $condition . ")
											)  
											and (SYS_CREATION_DATE >= %s) and (SYS_CREATION_DATE <= %s)
											order by SYS_CREATION_DATE",
						date('Y-m-d 00:00:00', strtotime($_SESSION['start_date_reports_plm'])),
						date('Y-m-d 23:59:59', strtotime($_SESSION['end_date_reports_plm'])));

					$i = 2;
					foreach ($results as $row) {
						$status = '';

						switch ($row['status']) {
							case 0:
								$status = 'NEW';
								break;
							case 1:
								$status = 'ACCEPTED';
								break;
							case 2:
								$status = 'EXPIRED';
								break;
							case 3:
								$status = 'CANCELLED';
								break;
							default:
								$status = 'ERROR';
						}

						$spreadsheet->setActiveSheetIndex(0);
						$spreadsheet->getActiveSheet()->getStyle('F' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
						$spreadsheet->getActiveSheet()->getStyle('G' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
						$spreadsheet->getActiveSheet()->getStyle('O' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
						$spreadsheet->getActiveSheet()->getStyle('P' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
						$spreadsheet->getActiveSheet()->getStyle('U' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
						$spreadsheet->getActiveSheet()->getStyle('V' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);

						$spreadsheet->setActiveSheetIndex(0)
							->setCellValue('A' . $i, $row ['originator'])
							->setCellValue('B' . $i, $row ['recipient'])
							->setCellValue('C' . $i, $row ['client'])
							->setCellValue('D' . $i, $row ['from_city'])
							->setCellValue('E' . $i, $row ['to_city'])
							->setCellValue('F' . $i, ($row ['loading_date'] == null) ? 'N/A' : Date::PHPToExcel(strtotime($row ['loading_date'])))
							->setCellValue('G' . $i, ($row ['unloading_date'] == null) ? 'N/A' : Date::PHPToExcel(strtotime($row ['unloading_date'])))
							->setCellValue('H' . $i, ($row ['description'] == null) ? 'N/A' : $row ['description'])
							->setCellValue('I' . $i, ($row ['collies'] == null) ? 'N/A' : $row ['collies'])
							->setCellValue('J' . $i, $row ['weight'])
							->setCellValue('K' . $i, $row ['volume'])
							->setCellValue('L' . $i, $row ['loading_meters'])
							->setCellValue('M' . $i, ($row ['freight'] == null) ? 'N/A' : $row ['freight'])
							->setCellValue('N' . $i, ($row ['pic'] == null) ? 'N/A' : $row ['pic'])
							->setCellValue('O' . $i, ($row ['expiration'] == null) ? 'N/A' : Date::PHPToExcel(strtotime($row ['expiration'])))
							->setCellValue('P' . $i, ($row ['acceptance'] == null) ? 'N/A' : Date::PHPToExcel(strtotime($row ['acceptance'])))
							->setCellValue('Q' . $i, ($row ['accepted_by'] == null) ? 'N/A' : $row ['accepted_by'])
							->setCellValue('R' . $i, ($row ['plate_number'] == null) ? 'N/A' : $row ['plate_number'])
							->setCellValue('S' . $i, ($row ['ameta'] == null) ? 'N/A' : $row ['ameta'])
							->setCellValue('T' . $i, $status)
							->setCellValue('U' . $i, $row ['SYS_CREATION_DATE'])
							->setCellValue('V' . $i, $row ['SYS_UPDATE_DATE'])
							->setCellValue('W' . $i, 'http://rohel.ro/new/cargo/index.php?page=details&id=' . $row['id']);

						$i++;
					}

					$spreadsheet->getActiveSheet()->setTitle('Cargo report');
					$spreadsheet->setActiveSheetIndex(0);

					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
					header('Content-Disposition: attachment;filename="cargo-' . date("d-m-Y") . '.xlsx"');
					header('Cache-Control: max-age=0');

					$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
					$writer->save('php://output');
				} else {
					$spreadsheet->getProperties()->setCreator("ROHEL Web Team")->setLastModifiedBy("ROHEL Web Team")->setTitle("Truck report " . date("d/m/Y"))->setSubject("Truck report")->setDescription("List of all registered trucks at rohel.ro")->setKeywords("truck hauliers")->setCategory("Truck");

					$spreadsheet->setActiveSheetIndex(0)
						->setCellValue('A1', 'From')
						->setCellValue('B1', 'To')
						->setCellValue('C1', 'Available in')
						->setCellValue('D1', 'Available for')
						->setCellValue('E1', 'Available from')
						->setCellValue('F1', 'Available until')
						->setCellValue('G1', 'Details')
						->setCellValue('H1', 'Freight')
						->setCellValue('I1', 'PIC')
						->setCellValue('J1', 'Acceptance')
						->setCellValue('K1', 'Accepted by')
						->setCellValue('L1', 'Plate number')
						->setCellValue('M1', 'AMETA')
						->setCellValue('N1', 'Status')
						->setCellValue('O1', 'Creation date')
						->setCellValue('P1', 'Last change date');

					$results = DB::query("SELECT * FROM cargo_truck WHERE
											(
												originator in (SELECT username FROM cargo_users WHERE " . $condition . ") OR
												recipient in (SELECT username FROM cargo_users WHERE " . $condition . ")
											)  
											and (SYS_CREATION_DATE >= %s) and (SYS_CREATION_DATE <= %s)
											order by SYS_CREATION_DATE",
						date('Y-m-d 00:00:00', strtotime($_SESSION['start_date_reports_plm'])),
						date('Y-m-d 23:59:59', strtotime($_SESSION['end_date_reports_plm'])));

					$i = 2;
					foreach ($results as $row) {
						$status = '';

						switch ($row['status']) {
							case 0:
								$status = 'NEW';
								break;
							case 1:
								$status = 'ACCEPTED';
								break;
							case 2:
								$status = 'EXPIRED';
								break;
							case 3:
								$status = 'CANCELLED';
								break;
							default:
								$status = 'ERROR';
						}

						$spreadsheet->setActiveSheetIndex(0);
						$spreadsheet->getActiveSheet()->getStyle('E' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
						$spreadsheet->getActiveSheet()->getStyle('F' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
						$spreadsheet->getActiveSheet()->getStyle('J' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
						$spreadsheet->getActiveSheet()->getStyle('O' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
						$spreadsheet->getActiveSheet()->getStyle('P' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);

						$spreadsheet->setActiveSheetIndex(0)
							->setCellValue('A' . $i, $row ['originator'])
							->setCellValue('B' . $i, $row ['recipient'])
							->setCellValue('C' . $i, $row ['from_city'])
							->setCellValue('D' . $i, $row ['to_city'])
							->setCellValue('E' . $i, ($row ['availability'] == null) ? 'N/A' : Date::PHPToExcel(strtotime($row ['availability'])))
							->setCellValue('F' . $i, ($row ['expiration'] == null) ? 'N/A' : Date::PHPToExcel(strtotime($row ['expiration'])))
							->setCellValue('G' . $i, ($row ['details'] == null) ? 'N/A' : $row ['details'])
							->setCellValue('H' . $i, ($row ['freight'] == null) ? 'N/A' : $row ['freight'])
							->setCellValue('I' . $i, ($row ['pic'] == null) ? 'N/A' : $row ['pic'])
							->setCellValue('J' . $i, ($row ['acceptance'] == null) ? 'N/A' : Date::PHPToExcel(strtotime($row ['acceptance'])))
							->setCellValue('K' . $i, ($row ['accepted_by'] == null) ? 'N/A' : $row ['accepted_by'])
							->setCellValue('L' . $i, ($row ['plate_number'] == null) ? 'N/A' : $row ['plate_number'])
							->setCellValue('M' . $i, ($row ['ameta'] == null) ? 'N/A' : $row ['ameta'])
							->setCellValue('N' . $i, $status)
							->setCellValue('O' . $i, $row ['SYS_CREATION_DATE'])
							->setCellValue('P' . $i, $row ['SYS_UPDATE_DATE']);
						$i++;
					}

					$spreadsheet->getActiveSheet()->setTitle('Truck report');
					$spreadsheet->setActiveSheetIndex(0);

					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
					header('Content-Disposition: attachment;filename="truck-' . date("d-m-Y") . '.xlsx"');
					header('Cache-Control: max-age=0');

					$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
					$writer->save('php://output');
				}
			} else {
				if ($_GET ['action'] == 2) {
					$spreadsheet->getProperties()->setCreator("ROHEL Web Team")->setLastModifiedBy("ROHEL Web Team")->setTitle("App audit " . date("d/m/Y"))->setSubject("App audit")->setDescription("List of all changes done in the app")->setKeywords("audit")->setCategory("Audit");

					$spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'Date')->setCellValue('B1', 'Operator')->setCellValue('C1', 'IP address')->setCellValue('D1', 'Changed table')->setCellValue('E1', 'Changed field')->setCellValue('F1', 'Key')->setCellValue('G1', 'New value');

					$results = DB::query("SELECT * FROM cargo_audit
											where (SYS_CREATION_DATE >= %s) and (SYS_CREATION_DATE <= %s)
											order by SYS_CREATION_DATE",
						date('Y-m-d 00:00:00', strtotime($_SESSION['start_date_reports_plm'])),
						date('Y-m-d 23:59:59', strtotime($_SESSION['end_date_reports_plm'])));
					$i = 2;
					foreach ($results as $row) {
						$spreadsheet->setActiveSheetIndex(0);
						$spreadsheet->getActiveSheet()->getStyle('A' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);

						$spreadsheet->setActiveSheetIndex(0)
							->setCellValue('A' . $i, Date::PHPToExcel(strtotime($row ['SYS_CREATION_DATE'])))
							->setCellValue('B' . $i, $row ['OPERATOR'])
							->setCellValue('C' . $i, $row ['IP'])
							->setCellValue('D' . $i, $row ['table'])
							->setCellValue('E' . $i, $row ['field'])
							->setCellValue('F' . $i, $row ['key'])
							->setCellValue('G' . $i, $row ['new']);

						$i++;
					}

					$spreadsheet->getActiveSheet()->setTitle('Audit report');
					$spreadsheet->setActiveSheetIndex(0);

					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
					header('Content-Disposition: attachment;filename="audit-' . date("d-m-Y") . '.xlsx"');
					header('Cache-Control: max-age=0');

					$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
					$writer->save('php://output');
				}
			}
		}
		catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
			echo "Excel creation error: " . $e->getMessage();
		}
		catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
			echo "Excel creation error: " . $e->getMessage();
		}

		exit ();
	}
}
else {
	header ( 'Location: index.php' );
	exit ();
}
?>
