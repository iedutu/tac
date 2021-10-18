<?php

use PHPMailer\PHPMailer\PHPMailer;

session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";
include $_SERVER["DOCUMENT_ROOT"]."/lib/mail-settings.php";

if (isset ( $_POST ['id'] )) {
    $truck = DB_utils::selectTruck($_POST ['id']);
    if(empty($truck)) {
        header ( 'Location: /index.php?page=trucks' );
        exit();
    }

    if($truck->getStatus() == 2) {
        error_log('Truck already solved/fully loaded and cannot be cancelled. Please contact the recipient directly.');
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Truck already solved/fully loaded and cannot be cancelled. Please contact the recipient directly.';

        header ( 'Location: /index.php?page=truckInfo&id='.$truck->getId() );
        exit();
    }

    if($truck->getOriginator() != $_SESSION['operator']) {
        error_log('You cannot cancel orders created by others.');
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'You cannot cancel trucks added by others.';

        header ( 'Location: /index.php?page=truckInfo&id='.$truck->getId() );
        exit();
    }

    try {
        DB_utils::cancelTruck($truck->getId());

        Utils::insertCargoAuditEntry('cargo_truck', 'status', $_POST['id'], 3);

        // Set the trigger for the generation of the Match page
        DB_utils::writeValue('changes', '1');

        // Add a notification to the receiver of the cargo request
        DB_utils::addNotification($_SESSION['recipient-id'], 4, 2, $_POST['id']);

        // Send a notification e-mail to the recipient
        $originator = DB_utils::selectUserById($truck->getOriginator());
        $recipient = DB_utils::selectUserById($truck->getRecipient());

        $email['subject'] = 'Truck order cancelled by ' . $originator->getName();
        $email['title'] = 'ROHEL | E-mail';
        $email['header'] = 'A truck order was cancelled by ' . $originator->getName();
        $email['body-1'] = 'has cancelled a truck order from <strong>' . $truck->getFromCity() . '</strong>' . '.';
        $email['body-2'] = 'The loading date was <strong>' . date(Utils::$PHP_DATE_FORMAT, $truck->getLoadingDate()) . '</strong>';
        $email['originator']['e-mail'] = $originator->getUsername();
        $email['originator']['name'] = $originator->getName();
        $email['recipient']['e-mail'] = $recipient->getUsername();
        $email['recipient']['name'] = $recipient->getName();
        $email['link']['url'] = 'https://rohel.iedutu.com/?page=trucks';
        $email['link']['text'] = 'View the remaining truck orders';
        $email['color'] = Mails::$CANCELLED_COLOR;

        Mails::emailNotification($email);
    }
    catch (ApplicationException $ae) {
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Application error ('.$ae->getCode().':'.$ae->getMessage().'). Please contact your system administrator.';
        return 0;
    }
    catch (Exception $e) {
        Utils::handleException($e);
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Application error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';
        return 0;
    }

    $_SESSION['alert']['message'] .= 'Cancellation e-mail sent to '.$email['recipient']['name'].' ('.$email['recipient']['e-mail'].')';
}

header ( 'Location: /index.php?page=trucks' );
exit();