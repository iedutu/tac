<?php
session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/lib/datatypes/Rohel/CargoNote.php";

use Rohel\CargoNote;
use Rohel\Notification;

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

        // Add a notification to the originator/receiver of the cargo request
        $cargo = DB_utils::selectRequest($note->getCargoId());
        $notification = new Notification();
        if($_SESSION['role'] == 'originator') {
            $notification->setUserId($cargo->getRecipient());
        }
        else {
            if($_SESSION['role'] == 'recipient') {
                $notification->setUserId($cargo->getOriginator());
            }
            else {
                $_SESSION['alert']['type'] = 'error';
                $_SESSION['alert']['message'] = 'Application error: Unauthorized cargo_note_entry. Please contact your system administrator.';
                return 0;
            }
        }
        $notification->setOriginatorId($_SESSION['operator']['id']);
        $notification->setKind(1);
        $notification->setEntityKind(4);
        $notification->setEntityId($cargo->getId());

        DB_utils::addNotification($notification);

        // Send a notification e-mail to the recipient
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
        $email['bg-color'] = Mails::$BG_NEW_COLOR;
        $email['tx-color'] = Mails::$TX_NEW_COLOR;

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
    if($_SESSION['role'] == 'recipient') {
        $_SESSION['alert']['message'] = 'A new notification was added into the system for the cargo request. ' . $originator->getName() . ' (' . $originator->getUsername() . ') was notified by e-mail.';
    }
    else {
        $_SESSION['alert']['message'] = 'A new notification was added into the system for the cargo request. ' . $recipient->getName() . ' (' . $recipient->getUsername() . ') was notified by e-mail.';
    }
}


header ( "Location: /?page=".$_POST['page']."&id=".$_POST['id'] );
exit();