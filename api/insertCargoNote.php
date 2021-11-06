<?php
session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/lib/datatypes/Rohel/CargoNote.php";

use Rohel\CargoNote;
use Rohel\Notification;

if (! Utils::authorized(Utils::$INSERT)) {
    Utils::log("User not authorized to insert data in the database.");
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
        Utils::insertCargoAuditEntry('cargo_comments', 'NEW-ENTRY', null, $id);

        // Add a notification to the originator/receiver of the cargo
        $cargo = DB_utils::selectRequest($note->getCargoId());
        $originator = DB_utils::selectUserById($cargo->getOriginator());
        $recipient = DB_utils::selectUserById($cargo->getRecipient());

        $notification = new Notification();
        if($_SESSION['role'] == 'originator') {
            $notification->setUserId($cargo->getRecipient());

            $email['originator']['e-mail'] = $originator->getUsername();
            $email['originator']['name'] = $originator->getName();
            $email['recipient']['e-mail'] = $recipient->getUsername();
            $email['recipient']['name'] = $recipient->getName();
        }
        else {
            if($_SESSION['role'] == 'recipient') {
                $notification->setUserId($cargo->getOriginator());

                $email['recipient']['e-mail'] = $originator->getUsername();
                $email['recipient']['name'] = $originator->getName();
                $email['originator']['e-mail'] = $recipient->getUsername();
                $email['originator']['name'] = $recipient->getName();
            }
            else {
                $_SESSION['alert']['type'] = 'error';
                $_SESSION['alert']['message'] = 'Application error: Someone outside of the roles of originator/recipient has attempted to add a note. Please contact your system administrator.';
                return 0;
            }
        }
        $notification->setOriginatorId($_SESSION['operator']['id']);
        $notification->setKind(1);
        $notification->setEntityKind(4);
        $notification->setEntityId($cargo->getId());

        DB_utils::addNotification($notification);

        // Send a notification e-mail to the recipient
        $email['subject'] = 'New note added by ' . $_SESSION['operator']['name'];
        $email['title'] = 'ROHEL | E-mail';
        $email['header'] = 'A new note for a cargo was added in the system by ' . $_SESSION['operator']['name'];
        $email['body-1'] = 'has introduced a new note to a cargo bound for <strong>' . $cargo->getToCity() . '</strong>' . ': ' . $note->getNote();
        $email['body-2'] = 'The loading date is <strong>' . date(Utils::$PHP_DATE_FORMAT, $cargo->getLoadingDate()) . '</strong>';
        $email['link']['url'] = Mails::$BASE_HREF.'/?page=cargoInfo&id=' . $cargo->getId();
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
        $_SESSION['alert']['message'] = 'A new notification was added into the system for the cargo. ' . $originator->getName() . ' (' . $originator->getUsername() . ') was notified by e-mail.';
    }
    else {
        $_SESSION['alert']['message'] = 'A new notification was added into the system for the cargo. ' . $recipient->getName() . ' (' . $recipient->getUsername() . ') was notified by e-mail.';
    }
}


header ( "Location: /?page=".$_POST['page']."&id=".$_POST['id'] );
exit();