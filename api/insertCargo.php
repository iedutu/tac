<?php
session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

use PHPMailer\PHPMailer\PHPMailer;

if (! Utils::authorized(Utils::$INSERT)) {
    error_log("User not authorized to insert data in the database.");
	header ( 'Location: /' );
	exit ();
}

if (isset ( $_POST ['_submitted'] )) {
    error_log("Trying to insert.");

    try {
        DB::getMDB()->insert('cargo_request', array(
            'originator_id' => $_SESSION['operator']['id'],
            'operator' => $_SESSION['operator']['username'],
            'SYS_CREATION_DATE' => date('Y-m-d H:i:s'),
            'status' => 1,
            'client' => $_POST ['client'],
            'recipient_id' => $_POST ['recipient'],
            'from_city' => $_POST ['from_city'],
            'to_city' => $_POST ['to_city'],
            'from_address' => $_POST ['from_address'],
            'to_address' => $_POST ['to_address'],
            'expiration' => (($_POST ['rohel_cargo_expiration'] == '') ? null : DB::getMDB()->sqleval("str_to_date(%s, %s)",$_POST ['rohel_cargo_expiration'], Utils::$SQL_DATE_FORMAT)),
            'loading_date' => (($_POST ['rohel_cargo_loading'] == '') ? null : DB::getMDB()->sqleval("str_to_date(%s, %s)",$_POST ['rohel_cargo_loading'], Utils::$SQL_DATE_FORMAT)),
            'unloading_date' => (($_POST ['rohel_cargo_unloading'] == '') ? null : DB::getMDB()->sqleval("str_to_date(%s, %s)",$_POST ['rohel_cargo_unloading'], Utils::$SQL_DATE_FORMAT)),
            'description' => $_POST ['description'],
            'collies' => $_POST ['collies'],
            'weight' => $_POST ['weight'],
            'volume' => $_POST ['volume'],
            'loading_meters' => $_POST ['loading'],
            'instructions' => $_POST ['instructions'],
            'freight' => $_POST ['freight'],
            'order_type' => $_POST ['order_type'],
            'adr' => $_POST ['adr']
        ));

        Utils::cargo_audit('cargo_request', 'NEW-ENTRY', null, $_POST ['recipient']);

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
        include $_SERVER["DOCUMENT_ROOT"]."/lib/mail-settings.php";

		$mail->Subject = "New cargo from " . $_SESSION ['operator'];
		
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
						Client:
					</td>
					<td>
						'.(($_POST['client'] == NULL)?'N/A':$_POST['client']).'
					</td>
				</tr>
				<tr>
					<td>
						From:
					</td>
					<td>
						'.$_POST['from_address'].'
					</td>
				</tr>
				<tr>
					<td>
						To:
					</td>
					<td>
						'.$_POST['to_address'].'
					</td>
				</tr>
				<tr>
					<td>
						Loading
					</td>
					<td>
						'.(($_POST ['loading']=='')?'N/A':$_POST ['loading']).'
					</td>
				</tr>
				<tr>
					<td>
						Unloading
					</td>
					<td>
						'.(($_POST ['unloading']=='')?'N/A':$_POST ['unloading']).'
					</td>
				</tr>
				<tr>
					<td>
						Goods description
					</td>
					<td>
						'.(($_POST['description'] == NULL)?'N/A':$_POST['description']).'
					</td>
				</tr>
				<tr>
					<td>
						Number of collies
					</td>
					<td>
						'.(($_POST['collies'] == NULL)?'N/A':$_POST['collies']).'
					</td>
				</tr>
				<tr>
					<td>
						Gross weight
					</td>
					<td>
						'.(($_POST['weight'] == 0)?'N/A':$_POST['weight']).' kg
					</td>
				</tr>
				<tr>
					<td>
						Volume
					</td>
					<td>
						'.(($_POST['volume'] == 0)?'N/A':$_POST['volume']).' cbm
					</td>
				</tr>
				<tr>
					<td>
						Loading meters
					</td>
					<td>
						'.(($_POST['loading'] == 0)?'N/A':$_POST['loading']).' m
					</td>
				</tr>
				<tr>
					<td>
						Other comments
					</td>
					<td>
						'.(($_POST ['comments'] == NULL)?'N/A':$_POST ['comments']).'
					</td>
				</tr>
				<tr>
					<td>
						Freight
					</td>
					<td>
						'.(($_POST['freight'] == NULL)?'N/A':$_POST['freight']).'
					</td>
				</tr>
				<tr>
					<td>
						ADR
					</td>
					<td>
						'.(($_POST['adr'] == NULL)?'N/A':$_POST['adr']).'
					</td>
				</tr>
			</table>
			';

		$mail->addAddress ( $_POST['recipient'], $_POST['recipient'] );
		
		ob_start ();
		include_once (dirname ( __FILE__ ) . "../../html/new_cargo.html");
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

	header ( "Location: /?page=cargo" );
	exit();
}

header ( "Location: /" );
exit();