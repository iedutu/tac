<?php
session_start ();

if (! isset ( $_SESSION ['operator_id'] )) {
	header ( 'Location: index.php?page=login' );
	exit ();
}

include_once "../lib/mysql.php";
include_once "../lib/functions.php";

require_once '../lib/mailer/PHPMailerAutoload.php';
require_once '../lib/debug.php';

date_default_timezone_set ( 'Europe/Bucharest' );

if (isset ( $_GET ['id'] )) {
	$results = DB::queryFirstRow ( "SELECT * FROM cargo_truck where (id=%d)", $_GET['id'] );
	// maybe
	if($results['status'] == 1) {
		$_SESSION ['message'] = '<b style="color: #FF0000">Truck already ackowledged and cannot be cancelled. Please contact the recepient directly.</b>';
		header ( 'Location: index.php?page=details&id='.$_GET['id'] );
		exit();
	}
	
	if($results['originator'] != $_SESSION['operator']) {
		$_SESSION ['message'] = '<b style="color: #FF0000">You cannot cancel orders created by others.</b>';
		header ( 'Location: index.php?page=details&id='.$_GET['id'] );
		exit();
	}

	DB::update ( 'cargo_truck', array (
			'status' => 3
	), "id=%d", $_GET ['id']);

	Utils::cargo_audit('cargo_truck', 'status', $_GET['id'], 3);

	DB::commit ();

	$_SESSION ['message'] = "Truck canceled.";

	// Send any relevant e-mail
    try {
        $mail = new PHPMailer ();
        include "../lib/mail-settings.php";

        $mail->Subject = "Truck canceled by " . $_SESSION ['operator'];

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
                            '.$_SESSION['operator'].'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Recipient:
                        </td>
                        <td>
                            '.$_POST['_recipient'].'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Available in:
                        </td>
                        <td>
                            '.$_POST['_from'].'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Available for:
                        </td>
                        <td>
                            '.$_POST['_to'].'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Available from:
                        </td>
                        <td>
                            '.(($_POST ['_availability']=='')?null:$_POST ['_availability']).'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Available until:
                        </td>
                        <td>
                            '.(($_POST ['_expiration']=='')?null:$_POST ['_expiration']).'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Details
                        </td>
                        <td>
                            '.(($_POST['_details'] == NULL)?'N/A':$_POST['_details']).'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Freight
                        </td>
                        <td>
                            '.(($_POST['_freight'] == NULL)?'N/A':$_POST['_freight']).'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            PIC
                        </td>
                        <td>
                            '.(($_POST['_pic'] == NULL)?'N/A':$_POST['_pic']).'
                        </td>
                    </tr>
                </table>
                ';

        $mail->addAddress ( $results['recipient'], $results['recipient'] );
        $mail->addAddress ( $_SESSION['operator'], $_SESSION['operator'] );

        ob_start ();
        include_once (dirname ( __FILE__ ) . "/../html/cancelled_truck.html");
        $body = ob_get_clean ();
        $mail->msgHTML ( $body, dirname ( __FILE__ ), true ); // Create message bodies and embed images

        $mail->send ();
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        $_SESSION['email_error'] = $e->errorMessage(); //Pretty error messages from PHPMailer
    } catch (Exception $e) {
        $_SESSION['email_error'] = $e->getMessage(); //Boring error messages from anything else!
    }
	
	$_SESSION ['message'] = '<p style="color: #00CC00" Truck cancelled successfuly.<br>Cancellation e-mail sent to '.$results['recipient'].' and '.$_SESSION['operator'].'</p>';
}

header ( 'Location: index.php?page=details&id='.$_GET['id'] );
exit();
?>