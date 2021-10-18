<?php
session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

use PHPMailer\PHPMailer\PHPMailer;
use Rohel\CargoNote;

if (! Utils::authorized(Utils::$INSERT)) {
    error_log("User not authorized to insert data in the database.");
    header ( 'Location: /' );
    exit ();
}

if (isset ( $_POST ['_submitted'] )) {
    try {
        $note = new CargoNote();
        $note->setCargoId($_POST ['id']);
        $note->setNote($_POST ['note']);

        $id = DB_utils::insertCargoNote($note);
        // TODO: Overhaul the audit system.
        Utils::insertCargoAuditEntry('cargo_comments', 'NEW-ENTRY', null, $note->getId());

        // Add a notification to the receiver of the cargo request
        DB_utils::addNotification($_POST ['recipient'], 1, 4, $note->getId());

        // Send a notification e-mail to the recipient
        $cargo = DB_utils::selectRequest($note->getCargoId());
        $originator = DB_utils::selectUserById($cargo->getOriginator());
        $recipient = DB_utils::selectUserById($cargo->getRecipient());

        $email['subject'] = 'New note added by ' . $originator->getName();
        $email['title'] = 'ROHEL | E-mail';
        $email['header'] = 'A new note for a cargo request was added in the system by ' . $originator->getName();
        $email['body-1'] = 'has introduced a new note to a cargo request bound for <strong>' . $cargo->getToCity() . '</strong>' . ': ' . $note->getNote();
        $email['body-2'] = 'The loading date is <strong>' . date(Utils::$PHP_DATE_FORMAT, $cargo->getLoadingDate()) . '</strong>';
        $email['originator']['e-mail'] = $originator->getUsername();
        $email['originator']['name'] = $originator->getName();
        $email['recipient']['e-mail'] = $recipient->getUsername();
        $email['recipient']['name'] = $recipient->getName();
        $email['link']['url'] = 'https://rohel.iedutu.com/?page=cargoInfo&id=' . $cargo->getId();
        $email['link']['text'] = 'View the order details';
        $email['color'] = Mails::$NEW_COLOR;

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

    $_SESSION['alert']['type'] = 'success';
    $_SESSION['alert']['message'] = 'A new notification was added into the system for the cargo request. '.$recipient->getName().' ('.$recipient->getUsername().') was notified by e-mail.';
}


header ( "Location: /?page=".$_POST['page']."&id=".$_POST['id'] );
exit();