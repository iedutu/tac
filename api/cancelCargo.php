<?php

use PHPMailer\PHPMailer\PHPMailer;

session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";
include $_SERVER["DOCUMENT_ROOT"]."/lib/mail-settings.php";

if (isset ( $_POST ['id'] )) {
	$cargo = DB_utils::selectRequest($_POST ['id']);
	if(is_null($cargo)) {
        header ( 'Location: /index.php?page=cargoInfo&id='.$_POST['id'] );
        exit();
    }

	if($cargo->getStatus() == 1) {
        error_log('Cargo already acknowledged and cannot be cancelled. Please contact the recipient directly.');
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Cargo already acknowledged and cannot be cancelled. Please contact the recipient directly.';

        header ( 'Location: /index.php?page=cargoInfo&id='.$_POST['id'] );
		exit();
	}

    if($cargo->getStatus() == 1) {
        error_log('Cargo request is closed and cannot be cancelled. Please contact the recipient directly.');
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Cargo request is closed and cannot be cancelled. Please contact the recipient directly.';

        header ( 'Location: /index.php?page=cargoInfo&id='.$_POST['id'] );
        exit();
    }

    if($cargo->getOriginator() != $_SESSION['operator']) {
        error_log('You cannot cancel orders created by others.');
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'You cannot cancel orders created by others.';

        header ( 'Location: /index.php?page=cargoInfo&id='.$_POST['id'] );
        exit();
	}

	try {
        DB::getMDB()->update ( 'cargo_request', array (
            'status' => 4
        ), "id=%d", $_POST ['id']);

        Utils::cargo_audit('cargo_request', 'status', $_POST['id'], 4);

        DB::getMDB()->commit ();
    }
    catch (MeekroDBException $mdbe) {
        error_log("Database error: ".$mdbe->getMessage());
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';

        header ( 'Location: /index.php?page=cargoInfo&id='.$_POST['id'] );
        exit();
    }
    catch (Exception $e) {
        error_log("Database error: ".$e->getMessage());
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Database error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

        header ( 'Location: /index.php?page=cargoInfo&id='.$_POST['id'] );
        exit();
    }

    $_SESSION['alert']['type'] = 'success';
    $_SESSION['alert']['message'] = 'Cargo request was successfully cancelled.';
    if(!empty($cargo->getAmeta())) {
        $_SESSION['alert']['message'] = 'Cargo request with ameta '.$cargo->getAmeta().' was successfully cancelled.';
    }

	// Send any relevant e-mail
    try {
        $mail = new PHPMailer ();
        include $_SERVER["DOCUMENT_ROOT"] . "/lib/mail-settings.php";

        $mail->Subject = "Cargo canceled by " . $_SESSION ['operator'];

        $url='http://rohel.iedutu.com/?page=cargo';

        $cargo_details = Utils::mailingCargoDetails($cargo);

        $mail->addAddress ( $cargo->getRecipient(), $cargo->getRecipient() );
        $mail->addAddress ( $_SESSION['operator'], $_SESSION['operator'] );

        ob_start ();
        include_once(dirname(__FILE__) . "/../html/cancelled_cargo.html");
        $body = ob_get_clean ();
        $mail->msgHTML ( $body, dirname ( __FILE__ ), true ); // Create message bodies and embed images

        if(!Utils::$DO_NOT_SEND_MAILS) {
            $mail->send ();
        }
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        error_log("E-Mail error: ".$e->errorMessage());
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] .= 'There was an error while sending the notification e-mails: '.$e->errorMessage(); //Pretty error messages from PHPMailer
    } catch (Exception $e) {
        error_log("E-Mail error: ".$e->getMessage());
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] .= 'There was an error while sending the notification e-mails: '.$e->getMessage(); //Pretty error messages from PHPMailer
    }

    $_SESSION['alert']['message'] .= 'Cancellation e-mail sent to '.$cargo->getRecipient().' and '.$_SESSION['operator'];
}

header ( 'Location: /index.php?page=cargo' );
exit();