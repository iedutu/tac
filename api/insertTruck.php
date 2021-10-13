<?php
session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

use PHPMailer\PHPMailer\PHPMailer;

if (! Utils::authorized(null, Utils::$INSERT)) {
    error_log("User not authorized to insert data in the database.");
	header ( 'Location: /' );
	exit ();
}

if (isset ( $_POST ['_submitted'] )) {
    error_log("Trying to insert.");

    try {
        DB::getMDB()->insert('cargo_truck', array(
            'originator' => $_SESSION['operator'],
            'operator' => $_SESSION['operator'],
            'SYS_CREATION_DATE' => date('Y-m-d H:i:s'),
            'status' => 1,
            'recipient' => $_POST ['recipient'],
            'from_city' => $_POST ['from_city'],
            'loading_date' => (($_POST ['rohel_truck_loading'] == '') ? null : DB::getMDB()->sqleval("str_to_date(%s, %s)",$_POST ['rohel_truck_loading'], Utils::$SQL_DATE_FORMAT)),
            'unloading_date' => (($_POST ['rohel_truck_unloading'] == '') ? null : DB::getMDB()->sqleval("str_to_date(%s, %s)",$_POST ['rohel_truck_unloading'], Utils::$SQL_DATE_FORMAT)),
            'details' => $_POST ['details'],
            'freight' => $_POST ['freight'],
            'cargo_type' => $_POST ['cargo_type'],
            'contract_type' => $_POST ['contract_type'],
            'adr' => $_POST ['adr'],
            'ameta' => $_POST ['ameta'],
            'plate_number' => $_POST['plate_number']
        ));

        $truck_id = DB::getMDB()->insertId();
        $truck_final_destination = '';

        for($i=0;$i<sizeof($_POST['stops']);$i++) {
            DB::getMDB()->insert('cargo_truck_stops', array(
                'operator' => $_SESSION['operator'],
                'SYS_CREATION_DATE' => date('Y-m-d H:i:s'),
                'truck_id' => $truck_id,
                'stop_id' => $i,
                'city' => $_POST['stops'][$i]['city'],
                'address' => $_POST['stops'][$i]['address'],
                'loading_meters' => $_POST['stops'][$i]['loading_meters'],
                'weight' => $_POST['stops'][$i]['weight'],
                'volume' => $_POST['stops'][$i]['volume']
            ));

            $truck_final_destination = $_POST['stops'][$i]['city'];
        }

        Utils::cargo_audit('cargo_truck', 'NEW-ENTRY', null, $_POST ['recipient']);

        DB::getMDB()->commit();
    }
    catch (MeekroDBException $mdbe) {
        error_log("Database error: ".$mdbe->getMessage());
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';

        return 0;
    }
    catch (Exception $e) {
        error_log("Database error: ".$e->getMessage());
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Database error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

        return 0;
    }

	$id = DB::getMDB()->insertId();
	$url = 'http://www.rohel.ro/new/tac/?page=details&type=cargo&id='.$id;

    try {
        // e-mail confirmation
        $mail = new PHPMailer ();
        include "../lib/mail-settings.php";

        $mail->Subject = "New truck from " . $_SESSION ['operator'];

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
						'.$_POST['recipient'].'
					</td>
				</tr>
				<tr>
					<td>
						Available in:
					</td>
					<td>
						'.$_POST['from_city'].'
					</td>
				</tr>
				<tr>
					<td>
						Available for (final destination):
					</td>
					<td>
						'.$truck_final_destination.'
					</td>
				</tr>
				<tr>
					<td>
						Cargo type:
					</td>
					<td>
						'.$_POST['order_type'].'
					</td>
				</tr>
				<tr>
					<td>
						Contract type:
					</td>
					<td>
						'.$_POST['contract_type'].'
					</td>
				</tr>
				<tr>
					<td>
						License plate:
					</td>
					<td>
						'.$_POST['plate_number'].'
					</td>
				</tr>
				<tr>
					<td>
						Loading on:
					</td>
					<td>
						'.(($_POST ['rohel_truck_loading']=='')?null:($_POST ['rohel_truck_loading'])).'
					</td>
				</tr>
				<tr>
					<td>
						Unloading on:
					</td>
					<td>
						'.(($_POST ['rohel_truck_unloading']=='')?null:($_POST ['rohel_truck_unloading'])).'
					</td>
				</tr>
				<tr>
					<td>
						Details
					</td>
					<td>
						'.(($_POST['details'] == NULL)?'N/A':($_POST['details'])).'
					</td>
				</tr>
				<tr>
					<td>
						Freight
					</td>
					<td>
						'.(($_POST['freight'] == NULL)?'N/A':($_POST['freight'])).'
					</td>
				</tr>
				<tr>
					<td>
						Ameta
					</td>
					<td>
						'.(($_POST['ameta'] == NULL)?'N/A':($_POST['ameta'])).'
					</td>
				</tr>
				<tr>
					<td>
						ADR
					</td>
					<td>
						'.(($_POST['adr'] == NULL)?'N/A':($_POST['adr'])).'
					</td>
				</tr>
			</table>
			';

        $mail->addAddress ( $_POST['recipient'], $_POST['recipient'] );

        ob_start ();
        include_once (dirname ( __FILE__ ) . "../../html/new_truck.html");
        $body = ob_get_clean ();
        $mail->msgHTML ( $body, dirname ( __FILE__ ), true ); // Create message bodies and embed images
        if(!Utils::$DO_NOT_SEND_MAILS) {
            $mail->send ();
        }
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        $_SESSION['email_error'] = $e->errorMessage(); //Pretty error messages from PHPMailer
    } catch (Exception $e) {
        $_SESSION['email_error'] = $e->getMessage(); //Boring error messages from anything else!
    }

    $_SESSION ['message'] = '<p style="color: #00CC00">Confirmation e-mail sent to '.$_POST['recipient'].'</p>';

    header ( "Location: /?page=trucks" );
    exit();
}

header ( "Location: /" );
exit();