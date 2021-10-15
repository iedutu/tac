<?php

use PHPMailer\PHPMailer\PHPMailer;

session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";
include $_SERVER["DOCUMENT_ROOT"]."/lib/mail-settings.php";

if (isset ( $_POST ['id'] )) {
    $truck = DB_utils::selectTruck($_POST ['id']);
    if(is_null($truck)) {
        header ( 'Location: /index.php?page=truckInfo&id='.$_POST['id'] );
        exit();
    }

    if($truck->getStatus() == 1) {
        error_log('Truck already acknowledged and cannot be cancelled. Please contact the recipient directly.');
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Truck already acknowledged and cannot be cancelled. Please contact the recipient directly.';

        header ( 'Location: /index.php?page=truckInfo&id='.$_POST['id'] );
        exit();
    }

    if($truck->getOriginator() != $_SESSION['operator']) {
        error_log('You cannot cancel orders created by others.');
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'You cannot cancel trucks added by others.';

        header ( 'Location: /index.php?page=truckInfo&id='.$_POST['id'] );
        exit();
    }

    try {
        DB::getMDB()->update ( 'cargo_truck', array (
            'status' => 3
        ), "id=%d", $_POST ['id']);

        Utils::cargo_audit('cargo_truck', 'status', $_POST['id'], 3);

        DB::getMDB()->commit ();

        $_SESSION['alert']['type'] = 'success';
        $_SESSION['alert']['message'] = 'Truck '.$truck->getPlateNumber().' with ameta '.$truck->getAmeta().' was successfully cancelled.';

        // Send any relevant e-mail
        $mail = new PHPMailer ();
        include $_SERVER["DOCUMENT_ROOT"] . "/lib/mail-settings.php";

        $mail->Subject = "Truck canceled by " . $_SESSION ['operator'];

        $url='http://rohel.iedutu.com/?page=trucks';

        $cargo_details = Utils::mailingTruckDetails($truck);

        $mail->addAddress ( $truck->getRecipient(), $truck->getRecipient() );
        $mail->addAddress ( $_SESSION['operator'], $_SESSION['operator'] );

        ob_start ();
        include_once(dirname(__FILE__) . "/../html/cancelled_truck.html");
        $body = ob_get_clean ();
        $mail->msgHTML ( $body, dirname ( __FILE__ ), true ); // Create message bodies and embed images

        if(!Utils::$DO_NOT_SEND_MAILS) {
            $mail->send ();
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

    $_SESSION['alert']['message'] .= 'Cancellation e-mail sent to '.$truck->getRecipient().' and '.$_SESSION['operator'];
}

header ( 'Location: /index.php?page=trucks' );
exit();