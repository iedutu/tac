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

    if($truck->getStatus() == 3) {
        error_log('Truck already solved/loaded. Please contact the recipient directly.');
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Truck already solved/closed. Please contact the recipient directly.';

        header ( 'Location: /index.php?page=truckInfo&id='.$_POST['id'] );
        exit();
    }

    if($truck->getRecipient() != $_SESSION['operator']['id']) {
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Only the recipient can solve/close a truck.';

        header ( 'Location: /index.php?page=truckInfo&id='.$_POST['id'] );
        exit();
    }

    try {
        DB::getMDB()->update ( 'cargo_truck', array (
            'status' => 3
        ), "id=%d", $_POST ['id']);

        Utils::insertCargoAuditEntry('cargo_truck', 'status', $_POST['id'], 3);

        // Set the trigger for the generation of the Match page
        DB_utils::writeValue('changes', '1');

        // Add a notification to the receiver of the cargo request
        DB_utils::addNotification($_SESSION['recipient-id'], 4, 2, $_POST['id']);

        DB::getMDB()->commit ();

        $_SESSION['alert']['type'] = 'success';
        $_SESSION['alert']['message'] = 'Truck '.$truck->getPlateNumber().' with ameta '.$truck->getAmeta().' was marked as solved/closed.';

        // Send any relevant e-mail
        // TODO: Add the code to send e-mails for when a truck is solved/closed.
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

    $_SESSION['alert']['message'] .= ' Notification e-mail sent to '.$truck->getRecipient().' and '.$_SESSION['operator'];
    header ( 'Location: /index.php?page=truckInfo&id='.$truck->getId() );
    exit();
}

header ( 'Location: /index.php?page=trucks' );
exit();