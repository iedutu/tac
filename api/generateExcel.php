<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/lib/includes.php";

if (!isset ($_SESSION ['operator']['id'])) {
    header('Location: index.php?page=login');
    exit ();
}

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

date_default_timezone_set('UTC');

if(!empty($_POST['_submitted'])) {
    $start_date = $_POST['rohel_reports_start'];
    $end_date = $_POST['rohel_reports_end'];

    if (Utils::authorized(Utils::$REPORTS)) {
        $_path = $_SERVER ['HTTP_HOST'] . 'new/'; // TODO - fix
        date_default_timezone_set('Europe/Bucharest');

        $spreadsheet = new Spreadsheet ();
        try {
            switch ($_POST['_page']) {
                case 'cargo':
                {
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

                    $results = DB::getMDB()->query("
                       SELECT
							a.*,
                            b.name as 'recipient_name',
                            b.username as 'recipient_email',
                            d.name as 'recipient_office',
                            d.country as 'recipient_country',
                            c.name as 'originator_name',
                            c.username as 'originator_email',
                            e.name as 'originator_office',
                            e.country as 'originator_country'
                       FROM 
                            cargo_request a,
                            cargo_users b, 
                            cargo_users c, 
                            cargo_offices d, 
                            cargo_offices e
                       WHERE 
                        (
                            (a.originator_id=b.id and b.office_id=d.id)
                            AND
                            (a.recipient_id=c.id and c.office_id=e.id)
                        )
						AND
                        (
                             (a.SYS_CREATION_DATE >= STR_TO_DATE(%s, '%%Y-%%m-%%d')) and (a.SYS_CREATION_DATE < (STR_TO_DATE(%s, '%%Y-%%m-%%d') + INTERVAL 1 DAY))
                        )     
						order by a.SYS_CREATION_DATE", $start_date, $end_date);

                    $i = 2;
                    foreach ($results as $row) {
                        $status = '';

                        switch ($row['status']) {
                            case 1:
                                $status = 'New';
                                break;
                            case 2:
                                $status = 'Accepted';
                                break;
                            case 3:
                                $status = 'Closed';
                                break;
                            case 4:
                                $status = 'Cancelled';
                                break;
                            case 5:
                                $status = 'Expired';
                                break;
                            default:
                                $status = 'Error';
                        }

                        $spreadsheet->setActiveSheetIndex(0);
                        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('O' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('P' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('U' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('V' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);

                        $spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue('A' . $i, $row ['originator_email'])
                            ->setCellValue('B' . $i, $row ['recipient_email'])
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
                            ->setCellValue('N' . $i, 'TODO - remove')
                            ->setCellValue('O' . $i, ($row ['expiration'] == null) ? 'N/A' : Date::PHPToExcel(strtotime($row ['expiration'])))
                            ->setCellValue('P' . $i, ($row ['acceptance'] == null) ? 'N/A' : Date::PHPToExcel(strtotime($row ['acceptance'])))
                            ->setCellValue('Q' . $i, ($row ['accepted_by'] == null) ? 'N/A' : $row ['accepted_by'])
                            ->setCellValue('R' . $i, ($row ['plate_number'] == null) ? 'N/A' : $row ['plate_number'])
                            ->setCellValue('S' . $i, ($row ['ameta'] == null) ? 'N/A' : $row ['ameta'])
                            ->setCellValue('T' . $i, $status)
                            ->setCellValue('U' . $i, $row ['SYS_CREATION_DATE'])
                            ->setCellValue('V' . $i, $row ['SYS_UPDATE_DATE'])
                            ->setCellValue('W' . $i, Utils::$BASE_URL . '/?page=cargoInfo&id=' . $row['id']);

                        $i++;
                    }

                    $spreadsheet->getActiveSheet()->setTitle('Cargo report');
                    $spreadsheet->setActiveSheetIndex(0);

                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename="cargo-' . date("d-m-Y") . '.xlsx"');
                    header('Cache-Control: max-age=0');

                    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                    $writer->save('php://output');
                    break;
                }
                case 'trucks':
                {
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

                    $results = DB::getMDB()->query("
								SELECT 
       								a.*, 
									b.name as 'recipient_name',
									b.username as 'recipient_email',
									d.name as 'recipient_office',
									d.country as 'recipient_country',
									c.name as 'originator_name',
									c.username as 'originator_email',
									e.name as 'originator_office',
									e.country as 'originator_country'
								FROM 
								    cargo_truck a,
									cargo_users b, 
									cargo_users c, 
									cargo_offices d, 
									cargo_offices e							     
							   WHERE 
								(
									(a.originator_id=b.id and b.office_id=d.id)
									AND
									(a.recipient_id=c.id and c.office_id=e.id)
								)
								AND
								(
                                    (a.SYS_CREATION_DATE >= STR_TO_DATE(%s, '%%Y-%%m-%%d')) and (a.SYS_CREATION_DATE < (STR_TO_DATE(%s, '%%Y-%%m-%%d') + INTERVAL 1 DAY))
                                )     
				    		    order by a.SYS_CREATION_DATE", $start_date, $end_date);

                    $i = 2;
                    foreach ($results as $row) {
                        $status = '';

                        switch ($row['status']) {
                            case 0:
                                $status = 'New';
                                break;
                            case 1:
                                $status = 'Partially solved';
                                break;
                            case 2:
                                $status = 'Fully solved';
                                break;
                            case 3:
                                $status = 'Cancelled';
                                break;
                            default:
                                $status = 'Error';
                        }

                        $spreadsheet->setActiveSheetIndex(0);
                        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('J' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('O' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('P' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);

                        $spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue('A' . $i, $row ['originator_name'])
                            ->setCellValue('B' . $i, $row ['recipient_name'])
                            ->setCellValue('C' . $i, $row ['from_city'])
                            ->setCellValue('D' . $i, 'TODO - fix')
                            ->setCellValue('E' . $i, ($row ['availability'] == null) ? 'N/A' : Date::PHPToExcel(strtotime($row ['availability'])))
                            ->setCellValue('F' . $i, ($row ['expiration'] == null) ? 'N/A' : Date::PHPToExcel(strtotime($row ['expiration'])))
                            ->setCellValue('G' . $i, ($row ['details'] == null) ? 'N/A' : $row ['details'])
                            ->setCellValue('H' . $i, ($row ['freight'] == null) ? 'N/A' : $row ['freight'])
                            ->setCellValue('I' . $i, 'TODO - remove')
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
                    break;
                }
                default:
                {

                    break;
                }
            }
        } catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
            error_log("Excel creation error: " . $e->getMessage());
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            error_log("Excel general error: " . $e->getMessage());
        } catch (MeekroDBException $mdbe) {
            error_log("Database error: " . $mdbe->getMessage());
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error (' . $mdbe->getCode() . ':' . $mdbe->getMessage() . '). Please contact your system administrator.';

            header('Location: /');
            exit ();
        } catch (Exception $e) {
            error_log("Database error: " . $e->getMessage());
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error (' . $e->getCode() . ':' . $e->getMessage() . '). Please contact your system administrator.';

            header('Location: /');
            exit ();
        }
    } else {
        header('Location: /');
        exit ();
    }
}