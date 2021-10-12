<?php
session_start ();

if (! isset ( $_SESSION ['operator_id'] )) {
	header ( 'Location: index.php?page=login' );
	exit ();
}

include "../lib/settings.php";
include "../lib/db-settings.php";
require "../lib/functions.php";
require_once '../lib/debug.php';

date_default_timezone_set ( 'Europe/Bucharest' );

if (isset ( $_GET ['id'] )) {
	$results = DB::queryFirstRow ( "SELECT * FROM cargo_request where (id=%d)", $_GET['id'] );
	// maybe
	if($results['status'] == 1) {
		$_SESSION ['message'] = '<b style="color: #FF0000">Cargo already ackowledged and cannot be cancelled. Please contact the recepient directly.</b>';
		header ( 'Location: index.php?page=details&id='.$_GET['id'] );
		exit();
	}
	
	if($results['originator'] != $_SESSION['operator']) {
		$_SESSION ['message'] = '<b style="color: #FF0000">You cannot cancel orders created by others.</b>';
		header ( 'Location: index.php?page=details&id='.$_GET['id'] );
		exit();
	}

	DB::update ( 'cargo_request', array (
			'status' => 3
	), "id=%d", $_GET ['id']);

	Utils::cargo_audit('cargo_request', 'status', $_GET['id'], 3);

	DB::commit ();

	$_SESSION ['message'] = "Cargo canceled.";

	// Send any relevant e-mail
    try {
        $mail = new PHPMailer ();
        include "../lib/mail-settings.php";

        $mail->Subject = "Cargo canceled by " . $_SESSION ['operator'];

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

        $mail->addAddress ( $results['recipient'], $results['recipient'] );
        $mail->addAddress ( $_SESSION['operator'], $_SESSION['operator'] );

        ob_start ();
        include_once (dirname ( __FILE__ ) . "/../html/cancelled_cargo.html");
        $body = ob_get_clean ();
        $mail->msgHTML ( $body, dirname ( __FILE__ ), true ); // Create message bodies and embed images

        $mail->send ();
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        $_SESSION['email_error'] = $e->errorMessage(); //Pretty error messages from PHPMailer
    } catch (Exception $e) {
        $_SESSION['email_error'] = $e->getMessage(); //Boring error messages from anything else!
    }
	
	$_SESSION ['message'] = '<p style="color: #00CC00" Cargo cancelled successfuly.<br>Cancellation e-mail sent to '.$results['recipient'].' and '.$_SESSION['operator'].'</p>';
}

header ( 'Location: index.php?page=details&id='.$_GET['id'] );
exit();
?>