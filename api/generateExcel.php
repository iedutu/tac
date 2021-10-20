<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/lib/includes.php";

if (!isset ($_SESSION ['operator']['id'])) {
    header('Location: index.php?page=login');
    exit ();
}

use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Rohel\User;

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
                    $spreadsheet->setActiveSheetIndex(0);

                    // Header format
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:Z1')->getAlignment()->setHorizontal('center');
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:Z1')->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:Z1')->getFont()->getColor()->setRGB(substr(Mails::$TX_FULLY_LOADED_COLOR,1));
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:Z1')->getFill()->setFillType(Fill::FILL_SOLID);
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:Z1')->getFill()->getStartColor()->setRGB(substr(Mails::$BG_FULLY_LOADED_COLOR,1));
                    // $spreadsheet->getActiveSheet()->setAutoFilter('A1:Z1');

                    $spreadsheet->getActiveSheet()
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
                        ->setCellValue('N1', 'Expiration')
                        ->setCellValue('O1', 'Acceptance')
                        ->setCellValue('P1', 'Accepted by')
                        ->setCellValue('Q1', 'Plate number')
                        ->setCellValue('R1', 'AMETA')
                        ->setCellValue('S1', 'Status')
                        ->setCellValue('T1', 'Originator (oofice)')
                        ->setCellValue('U1', 'Originator (country)')
                        ->setCellValue('V1', 'Recipient (office)')
                        ->setCellValue('W1', 'Recipient (country)')
                        ->setCellValue('X1', 'Creation date')
                        ->setCellValue('Y1', 'Last change date')
                        ->setCellValue('Z1', 'URL');

                    $results = DB::getMDB()->query("
                       SELECT
							a.*,
                            b.name as 'recipient_name',
                            b.username as 'recipient_email',
                            d.name as 'recipient_office',
                            f.name as 'recipient_country',
                            c.name as 'originator_name',
                            c.username as 'originator_email',
                            e.name as 'originator_office',
                            g.name as 'originator_country'
                       FROM 
                            cargo_request a,
                            cargo_users b, 
                            cargo_users c, 
                            cargo_offices d, 
                            cargo_offices e,
                            cargo_countries f,
                            cargo_countries g
                       WHERE 
                        (
                            (a.originator_id=b.id and b.office_id=d.id and d.country=f.id)
                            AND
                            (a.recipient_id=c.id and c.office_id=e.id and e.country=g.id)
                        )
						AND
                        (
                             (a.SYS_CREATION_DATE >= STR_TO_DATE(%s, '%%d-%%m-%%Y')) and (a.SYS_CREATION_DATE < (STR_TO_DATE(%s, '%%d-%%m-%%Y') + INTERVAL 1 DAY))
                        )     
						order by a.SYS_CREATION_DATE", $start_date, $end_date);

                    $i = 2;
                    foreach ($results as $row) {
                        $status = '';

                        if($row['accepted_by'] > 0) {
                            $acceptor = DB_utils::selectUserById($row['accepted_by']);
                        }
                        else {
                            $acceptor = null;
                        }

                        switch ($row['status']) {
                            case 1:
                            {
                                $status = 'New';
                                break;
                            }
                            case 2:
                            {
                                $status = 'Accepted';
                                break;
                            }
                            case 3:
                            {
                                $status = 'Closed';
                                break;
                            }
                            case 4:
                            {
                                $status = 'Cancelled';
                                break;
                            }
                            case 5:
                            {
                                $status = 'Expired';
                                break;
                            }
                            default:
                            {
                                $status = 'Error';
                            }
                        }

                        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('N' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('O' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('X' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('Y' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);

                        $spreadsheet->getActiveSheet()
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
                            ->setCellValue('N' . $i, ($row ['expiration'] == null) ? 'N/A' : Date::PHPToExcel(strtotime($row ['expiration'])))
                            ->setCellValue('O' . $i, ($row ['acceptance'] == null) ? 'Not acknowledged' : Date::PHPToExcel(strtotime($row ['acceptance'])))
                            ->setCellValue('P' . $i, ($acceptor == null) ? 'Not acknowledged' : $acceptor->getUsername())
                            ->setCellValue('Q' . $i, ($row ['plate_number'] == null) ? 'N/A' : $row ['plate_number'])
                            ->setCellValue('R' . $i, ($row ['ameta'] == null) ? 'N/A' : $row ['ameta'])
                            ->setCellValue('S' . $i, $status)
                            ->setCellValue('T' . $i, $row['originator_office'])
                            ->setCellValue('U' . $i, $row['originator_country'])
                            ->setCellValue('V' . $i, $row['recipient_office'])
                            ->setCellValue('W' . $i, $row['recipient_country'])
                            ->setCellValue('X' . $i, Date::PHPToExcel(strtotime($row ['SYS_CREATION_DATE'])))
                            ->setCellValue('Y' . $i, Date::PHPToExcel(strtotime($row ['SYS_UPDATE_DATE'])))
                            ->setCellValue('Z' . $i, Utils::$BASE_URL . '/?page=cargoInfo&id=' . $row['id']);

                        $hyperlink = new Hyperlink();
                        $hyperlink->setUrl(Utils::$BASE_URL . '?page=cargoInfo&id=' . $row['id']);
                        $spreadsheet->getActiveSheet()->setHyperlink('Z' . $i, $hyperlink);
                        unset($hyperlink);
                        unset($acceptor);

                        $i++;
                    }

                    $spreadsheet->getActiveSheet()->setTitle('Cargo report');

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
                    $spreadsheet->setActiveSheetIndex(0);

                    // Header format
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:Y1')->getAlignment()->setHorizontal('center');
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:Y1')->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:Y1')->getFont()->getColor()->setRGB(substr(Mails::$TX_FULLY_LOADED_COLOR,1));
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:Y1')->getFill()->setFillType(Fill::FILL_SOLID);
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:Y1')->getFill()->getStartColor()->setRGB(substr(Mails::$BG_FULLY_LOADED_COLOR,1));
                    // $spreadsheet->getActiveSheet()->setAutoFilter('A1:Z1');

                    $spreadsheet->getActiveSheet()
                        ->setCellValue('A1', 'From')
                        ->setCellValue('B1', 'To')
                        ->setCellValue('C1', 'Available in')
                        ->setCellValue('D1', 'Loading date')
                        ->setCellValue('E1', 'Unloading date')
                        ->setCellValue('F1', 'Driver details')
                        ->setCellValue('G1', 'Freight')
                        ->setCellValue('H1', 'Acceptance')
                        ->setCellValue('I1', 'Accepted by')
                        ->setCellValue('J1', 'Plate number')
                        ->setCellValue('K1', 'AMETA')
                        ->setCellValue('L1', 'Status')
                        ->setCellValue('M1', 'Originator (oofice)')
                        ->setCellValue('N1', 'Originator (country)')
                        ->setCellValue('O1', 'Recipient (office)')
                        ->setCellValue('P1', 'Recipient (country)')

                        ->setCellValue('Q1', 'Truck stop (city)')
                        ->setCellValue('R1', 'Truck stop (address)')
                        ->setCellValue('S1', 'CMR')
                        ->setCellValue('T1', 'Loading meters')
                        ->setCellValue('U1', 'Weight')
                        ->setCellValue('V1', 'Volume')

                        ->setCellValue('W1', 'Creation date')
                        ->setCellValue('X1', 'Last change date')
                        ->setCellValue('Y1', 'URL');

                    $results = DB::getMDB()->query("
								SELECT 
       								a.*, 
									b.name as 'recipient_name',
									b.username as 'recipient_email',
									d.name as 'recipient_office',
									f.name as 'recipient_country',
									c.name as 'originator_name',
									c.username as 'originator_email',
									e.name as 'originator_office',
									g.name as 'originator_country'
								FROM 
								    cargo_truck a,
									cargo_users b, 
									cargo_users c, 
									cargo_offices d, 
									cargo_offices e,
								    cargo_countries f,
								    cargo_countries g
							   WHERE 
								(
									(a.originator_id=b.id and b.office_id=d.id and d.country=f.id)
									AND
									(a.recipient_id=c.id and c.office_id=e.id and e.country=g.id)
								)
								AND
								(
                                    (a.SYS_CREATION_DATE >= STR_TO_DATE(%s, '%%d-%%m-%%Y')) and (a.SYS_CREATION_DATE < (STR_TO_DATE(%s, '%%d-%%m-%%Y') + INTERVAL 1 DAY))
                                )     
				    		    order by a.SYS_CREATION_DATE", $start_date, $end_date);

                    $i = 2;
                    foreach ($results as $row) {
                        $status = '';

                        if($row['accepted_by'] > 0) {
                            $acceptor = DB_utils::selectUserById($row['accepted_by']);
                        }
                        else {
                            $acceptor = null;
                        }

                        switch ($row['status']) {
                            case 1:
                            {
                                $status = 'New';
                                break;
                            }
                            case 2:
                            {
                                $status = 'Partially solved';
                                break;
                            }
                            case 3:
                            {
                                $status = 'Fully solved';
                                break;
                            }
                            case 4:
                            {
                                $status = 'Cancelled';
                                break;
                            }
                            default:
                            {
                                $status = 'Error';
                            }
                        }

                        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('W' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('X' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);

                        $stops = DB::getMDB()->query("
								SELECT 
       								*
								FROM 
								    cargo_truck_stops
							    WHERE
								    truck_id=%d
				    		    ORDER BY stop_id", $row['id']);

                        foreach($stops as $stop) {
                            $spreadsheet->getActiveSheet()
                                ->setCellValue('A' . $i, $row ['originator_name'])
                                ->setCellValue('B' . $i, $row ['recipient_name'])
                                ->setCellValue('C' . $i, $row ['from_city'])
                                ->setCellValue('D' . $i, ($row ['loading_date'] == null) ? 'N/A' : Date::PHPToExcel(strtotime($row ['loading_date'])))
                                ->setCellValue('E' . $i, ($row ['unloading_date'] == null) ? 'N/A' : Date::PHPToExcel(strtotime($row ['unloading_date'])))
                                ->setCellValue('F' . $i, ($row ['details'] == null) ? 'N/A' : $row ['details'])
                                ->setCellValue('G' . $i, ($row ['freight'] == null) ? 'N/A' : $row ['freight'])
                                ->setCellValue('H' . $i, ($row ['acceptance'] == null) ? 'Not acknowledged' : Date::PHPToExcel(strtotime($row ['acceptance'])))
                                ->setCellValue('I' . $i, ($acceptor == null) ? 'Not acknowledged' : $acceptor->getUsername())
                                ->setCellValue('J' . $i, ($row ['plate_number'] == null) ? 'N/A' : $row ['plate_number'])
                                ->setCellValue('K' . $i, ($row ['ameta'] == null) ? 'N/A' : $row ['ameta'])
                                ->setCellValue('L' . $i, $status)
                                ->setCellValue('M' . $i, $row['originator_office'])
                                ->setCellValue('N' . $i, $row['originator_country'])
                                ->setCellValue('O' . $i, $row['recipient_office'])
                                ->setCellValue('P' . $i, $row['recipient_country'])

                                ->setCellValue('Q' . $i, $stop['city'])
                                ->setCellValue('R' . $i, $stop['address'])
                                ->setCellValue('S' . $i, $stop['cmr'])
                                ->setCellValue('T' . $i, $stop['loading_meters'])
                                ->setCellValue('U' . $i, $stop['weight'])
                                ->setCellValue('V' . $i, $stop['volume'])

                                ->setCellValue('W' . $i, Date::PHPToExcel(strtotime($row ['SYS_CREATION_DATE'])))
                                ->setCellValue('X' . $i, ($row ['SYS_UPDATE_DATE'] == null) ? '<none>' : Date::PHPToExcel(strtotime($row ['SYS_UPDATE_DATE'])))
                                ->setCellValue('Y' . $i, Utils::$BASE_URL . '?page=truckInfo&id=' . $row['id']);

                                $hyperlink = new Hyperlink();
                                $hyperlink->setUrl(Utils::$BASE_URL . '?page=truckInfo&id=' . $row['id']);
                                $spreadsheet->getActiveSheet()->setHyperlink('Y' . $i, $hyperlink);
                                unset($hyperlink);
                        }
                        $i++;
                    }

                    $spreadsheet->getActiveSheet()->setTitle('Truck report');

                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename="truck-' . date("d-m-Y") . '.xlsx"');
                    header('Cache-Control: max-age=0');

                    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                    $writer->save('php://output');
                    break;
                }
                case 'matches':
                {
                    $spreadsheet->getProperties()->setCreator("ROHEL Web Team")->setLastModifiedBy("ROHEL Web Team")->setTitle("Matches report " . date("d/m/Y"))->setSubject("Truck report")->setDescription("List of all matched trucks on cargo")->setKeywords("truck hauliers")->setCategory("Truck");
                    $spreadsheet->setActiveSheetIndex(0);

                    // Header format
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:S1')->getAlignment()->setHorizontal('center');
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:S1')->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:S1')->getFont()->getColor()->setRGB(substr(Mails::$TX_FULLY_LOADED_COLOR,1));
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:S1')->getFill()->setFillType(Fill::FILL_SOLID);
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:S1')->getFill()->getStartColor()->setRGB(substr(Mails::$BG_FULLY_LOADED_COLOR,1));
                    // $spreadsheet->getActiveSheet()->setAutoFilter('A1:Z1');

                    $spreadsheet->getActiveSheet()
                        ->setCellValue('A1', 'Originator')
                        ->setCellValue('B1', 'Recipient')
                        ->setCellValue('C1', 'Status')
                        ->setCellValue('D1', 'Availability')
                        ->setCellValue('E1', 'On')
                        ->setCellValue('F1', 'In')
                        ->setCellValue('G1', 'To')
                        ->setCellValue('H1', 'Order type')
                        ->setCellValue('I1', 'Loading meters')
                        ->setCellValue('J1', 'Weight')
                        ->setCellValue('K1', 'Volume')
                        ->setCellValue('L1', 'Truck no')
                        ->setCellValue('M1', 'Ameta')
                        ->setCellValue('N1', 'Originator (oofice)')
                        ->setCellValue('O1', 'Originator (country)')
                        ->setCellValue('P1', 'Recipient (office)')
                        ->setCellValue('Q1', 'Recipient (country)')
                        ->setCellValue('R1', 'Creation date')
                        ->setCellValue('S1', 'Last change date');
                    ;

                    $results = DB::getMDB()->query("
								SELECT 
       								a.*, 
									c.name as 'recipient_name',
									c.username as 'recipient_email',
									e.name as 'recipient_office',
									g.name as 'recipient_country',
									b.name as 'originator_name',
									b.username as 'originator_email',
									d.name as 'originator_office',
									f.name as 'originator_country'
								FROM 
								    cargo_match a,
									cargo_users b, 
									cargo_users c, 
									cargo_offices d, 
									cargo_offices e,
								    cargo_countries f,
								    cargo_countries g
							   WHERE 
								(
									(a.originator_id=b.id and b.office_id=d.id and d.country=f.id)
									AND
									(a.recipient_id=c.id and c.office_id=e.id and e.country=g.id)
								)
								AND
								(
                                    (a.SYS_CREATION_DATE >= STR_TO_DATE(%s, '%%d-%%m-%%Y')) and (a.SYS_CREATION_DATE < (STR_TO_DATE(%s, '%%d-%%m-%%Y') + INTERVAL 1 DAY))
                                )     
				    		    order by a.SYS_CREATION_DATE", $start_date, $end_date);

                    $i = 2;
                    foreach ($results as $row) {
                        $status = '';

                        switch ($row['status']) {
                            case 1:
                            {
                                $status = 'Available';
                                break;
                            }
                            case 2:
                            {
                                $status = 'Needed';
                                break;
                            }
                            case 3:
                            {
                                $status = 'Free';
                                break;
                            }
                            case 4:
                            {
                                $status = 'Partially loaded';
                                break;
                            }
                            case 5:
                            {
                                $status = 'Fully loaded';
                                break;
                            }
                        }

                        $spreadsheet->getActiveSheet()->getStyle('E' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('R' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('S' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);

                        $spreadsheet->getActiveSheet()
                            ->setCellValue('A' . $i, $row ['originator_email'])
                            ->setCellValue('B' . $i, $row ['recipient_email'])
                            ->setCellValue('C' . $i, $status)
                            ->setCellValue('E' . $i, ($row ['availability'] == null) ? 'N/A' : Date::PHPToExcel(strtotime($row ['availability'])))
                            ->setCellValue('F' . $i, $row ['from_city'])
                            ->setCellValue('G' . $i, $row ['to_city'])
                            ->setCellValue('H' . $i, $row ['order_type'])
                            ->setCellValue('I' . $i, $row ['loading_meters'])
                            ->setCellValue('J' . $i, $row ['weight'])
                            ->setCellValue('K' . $i, $row ['volume'])
                            ->setCellValue('L' . $i, $row ['plate_number'])
                            ->setCellValue('M' . $i, $row ['ameta'])
                            ->setCellValue('N' . $i, $row['originator_office'])
                            ->setCellValue('O' . $i, $row['originator_country'])
                            ->setCellValue('P' . $i, $row['recipient_office'])
                            ->setCellValue('Q' . $i, $row['recipient_country'])
                            ->setCellValue('R' . $i, Date::PHPToExcel(strtotime($row ['SYS_CREATION_DATE'])))
                            ->setCellValue('S' . $i, ($row ['SYS_UPDATE_DATE'] == null) ? '<none>' :Date::PHPToExcel(strtotime($row ['SYS_UPDATE_DATE'])));
                        $i++;
                    }

                    $spreadsheet->getActiveSheet()->setTitle('Truck report');

                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename="matches-' . date("d-m-Y") . '.xlsx"');
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

            header('Location: /?page='.$_POST['_page']);
            exit ();
        }
    } else {
        header('Location: /?page='.$_POST['_page']);
        exit ();
    }
}