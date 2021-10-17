<?php

use PHPMailer\PHPMailer\PHPMailer;

session_start ();

if (! isset ( $_SESSION ['operator']['id'] )) {
	header ( 'Location: /?page=login' );
	exit ();
}

date_default_timezone_set ( 'Europe/Bucharest' );

if (isset ( $_GET ['id'] )) {
	$results = DB::queryFirstRow ( "SELECT * FROM cargo_truck where (id=%d)", $_GET['id'] );
	if($results['status'] == 1) {
		$_SESSION ['message'] = '<b style="color: #FF0000">Truck already accepted by '.$results['accepted_by'].'.</b>';
		header ( 'Location: index.php?page=details&id='.$_GET['id'] );
		exit();
	}
	
	DB::update ( 'cargo_truck', array (
			'acceptance' => date ( "Y-m-d H:i:s" ),
			'accepted_by' => $_SESSION ['operator'],
			'status' => 1
	), "id=%d", $_GET ['id']);

	Utils::insertCargoAuditEntry('cargo_truck', 'acceptance', $_GET['id'], date ( "Y-m-d H:i:s" ));
	Utils::insertCargoAuditEntry('cargo_truck', 'accepted_by', $_GET['id'], $_SESSION ['operator']);
	Utils::insertCargoAuditEntry('cargo_truck', 'status', $_GET['id'], 1);

	DB::commit ();

	$_SESSION ['message'] = "Truck acknowledged as accepted.";

	// Send any relevant e-mail
    try {
        $mail = new PHPMailer ();
        include "../lib/mail-settings.php";

        $mail->Subject = "Truck accepted by " . $_SESSION ['operator'];

        $availability = 'N/A';
        $expiration = 'N/A';

        if(($results['availability'] != null) && ($results['availability'] != 0)){
            $availability = date('Y-m-d', strtotime($results['availability']));
        }

        if(($results['expiration'] != null) && ($results['expiration'] != 0)){
            $expiration = date('Y-m-d', strtotime($results['expiration']));
        }

        $truck_details = '
            <table border="0" cellpadding="2" cellspacing="0" class="message">
                <tr>
                    <td>
                        Originator:
                    </td>
                    <td>
                        '.$results['originator'].'
                    </td>
                </tr>
                <tr>
                    <td>
                        From:
                    </td>
                    <td>
                        '.$results['from_city'].'
                    </td>
                </tr>
                <tr>
                    <td>
                        To:
                    </td>
                    <td>
                        '.$results['to_city'].'
                    </td>
                </tr>
                <tr>
                    <td>
                        Availability
                    </td>
                    <td>
                        '.$availability.'
                    </td>
                </tr>
                <tr>
                    <td>
                        Expiration
                    </td>
                    <td>
                        '.$expiration.'
                    </td>
                </tr>
                <tr>
                    <td>
                        Truck details
                    </td>
                    <td>
                        '.(($results['details'] == NULL)?'N/A':$results['details']).'
                    </td>
                </tr>
                <tr>
                    <td>
                        Freight
                    </td>
                    <td>
                        '.(($results['freight'] == NULL)?'N/A':$results['freight']).'
                    </td>
                </tr>
                <tr>
                    <td>
                        PIC
                    </td>
                    <td>
                        '.(($results['pic'] == NULL)?'N/A':$results['pic']).'
                    </td>
                </tr>
                <tr>
                    <td>
                        Plate number
                    </td>
                    <td>
                        '.$results['plate_number'].'
                    </td>
                </tr>
                <tr>
                    <td>
                        AMETA
                    </td>
                    <td>
                        '.$results['ameta'].'
                    </td>
                </tr>
            </table>
            ';

        $mail->addAddress ( $results['originator'], $results['originator'] );
        $mail->addAddress ( $_SESSION['operator'], $_SESSION['operator'] );

        ob_start ();
        include_once (dirname ( __FILE__ ) . "/../html/truck.html");
        $body = ob_get_clean ();
        $mail->msgHTML ( $body, dirname ( __FILE__ ), true ); // Create message bodies and embed images

        $mail->send ();
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        $_SESSION['email_error'] = $e->errorMessage(); //Pretty error messages from PHPMailer
    } catch (Exception $e) {
        $_SESSION['email_error'] = $e->getMessage(); //Boring error messages from anything else!
    }
	
	$_SESSION ['message'] = '<p style="color: #00CC00" Truck acknowledged as accepted.<br>Acceptance e-mail sent to '.$results['originator'].' and '.$_SESSION['operator'].'</p>';
}

header ( 'Location: index.php?page=details&id='.$_GET['id'] );
exit();
?>