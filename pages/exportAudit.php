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
		catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
			echo "Excel creation error: " . $e->getMessage();
		}
		catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
			echo "Excel general error: " . $e->getMessage();
		}

		exit ();
	}
}
else {
	header ( 'Location: index.php' );
	exit ();
}
?>
