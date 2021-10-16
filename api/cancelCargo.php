<?php

use PHPMailer\PHPMailer\PHPMailer;

session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";
include $_SERVER["DOCUMENT_ROOT"]."/lib/mail-settings.php";

try {
    if (isset ( $_POST ['id'] )) {
        $cargo = DB_utils::selectRequest($_POST ['id']);
        if (is_null($cargo)) {
            header('Location: /index.php?page=cargoInfo&id=' . $_POST['id']);
            exit();
        }

        if ($cargo->getStatus() == 1) {
            error_log('Cargo already acknowledged and cannot be cancelled. Please contact the recipient directly.');
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Cargo already acknowledged and cannot be cancelled. Please contact the recipient directly.';

            header('Location: /index.php?page=cargoInfo&id=' . $_POST['id']);
            exit();
        }

        if ($cargo->getStatus() == 1) {
            error_log('Cargo request is closed and cannot be cancelled. Please contact the recipient directly.');
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Cargo request is closed and cannot be cancelled. Please contact the recipient directly.';

            header('Location: /index.php?page=cargoInfo&id=' . $_POST['id']);
            exit();
        }

        if ($cargo->getOriginator() != $_SESSION['operator']) {
            error_log('You cannot cancel orders created by others.');
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'You cannot cancel orders created by others.';

            header('Location: /index.php?page=cargoInfo&id=' . $_POST['id']);
            exit();
        }

        DB::getMDB()->update('cargo_request', array(
            'status' => 4
        ), "id=%d", $_POST ['id']);

        Utils::cargo_audit('cargo_request', 'status', $_POST['id'], 4);

        // Set the trigger for the generation of the Match page
        DB_utils::writeValue('changes', '1');

        // Add a notification to the receiver of the cargo request
        DB_utils::addNotification($_SESSION['recipient-id'], 4, 1, $_POST['id']);

        DB::getMDB()->commit();

        $_SESSION['alert']['type'] = 'success';
        $_SESSION['alert']['message'] = 'Cargo request was successfully cancelled.';
        if (!empty($cargo->getAmeta())) {
            $_SESSION['alert']['message'] = 'Cargo request with ameta ' . $cargo->getAmeta() . ' was successfully cancelled.';
        }

        // Send any relevant e-mail
        $mail = new PHPMailer ();
        include $_SERVER["DOCUMENT_ROOT"] . "/lib/mail-settings.php";

        $mail->Subject = "Cargo canceled by " . $_SESSION ['operator'];

        $url = 'http://rohel.iedutu.com/?page=cargo';

        $cargo_details = Utils::mailingCargoDetails($cargo);

        $mail->addAddress($cargo->getRecipient(), $cargo->getRecipient());
        $mail->addAddress($_SESSION['operator'], $_SESSION['operator']);

        ob_start();
        include_once(dirname(__FILE__) . "/../html/cancelled_cargo.html");
        $body = ob_get_clean();
        $mail->msgHTML($body, dirname(__FILE__), true); // Create message bodies and embed images

        if (!Utils::$DO_NOT_SEND_MAILS) {
            $mail->send();
        }
    }
} catch (\PHPMailer\PHPMailer\Exception $me) {
    Utils::handleMailException($me);
    $_SESSION['alert']['type'] = 'error';
    $_SESSION['alert']['message'] .= 'There was an error while sending the notification e-mails: '.$me->errorMessage(); //Pretty error messages from PHPMailer
} catch (MeekroDBException $mdbe) {
    Utils::handleMySQLException($mdbe);
    $_SESSION['alert']['type'] = 'error';
    $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';
} catch (Exception $e) {
    Utils::handleException($e);
    $_SESSION['alert']['type'] = 'error';
    $_SESSION['alert']['message'] .= 'There was an error while sending the notification e-mails: '.$e->getMessage(); //Pretty error messages from PHPMailer
}

$_SESSION['alert']['message'] .= 'Cancellation e-mail sent to '.$cargo->getRecipient().' and '.$_SESSION['operator'];

header ( 'Location: /index.php?page=cargo' );
exit();