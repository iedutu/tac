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
                        ->getStyle('A1:U1')->getAlignment()->setHorizontal('center');
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:U1')->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:U1')->getFont()->getColor()->setRGB(substr(Mails::$TX_FULLY_LOADED_COLOR,1));
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:U1')->getFill()->setFillType(Fill::FILL_SOLID);
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:U1')->getFill()->getStartColor()->setRGB(substr(Mails::$BG_FULLY_LOADED_COLOR,1));
                    $spreadsheet->getActiveSheet()->setAutoFilter('A1:U1');

                    $spreadsheet->getActiveSheet()
                        ->setCellValue('A1', 'From')
                        ->setCellValue('B1', 'To')
                        ->setCellValue('C1', 'Client')
                        ->setCellValue('D1', 'Shipper')
                        ->setCellValue('E1', 'Loading from')
                        ->setCellValue('F1', 'Unloading to')
                        ->setCellValue('G1', 'Loading on')
                        ->setCellValue('H1', 'Unloading on')
                        ->setCellValue('I1', 'Goods description')
                        ->setCellValue('J1', 'Number of collies')
                        ->setCellValue('K1', 'Gross weight')
                        ->setCellValue('L1', 'Volume')
                        ->setCellValue('M1', 'Loading meters')
                        ->setCellValue('N1', 'Dimensions')
                        ->setCellValue('O1', 'Package')
                        ->setCellValue('P1', 'ADR')
                        ->setCellValue('Q1', 'Freight')
                        ->setCellValue('R1', 'Plate number')
                        ->setCellValue('S1', 'AMETA')
                        ->setCellValue('T1', 'Status')
                        ->setCellValue('U1', 'System entry date');

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
							((a.status = %d) AND (NOW() < (a.expiration + INTERVAL 1 DAY))) OR
							((a.status = %d) AND (NOW() < (a.SYS_UPDATE_DATE + INTERVAL %d DAY))) OR
							((a.status = %d) AND (NOW() < (a.SYS_UPDATE_DATE + INTERVAL %d DAY)))
						)
                        AND
                        (
                            (a.recipient_id=b.id and b.office_id=d.id and d.country=f.id)
                            AND
                            (a.originator_id=c.id and c.office_id=e.id and e.country=g.id)
                        )
						AND
                        (
                             (a.SYS_CREATION_DATE >= STR_TO_DATE(%s, '%%d-%%m-%%Y')) and (a.SYS_CREATION_DATE < (STR_TO_DATE(%s, '%%d-%%m-%%Y') + INTERVAL 1 DAY))
                        )     
						order by a.SYS_CREATION_DATE desc",
                            AppStatuses::$CARGO_NEW,
                            AppStatuses::$CARGO_ACCEPTED,
                            Utils::$CARGO_PERIOD_ACCEPTED_EXCEL,
                            AppStatuses::$CARGO_SOLVED,
                            Utils::$CARGO_PERIOD_SOLVED_EXCEL,
                            $start_date,
                            $end_date
                    );

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
                            case AppStatuses::$CARGO_SOLVED:
                            {
                                $status = 'Solved';
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

                        $spreadsheet->getActiveSheet()->getStyle('G' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('H' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                        $spreadsheet->getActiveSheet()->getStyle('U' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);

                        $spreadsheet->getActiveSheet()
                            ->getStyle('T' . $i)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()
                            ->getStyle('T' . $i)->getFont()->getColor()->setRGB(substr($txtColor,1));
                        $spreadsheet->getActiveSheet()
                            ->getStyle('T' . $i)->getFill()->setFillType(Fill::FILL_SOLID);
                        $spreadsheet->getActiveSheet()
                            ->getStyle('T' . $i)->getFill()->getStartColor()->setRGB(substr($bgColor,1));

                        Date::setDefaultTimezone('Europe/Bucharest');

                        $spreadsheet->getActiveSheet()
                            ->setCellValue('A' . $i, $row ['originator_name'])
                            ->setCellValue('B' . $i, $row ['recipient_name'])
                            ->setCellValue('C' . $i, $row ['client'])
                            ->setCellValue('D' . $i, (empty($row ['shipper']) ? 'N/A' : $row ['shipper']))
                            ->setCellValue('E' . $i, $row ['from_city'])
                            ->setCellValue('F' . $i, $row ['to_city'])
                            ->setCellValue('G' . $i, (empty($row ['loading_date']) ? 'N/A' : Date::PHPToExcel(new DateTime($row ['loading_date'], new DateTimeZone(Utils::$TIMEZONE)))))
                            ->setCellValue('H' . $i, (empty($row ['unloading_date']) ? 'N/A' : Date::PHPToExcel(new DateTime($row ['unloading_date'], new DateTimeZone(Utils::$TIMEZONE)))))
                            ->setCellValue('I' . $i, (empty($row ['description']) ? 'N/A' : $row ['description']))
                            ->setCellValue('J' . $i, (empty($row ['collies']) ? 'N/A' : $row ['collies']))
                            ->setCellValue('K' . $i, $row ['weight'])
                            ->setCellValue('L' . $i, $row ['volume'])
                            ->setCellValue('M' . $i, $row ['loading_meters'])
                            ->setCellValue('N' . $i, $row ['dimensions'])
                            ->setCellValue('O' . $i, $row ['package'])
                            ->setCellValue('P' . $i, (empty($row ['adr']) ? 'N/A' : $row ['adr']))
                            ->setCellValue('Q' . $i, (empty($row ['freight']) ? 'N/A' : $row ['freight']))
                            ->setCellValue('R' . $i, (empty($row ['plate_number']) ? 'N/A' : $row ['plate_number']))
                            ->setCellValue('S' . $i, (empty($row ['ameta']) ? 'N/A' : $row ['ameta']))
                            ->setCellValue('T' . $i, $status)
                            ->setCellValue('U' . $i, (empty($row ['SYS_CREATION_DATE']) ? 'N/A' : Date::PHPToExcel(new DateTime($row ['SYS_CREATION_DATE'], new DateTimeZone(Utils::$TIMEZONE)))));

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
                        ->getStyle('A1:U1')->getAlignment()->setHorizontal('center');
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:U1')->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:U1')->getFont()->getColor()->setRGB(substr(Mails::$TX_FULLY_LOADED_COLOR,1));
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:U1')->getFill()->setFillType(Fill::FILL_SOLID);
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:U1')->getFill()->getStartColor()->setRGB(substr(Mails::$BG_FULLY_LOADED_COLOR,1));
                    $spreadsheet->getActiveSheet()->setAutoFilter('A1:U1');

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
                        ->setCellValue('K1', 'Client')
                        ->setCellValue('L1', 'Unloading zone')
                        ->setCellValue('M1', 'Retour loading from')
                        ->setCellValue('N1', 'Retour unloading from')
                        ->setCellValue('O1', 'Retour loading date')
                        ->setCellValue('P1', 'Retour unloading date')

                        ->setCellValue('Q1', 'Truck stop (city)')
                        ->setCellValue('R1', 'Loading meters')
                        ->setCellValue('S1', 'Weight')
                        ->setCellValue('T1', 'Volume')

                        ->setCellValue('U1', 'System entry date');

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
                                    (a.recipient_id=b.id and b.office_id=d.id and d.country=f.id)
                                    AND
                                    (a.originator_id=c.id and c.office_id=e.id and e.country=g.id)
								    AND
                                    (
                                        (a.status < %d)
                                        OR 
                                        (
                                            (a.status = %d)
                                            AND
                                            (NOW() < DATE_ADD(a.SYS_UPDATE_DATE, INTERVAL %d DAY))
                                        )
                                        OR 
                                        (
                                            (a.status = %d)
                                            AND
                                            (NOW() < DATE_ADD(a.SYS_UPDATE_DATE, INTERVAL %d DAY))
                                        )
                                    )
								)
								AND
								(
                                    (a.SYS_CREATION_DATE >= STR_TO_DATE(%s, '%%d-%%m-%%Y')) and (a.SYS_CREATION_DATE < (STR_TO_DATE(%s, '%%d-%%m-%%Y') + INTERVAL 1 DAY))
                                )
				    		    order by a.SYS_CREATION_DATE desc",
                                    AppStatuses::$TRUCK_PARTIALLY_SOLVED,
                                    AppStatuses::$TRUCK_PARTIALLY_SOLVED,
                                    Utils::$PARTIAL_TRUCK_DAYS_EXCEL,
                                    AppStatuses::$TRUCK_FULLY_SOLVED,
                                    Utils::$SOLVED_TRUCK_DAYS_EXCEL,
                                    $start_date,
                                    $end_date);

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
                            case AppStatuses::$TRUCK_MARKET:
                            {
                                $status = 'Market';
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
                                $status = 'Solved';
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
                            $spreadsheet->getActiveSheet()->getStyle('O' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                            $spreadsheet->getActiveSheet()->getStyle('P' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
                            $spreadsheet->getActiveSheet()->getStyle('U' . $i)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);

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
                                ->setCellValue('K' . $i, (empty($row['client'])? 'N/A': $row['client']))
                                ->setCellValue('L' . $i, (empty($row['unloading_zone'])? 'N/A': $row['unloading_zone']))
                                ->setCellValue('M' . $i, (empty($row['retour_loading_from'])? 'N/A': $row['retour_loading_from']))
                                ->setCellValue('N' . $i, (empty($row['retour_unloading_from'])? 'N/A': $row['retour_unloading_from']))
                                ->setCellValue('O' . $i, (empty($row ['retour_loading_date']) ? 'N/A' : Date::PHPToExcel(new DateTime($row ['retour_loading_date'], new DateTimeZone(Utils::$TIMEZONE)))))
                                ->setCellValue('P' . $i, (empty($row ['retour_unloading_date']) ? 'N/A' : Date::PHPToExcel(new DateTime($row ['retour_unloading_date'], new DateTimeZone(Utils::$TIMEZONE)))))

                                ->setCellValue('Q' . $i, $stop['city'])
                                ->setCellValue('R' . $i, $stop['loading_meters'])
                                ->setCellValue('S' . $i, $stop['weight'])
                                ->setCellValue('T' . $i, $stop['volume'])

                                ->setCellValue('U' . $i, (empty($row ['SYS_CREATION_DATE']) ? 'N/A' : Date::PHPToExcel(new DateTime($row ['SYS_CREATION_DATE'], new DateTimeZone(Utils::$TIMEZONE)))));
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
                        ->getStyle('A1:O1')->getAlignment()->setHorizontal('center');
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:O1')->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:O1')->getFont()->getColor()->setRGB(substr(Mails::$TX_FULLY_LOADED_COLOR,1));
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:O1')->getFill()->setFillType(Fill::FILL_SOLID);
                    $spreadsheet->getActiveSheet()
                        ->getStyle('A1:O1')->getFill()->getStartColor()->setRGB(substr(Mails::$BG_FULLY_LOADED_COLOR,1));
                    $spreadsheet->getActiveSheet()->setAutoFilter('A1:O1');

                    $spreadsheet->getActiveSheet()
                        ->setCellValue('A1', 'Originator')
                        ->setCellValue('B1', 'Recipient')
                        ->setCellValue('C1', 'Truck status')
                        ->setCellValue('D1', 'On')
                        ->setCellValue('E1', 'In')
                        ->setCellValue('F1', 'To')
                        ->setCellValue('G1', 'Shipper')
                        ->setCellValue('H1', 'Order type')
                        ->setCellValue('I1', 'Loading meters')
                        ->setCellValue('J1', 'Weight')
                        ->setCellValue('K1', 'Volume')
                        ->setCellValue('L1', 'ADR')
                        ->setCellValue('M1', 'Truck no')
                        ->setCellValue('N1', 'Driver details')
                        ->setCellValue('O1', 'AMETA');
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
				    		    order by a.item_date desc", $start_date, $end_date);

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
                            case AppStatuses::$MATCH_MARKET:
                            {
                                $status = 'Market';
                                $bgColor = Mails::$BG_DARK_COLOR;
                                $txtColor = Mails::$TX_DARK_COLOR;
                                break;
                            }
                            case AppStatuses::$MATCH_PARTIAL:
                            {
                                $status = 'Partially solved';
                                $bgColor = Mails::$BG_WARNING_COLOR;
                                $txtColor = Mails::$TX_WARNING_COLOR;
                                break;
                            }
                            case AppStatuses::$MATCH_SOLVED:
                            {
                                $status = 'Solved';
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
                            ->setCellValue('G' . $i, (empty($row ['shipper']) ? 'N/A' : $row ['shipper']))
                            ->setCellValue('H' . $i, $row ['order_type'])
                            ->setCellValue('I' . $i, $row ['loading_meters'])
                            ->setCellValue('J' . $i, $row ['weight'])
                            ->setCellValue('K' . $i, $row ['volume'])
                            ->setCellValue('L' . $i, (empty($row ['adr']) ? 'N/A' : $row ['adr']))
                            ->setCellValue('M' . $i, (empty($row ['plate_number']) ? 'N/A' : $row ['plate_number']))
                            ->setCellValue('N' . $i, (empty($row ['details']) ? 'N/A' : $row ['details']))
                            ->setCellValue('O' . $i, (empty($row ['ameta']) ? 'N/A' : $row ['ameta']));
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