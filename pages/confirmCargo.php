<?php

use PHPMailer\PHPMailer\PHPMailer;

if (! isset ( $_SESSION ['operator']['id'] )) {
	header ( 'Location: /?page=login' );
	exit ();
}

date_default_timezone_set ( 'Europe/Bucharest' );

if (isset ( $_GET ['id'] )) {
	$results = DB::queryFirstRow ( "SELECT * FROM cargo_request where (id=%d)", $_GET['id'] );
	if($results['status'] == 1) {
		$_SESSION ['message'] = '<b style="color: #FF0000">Cargo already acknowledged.</b>';
		header ( 'Location: index.php?page=details&id='.$_GET['id'] );
		exit();
	}
	
	if($results['ameta'] == NULL) {
		$_SESSION ['message'] = '<b style="color: #FF0000">Please update the ameta first.</b>';
		header ( 'Location: index.php?page=details&id='.$_GET['id'] );
		exit();
	}

	if($results['plate_number'] == NULL) {
		$_SESSION ['message'] = '<b style="color: #FF0000">Please update the plate number first.</b>';
		header ( 'Location: index.php?page=details&id='.$_GET['id'] );
		exit();
	}

	DB::update ( 'cargo_request', array (
			'acceptance' => date ( "Y-m-d H:i:s" ),
			'accepted_by' => $_SESSION ['operator'],
			'status' => 1
	), "id=%d", $_GET ['id']);

	Utils::cargo_audit('cargo_request', 'acceptance', $_GET['id'], date ( "Y-m-d H:i:s" ));
	Utils::cargo_audit('cargo_request', 'accepted_by', $_GET['id'], $_SESSION ['operator']);
	Utils::cargo_audit('cargo_request', 'status', $_GET['id'], 1);

	DB::commit ();

	$_SESSION ['message'] = "Cargo acknowledged as accepted.";

	// Send any relevant e-mail
    try {
        $mail = new PHPMailer ();
        include "../lib/mail-settings.php";
        $mail->Subject = "Cargo acknowledged by " . $_SESSION ['operator'];

        $loading_date = 'N/A';
        $unloading_date = 'N/A';

        if(($results['loading_date'] != null) && ($results['loading_date'] != 0)){
            $loading_date = date('Y-m-d', strtotime($results['loading_date']));
        }

        if(($results['unloading_date'] != null) && ($results['unloading_date'] != 0)){
            $unloading_date = date('Y-m-d', strtotime($results['unloading_date']));
        }

        $cargo_details = '
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
                        Recipient:
                    </td>
                    <td>
                        '.$results['recipient'].'
                    </td>
                </tr>
                <tr>
                    <td>
                        Client:
                    </td>
                    <td>
                        '.(($results['client'] == NULL)?'N/A':$results['client']).'
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
                        Loading
                    </td>
                    <td>
                        '.$loading_date.'
                    </td>
                </tr>
                <tr>
                    <td>
                        Unloading
                    </td>
                    <td>
                        '.$unloading_date.'
                    </td>
                </tr>
                <tr>
                    <td>
                        Goods description
                    </td>
                    <td>
                        '.(($results['description'] == NULL)?'N/A':$results['description']).'
                    </td>
                </tr>
                <tr>
                    <td>
                        Number of collies
                    </td>
                    <td>
                        '.(($results['collies'] == NULL)?'N/A':$results['collies']).'
                    </td>
                </tr>
                <tr>
                    <td>
                        Gross weight
                    </td>
                    <td>
                        '.(($results['weight'] == 0)?'N/A':$results['weight']).' kg
                    </td>
                </tr>
                <tr>
                    <td>
                        Volume
                    </td>
                    <td>
                        '.(($results['volume'] == 0)?'N/A':$results['volume']).' cbm
                    </td>
                </tr>
                <tr>
                    <td>
                        Loading meters
                    </td>
                    <td>
                        '.(($results['loading_meters'] == 0)?'N/A':$results['loading_meters']).' m
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
                        '.(($results['plate_number'] == NULL)?'N/A':$results['plate_number']).'
                    </td>
                </tr>
                <tr>
                    <td>
                        AMETA
                    </td>
                    <td>
                        '.(($results['ameta'] == NULL)?'N/A':$results['ameta']).'
                    </td>
                </tr>
            </table>
            ';

        $mail->addAddress ( $results['originator'], $results['originator'] );
        $mail->addAddress ( $_SESSION['operator'], $_SESSION['operator'] );

        ob_start ();
        include_once (dirname ( __FILE__ ) . "/../html/cargo.html");
        $body = ob_get_clean ();
        $mail->msgHTML ( $body, dirname ( __FILE__ ), true ); // Create message bodies and embed images

        // send the message, check for errors
        $mail->send ();
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        $_SESSION['email_error'] = $e->errorMessage(); //Pretty error messages from PHPMailer
    } catch (Exception $e) {
        $_SESSION['email_error'] = $e->getMessage(); //Boring error messages from anything else!
    }

	$_SESSION ['message'] = '<p style="color: #00CC00" Cargo aknowledged as accepted.<br>Acknowledgement e-mail sent to '.$results['originator'].' and '.$_SESSION['operator'].'</p>';
}

header ( 'Location: index.php?page=details&id='.$_GET['id'] );
exit();
?>