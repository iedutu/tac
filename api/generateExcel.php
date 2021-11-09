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

if(!empty($_POST['_submitted'])) {
    $start_date = $_POST['rohel_reports_start'];
    $end_date = $_POST['rohel_reports_end'];

    if (Utils::authorized(Utils::$REPORTS)) {
        $_path = $_SERVER ['HTTP_HOST'] . 'new/'; // TODO - fix

        $spreadsheet = new Spreadsheet ();

        try {
            switch ($_POST['_page']) {
                case 'cargo':
                {
                    $spreadsheet->getProperties()->setCreator("ROHEL Web Team")->setLastModifiedBy("ROHEL Web Team")->setTitle("Cargo report " . date("d/m/Y"))->setSubject("Cargo report")->setDescription("List of all registered cargo at rohel.ro")->setKeywords("cargo hauliers")->setCategory("Cargo");
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
                    $spreadsheet->getActiveSheet()->setAutoFilter('A1:S1');

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
                        ->setCellValue('M1', 'Dimensions')
                        ->setCellValue('N1', 'Package')
                        ->setCellValue('O1', 'ADR')
                        ->setCellValue('P1', 'Freight')
                        ->setCellValue('Q1', 'Plate number')
                        ->setCellValue('R1', 'AMETA')
                        ->setCellValue('S1', 'Status');

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

                        $bgColor = '#FFFFFF';
                        $txtColor = '#000000';
                        switch ($row['status']) {
                            case AppStatuses::$CARGO_NEW:
                            {
                                $status = 'New';
                                $bgColor = Mails::$BG_DANGER_COLOR;
                                $txtColor = Mails::$TX_DANGER_COLOR;
                                break;
                            }
                            case AppStatuses::$CARGO_ACCEPTED:
                            {
                                $status = 'Accepted';
                                $bgColor = Mails::$BG_SUCCESS_COLOR;
                                $txtColor = Mails::$TX_SUCCESS_COLOR;
                                break;
                            }
                            case AppStatuses::$CARGO_CLOSED:
                            {
                                $status = 'Closed';
                                $bgColor = Mails::$BG_SUCCESS_COLOR;
                                $txtColor = Mails::$TX_SUCCESS_COLOR;
                                break;
                            }
                            case AppStatuses::$CARGO_CANCELLED:
                            {
                                $status = 'Cancelled';
                                $bgColor = Mails::$BG_LIGHT_COLOR;
                                $txtColor = Mails::$TX_LIGHT_COLOR;
                                break;
                            }
                            case AppStatuses::$CARGO_EXPIRED:
                            {
                                $status = 'Expired';
                                $bgColor = Mails::$BG_LIGHT_COLOR;
                                $txtColor = Mails::$TX_LIGHT_COLOR;
                                break;
                            }
                            default:
                            {
                                $status = 'Error';
                                $bgColor = Mails::$BG_LIGHT_COLOR;
                                $txtColor = Mails::$TX_LIGHT_COLOR;
                            }
                        }

                        $spreadsheet->getActiveSheet()->getStyle('F' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);

                        $spreadsheet->getActiveSheet()
                            ->getStyle('S' . $i)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()
                            ->getStyle('S' . $i)->getFont()->getColor()->setRGB(substr($txtColor,1));
                        $spreadsheet->getActiveSheet()
                            ->getStyle('S' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $spreadsheet->getActiveSheet()
                            ->getStyle('S' . $i)->getFill()->getStartColor()->setRGB(substr($bgColor,1));

                        Date::setDefaultTimezone('Europe/Bucharest');

                        $spreadsheet->getActiveSheet()
                            ->setCellValue('A' . $i, $row ['originator_name'])
                            ->setCellValue('B' . $i, $row ['recipient_name'])
                            ->setCellValue('C' . $i, $row ['client'])
                            ->setCellValue('D' . $i, $row ['from_city'])
                            ->setCellValue('E' . $i, $row ['to_city'])
                            ->setCellValue('F' . $i, (empty($row ['loading_date']) ? 'N/A' : Date::PHPToExcel(new DateTime($row ['loading_date'], new DateTimeZone(Utils::$TIMEZONE)))))
                            ->setCellValue('G' . $i, (empty($row ['unloading_date']) ? 'N/A' : Date::PHPToExcel(new DateTime($row ['unloading_date'], new DateTimeZone(Utils::$TIMEZONE)))))
                            ->setCellValue('H' . $i, (empty($row ['description']) ? 'N/A' : $row ['description']))
                            ->setCellValue('I' . $i, (empty($row ['collies']) ? 'N/A' : $row ['collies']))
                            ->setCellValue('J' . $i, $row ['weight'])
                            ->setCellValue('K' . $i, $row ['volume'])
                            ->setCellValue('L' . $i, $row ['loading_meters'])
                            ->setCellValue('M' . $i, $row ['dimensions'])
                            ->setCellValue('N' . $i, $row ['package'])
                            ->setCellValue('O' . $i, (empty($row ['adr']) ? 'N/A' : $row ['adr']))
                            ->setCellValue('P' . $i, (empty($row ['freight']) ? 'N/A' : $row ['freight']))
                            ->setCellValue('Q' . $i, (empty($row ['plate_number']) ? 'N/A' : $row ['plate_number']))
                            ->setCellValue('R' . $i, (empty($row ['ameta']) ? 'N/A' : $row ['ameta']))
                            ->setCellValue('S' . $i, $status);

                        /*
                        $hyperlink = new Hyperlink();
                        $hyperlink->setUrl(Utils::$BASE_URL . '?page=cargoInfo&id=' . $row['id']);
                        $spreadsheet->getActiveSheet()->setHyperlink('AB' . $i, $hyperlink);
                        unset($hyperlink);
                        */
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
                        ->getStyle('A1:N1')->getAlignment()->setHorizontal('center');
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:N1')->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:N1')->getFont()->getColor()->setRGB(substr(Mails::$TX_FULLY_LOADED_COLOR,1));
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:N1')->getFill()->setFillType(Fill::FILL_SOLID);
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:N1')->getFill()->getStartColor()->setRGB(substr(Mails::$BG_FULLY_LOADED_COLOR,1));
                    $spreadsheet->getActiveSheet()->setAutoFilter('A1:N1');

                    $spreadsheet->getActiveSheet()
                        ->setCellValue('A1', 'From')
                        ->setCellValue('B1', 'To')
                        ->setCellValue('C1', 'Available in')
                        ->setCellValue('D1', 'Loading date')
                        ->setCellValue('E1', 'Unloading date')
                        ->setCellValue('F1', 'Driver details')
                        ->setCellValue('G1', 'Freight')
                        ->setCellValue('H1', 'Plate number')
                        ->setCellValue('I1', 'AMETA')
                        ->setCellValue('J1', 'Status')

                        ->setCellValue('K1', 'Truck stop (city)')
                        ->setCellValue('L1', 'Loading meters')
                        ->setCellValue('M1', 'Weight')
                        ->setCellValue('N1', 'Volume');

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

                        $bgColor = '#FFFFFF';
                        $txtColor = '#000000';
                        switch ($row['status']) {
                            case AppStatuses::$TRUCK_AVAILABLE:
                            {
                                $status = 'Available';
                                $bgColor = Mails::$BG_SECONDARY_COLOR;
                                $txtColor = Mails::$TX_SECONDARY_COLOR;
                                break;
                            }
                            case AppStatuses::$TRUCK_FREE:
                            {
                                $status = 'Free';
                                $bgColor = Mails::$BG_INFO_COLOR;
                                $txtColor = Mails::$TX_INFO_COLOR;
                                break;
                            }
                            case AppStatuses::$TRUCK_NEW:
                            {
                                $status = 'New';
                                $bgColor = Mails::$BG_DARK_COLOR;
                                $txtColor = Mails::$TX_DARK_COLOR;
                                break;
                            }
                            case AppStatuses::$TRUCK_PARTIALLY_SOLVED:
                            {
                                $status = 'Partially solved';
                                $bgColor = Mails::$BG_WARNING_COLOR;
                                $txtColor = Mails::$TX_WARNING_COLOR;
                                break;
                            }
                            case AppStatuses::$TRUCK_FULLY_SOLVED:
                            {
                                $status = 'Fully solved';
                                $bgColor = Mails::$BG_SUCCESS_COLOR;
                                $txtColor = Mails::$TX_SUCCESS_COLOR;
                                break;
                            }
                            case AppStatuses::$TRUCK_CANCELLED:
                            {
                                $status = 'Cancelled';
                                $bgColor = Mails::$BG_LIGHT_COLOR;
                                $txtColor = Mails::$TX_LIGHT_COLOR;
                                break;
                            }
                            default:
                            {
                                $status = 'Error';
                                $bgColor = Mails::$BG_LIGHT_COLOR;
                                $txtColor = Mails::$TX_LIGHT_COLOR;
                            }
                        }

                        $stops = DB::getMDB()->query("
								SELECT 
       								*
								FROM 
								    cargo_truck_stops
							    WHERE
								    truck_id=%d
				    		    ORDER BY stop_id", $row['id']);

                        foreach($stops as $stop) {
                            $spreadsheet->getActiveSheet()->getStyle('D' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                            $spreadsheet->getActiveSheet()->getStyle('E' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);

                            $spreadsheet->getActiveSheet()
                                ->getStyle('J' . $i)->getFont()->setBold(true);
                            $spreadsheet->getActiveSheet()
                                ->getStyle('J' . $i)->getFont()->getColor()->setRGB(substr($txtColor,1));
                            $spreadsheet->getActiveSheet()
                                ->getStyle('J' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                            $spreadsheet->getActiveSheet()
                                ->getStyle('J' . $i)->getFill()->getStartColor()->setRGB(substr($bgColor,1));

                            $spreadsheet->getActiveSheet()
                                ->setCellValue('A' . $i, $row ['originator_name'])
                                ->setCellValue('B' . $i, $row ['recipient_name'])
                                ->setCellValue('C' . $i, $row ['from_city'])
                                ->setCellValue('D' . $i, (empty($row ['loading_date']) ? 'N/A' : Date::PHPToExcel(new DateTime($row ['loading_date'], new DateTimeZone(Utils::$TIMEZONE)))))
                                ->setCellValue('E' . $i, (empty($row ['unloading_date']) ? 'N/A' : Date::PHPToExcel(new DateTime($row ['unloading_date'], new DateTimeZone(Utils::$TIMEZONE)))))
                                ->setCellValue('F' . $i, ($row ['details'] == null) ? 'N/A' : $row ['details'])
                                ->setCellValue('G' . $i, ($row ['freight'] == null) ? 'N/A' : $row ['freight'])
                                ->setCellValue('H' . $i, ($row ['plate_number'] == null) ? 'N/A' : $row ['plate_number'])
                                ->setCellValue('I' . $i, ($row ['ameta'] == null) ? 'N/A' : $row ['ameta'])
                                ->setCellValue('J' . $i, $status)

                                ->setCellValue('K' . $i, $stop['city'])
                                ->setCellValue('L' . $i, $stop['loading_meters'])
                                ->setCellValue('M' . $i, $stop['weight'])
                                ->setCellValue('N' . $i, $stop['volume']);

                            /*
                            $hyperlink = new Hyperlink();
                            $hyperlink->setUrl(Utils::$BASE_URL . '?page=truckInfo&id=' . $row['id']);
                            $spreadsheet->getActiveSheet()->setHyperlink('Y' . $i, $hyperlink);
                            unset($hyperlink);
                            */

                            $i++;
                        }
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
                        ->getStyle('A1:N1')->getAlignment()->setHorizontal('center');
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:N1')->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:N1')->getFont()->getColor()->setRGB(substr(Mails::$TX_FULLY_LOADED_COLOR,1));
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:N1')->getFill()->setFillType(Fill::FILL_SOLID);
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:N1')->getFill()->getStartColor()->setRGB(substr(Mails::$BG_FULLY_LOADED_COLOR,1));
                    $spreadsheet->getActiveSheet()->setAutoFilter('A1:N1');

                    $spreadsheet->getActiveSheet()
                        ->setCellValue('A1', 'Originator')
                        ->setCellValue('B1', 'Recipient')
                        ->setCellValue('C1', 'Truck status')
                        ->setCellValue('D1', 'On')
                        ->setCellValue('E1', 'In')
                        ->setCellValue('F1', 'To')
                        ->setCellValue('G1', 'Order type')
                        ->setCellValue('H1', 'Loading meters')
                        ->setCellValue('I1', 'Weight')
                        ->setCellValue('J1', 'Volume')
                        ->setCellValue('K1', 'ADR')
                        ->setCellValue('L1', 'Truck no')
                        ->setCellValue('M1', 'Driver details')
                        ->setCellValue('N1', 'AMETA');
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
                        $bgColor = '#FFFFFF';
                        $txtColor = '#000000';
                        switch ($row['status']) {
                            case AppStatuses::$MATCH_AVAILABLE:
                            {
                                $status = 'Available';
                                $bgColor = Mails::$BG_SECONDARY_COLOR;
                                $txtColor = Mails::$TX_SECONDARY_COLOR;
                                break;
                            }
                            case AppStatuses::$MATCH_NEEDED:
                            {
                                $status = 'Needed';
                                $bgColor = Mails::$BG_DANGER_COLOR;
                                $txtColor = Mails::$TX_DANGER_COLOR;
                                break;
                            }
                            case AppStatuses::$MATCH_FREE:
                            {
                                $status = 'Free';
                                $bgColor = Mails::$BG_INFO_COLOR;
                                $txtColor = Mails::$TX_INFO_COLOR;
                                break;
                            }
                            case AppStatuses::$MATCH_NEW:
                            {
                                $status = 'New';
                                $bgColor = Mails::$BG_DARK_COLOR;
                                $txtColor = Mails::$TX_DARK_COLOR;
                                break;
                            }
                            case AppStatuses::$MATCH_PARTIAL:
                            {
                                $status = 'Partially loaded';
                                $bgColor = Mails::$BG_WARNING_COLOR;
                                $txtColor = Mails::$TX_WARNING_COLOR;
                                break;
                            }
                            case AppStatuses::$MATCH_SOLVED:
                            {
                                $status = 'Fully loaded';
                                $bgColor = Mails::$BG_SUCCESS_COLOR;
                                $txtColor = Mails::$TX_SUCCESS_COLOR;
                                break;
                            }
                            default:
                            {
                                $status = 'Error';
                                $bgColor = Mails::$BG_LIGHT_COLOR;
                                $txtColor = Mails::$TX_LIGHT_COLOR;
                                break;
                            }
                        }

                        $spreadsheet->getActiveSheet()->getStyle('D' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);

                        $spreadsheet->getActiveSheet()
                            ->getStyle('C' . $i)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()
                            ->getStyle('C' . $i)->getFont()->getColor()->setRGB(substr($txtColor,1));
                        $spreadsheet->getActiveSheet()
                            ->getStyle('C' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $spreadsheet->getActiveSheet()
                            ->getStyle('C' . $i)->getFill()->getStartColor()->setRGB(substr($bgColor,1));

                        $spreadsheet->getActiveSheet()
                            ->setCellValue('A' . $i, $row ['originator_name'])
                            ->setCellValue('B' . $i, $row ['recipient_name'])
                            ->setCellValue('C' . $i, $status)
                            ->setCellValue('D' . $i, (empty($row ['availability']) ? 'N/A' : Date::PHPToExcel(new DateTime($row ['availability'], new DateTimeZone(Utils::$TIMEZONE)))))
                            ->setCellValue('E' . $i, $row ['from_city'])
                            ->setCellValue('F' . $i, $row ['to_city'])
                            ->setCellValue('G' . $i, $row ['order_type'])
                            ->setCellValue('H' . $i, $row ['loading_meters'])
                            ->setCellValue('I' . $i, $row ['weight'])
                            ->setCellValue('J' . $i, $row ['volume'])
                            ->setCellValue('K' . $i, (empty($row ['adr']) ? 'N/A' : $row ['adr']))
                            ->setCellValue('L' . $i, (empty($row ['plate_number']) ? 'N/A' : $row ['plate_number']))
                            ->setCellValue('M' . $i, (empty($row ['details']) ? 'N/A' : $row ['details']))
                            ->setCellValue('N' . $i, (empty($row ['ameta']) ? 'N/A' : $row ['ameta']));
                        $i++;
                    }

                    $spreadsheet->getActiveSheet()->setTitle('Matches report');

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
            AppLogger::getLogger()->error("Excel creation error: " . $e->getMessage());
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            AppLogger::getLogger()->error("Excel general error: " . $e->getMessage());
        } catch (MeekroDBException $mdbe) {
            AppLogger::getLogger()->error("Database error: " . $mdbe->getMessage());
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error (' . $mdbe->getCode() . ':' . $mdbe->getMessage() . '). Please contact your system administrator.';

            header('Location: /');
            exit ();
        } catch (Exception $e) {
            AppLogger::getLogger()->error("Database error: " . $e->getMessage());
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