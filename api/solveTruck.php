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
        DB_utils::updateTruckStatus($truck, 3);

        Utils::insertCargoAuditEntry('cargo_truck', 'status', $truck->getId(), 3);

        // Set the trigger for the generation of the Match page
        DB_utils::writeValue('changes', '1');

        // Add a notification to the receiver of the cargo request
        DB_utils::addNotification($truck->getRecipient(), 4, 2, $truck->getId());

        // Send a notification e-mail to the recipient
        $originator = DB_utils::selectUserById($truck->getOriginator());
        $recipient = DB_utils::selectUserById($truck->getRecipient());

        $email['subject'] = 'Truck order marked as fully loaded by ' . $originator->getName();
        $email['title'] = 'ROHEL | E-mail';
        $email['header'] = 'A truck order was marked as fully loaded by ' . $originator->getName();
        $email['body-1'] = 'has marked as fully loaded a truck order from <strong>' . $truck->getFromCity() . '</strong>' . '.';
        $email['body-2'] = 'The loading date is <strong>' . date(Utils::$PHP_DATE_FORMAT, $truck->getLoadingDate()) . '</strong>';
        $email['originator']['e-mail'] = $originator->getUsername();
        $email['originator']['name'] = $originator->getName();
        $email['recipient']['e-mail'] = $recipient->getUsername();
        $email['recipient']['name'] = $recipient->getName();
        $email['link']['url'] = 'https://rohel.iedutu.com/?page=truckInfo&id=' . $truck->getId();
        $email['link']['text'] = 'View the truck order details';
        $email['color'] = Mails::$FULLY_LOADED_COLOR;

        Mails::emailNotification($email);
    }
    catch (ApplicationException $ae) {
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Application error ('.$ae->getCode().':'.$ae->getMessage().'). Please contact your system administrator.';

            header ( 'Location: /index.php?page=truckInfo&id='.$truck->getId() );
            exit();
        }
    catch (Exception $e) {
            Utils::handleException($e);
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Application error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

            header ( 'Location: /index.php?page=truckInfo&id='.$truck->getId() );
            exit();
        }

    $_SESSION['alert']['type'] = 'success';
    $_SESSION['alert']['message'] = 'Truck '.$truck->getPlateNumber().' with ameta '.$truck->getAmeta().' was marked as fully loaded.';
    $_SESSION['alert']['message'] .= ' Notification e-mail sent to '.$truck->getRecipient().' and '.$_SESSION['operator'];

    header ( 'Location: /index.php?page=truckInfo&id='.$truck->getId() );
    exit();
}

header ( 'Location: /index.php?page=trucks' );
exit();