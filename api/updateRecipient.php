<?php

use Rohel\Notification;

session_start();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

if(!empty($_POST['id'])) {
    try {
        $recipient = DB_utils::selectUserById($_SESSION['recipient-id']);
        $table = DB_utils::updateRecipient($_POST['value'], $_SESSION['entry-id']);
        $newRecipient = DB_utils::selectUserById($_SESSION['recipient-id']);

        Utils::insertCargoAuditEntry($table, $_POST['id'], $_SESSION['entry-id'], $_POST['value']);
        Utils::highlightPageItem($table, $_POST['id'], $_SESSION['entry-id']);

        // Set the trigger for the generation of the Match page
        DB_utils::writeValue('changes', '1');

        // Send a notification e-mail and in-app notification to both the old and new recipient
        $originator = DB_utils::selectUserById($_SESSION['originator-id']);

        if($table == 'cargo_request') {
            $entry = DB_utils::selectRequest($_SESSION['entry-id']);

            // Add a notification to the recipient of the cargo request
            $note = new Notification();
            $note->setUserId($newRecipient->getId());
            $note->setOriginatorId($originator->getId());
            $note->setKind(1);
            $note->setEntityKind(1);
            $note->setEntityId($entry->getId());

            error_log('Add notification for new: '.$note->getUserId());
            DB_utils::addNotification($note);

            // Add a notification to the old recipient of the cargo request for cancellation
            $note->setUserId($recipient->getId());
            $note->setKind(4);

            error_log('Add notification for old: '.$note->getUserId());
            DB_utils::addNotification($note);

            // Notify the new recipient
            $email['subject'] = 'New cargo request received from '.$originator->getName();
            $email['title'] = 'ROHEL | E-mail';
            $email['header'] = ' You have a new cargo request from '.$originator->getName();
            $email['body-1'] = 'has introduced a new cargo request for your consideration and acknowledgement.';
            $email['body-2'] = 'The loading date is <strong>'.date(Utils::$PHP_DATE_FORMAT, $entry->getLoadingDate()).'</strong>';
            $email['originator']['e-mail'] = $originator->getUsername();
            $email['originator']['name'] = $originator->getName();
            $email['recipient']['e-mail'] = $newRecipient->getUsername();
            $email['recipient']['name'] = $newRecipient->getName();
            $email['link']['url'] = 'https://rohel.iedutu.com/?page=cargoInfo&id='.$entry->getId();
            $email['link']['text'] = 'View & acknowledge the new order';
            $email['bg-color'] = Mails::$BG_NEW_COLOR;
            $email['tx-color'] = Mails::$TX_NEW_COLOR;

            Mails::emailNotification($email);
            unset($email);

            // Notify the old originator
            $email['subject'] = 'Cargo request cancelled by ' . $originator->getName();
            $email['title'] = 'ROHEL | E-mail';
            $email['header'] = 'A cargo request was cancelled by ' . $originator->getName();
            $email['body-1'] = 'has cancelled a cargo request bound for <strong>' . $entry->getToCity() . '</strong>' . '.';
            $email['body-2'] = 'The loading date was <strong>' . date(Utils::$PHP_DATE_FORMAT, $entry->getLoadingDate()) . '</strong>';
            $email['originator']['e-mail'] = $originator->getUsername();
            $email['originator']['name'] = $originator->getName();
            $email['recipient']['e-mail'] = $recipient->getUsername();
            $email['recipient']['name'] = $recipient->getName();
            $email['link']['url'] = 'https://rohel.iedutu.com/?page=cargo';
            $email['link']['text'] = 'View the remaining cargo requests';
            $email['bg-color'] = Mails::$BG_CANCELLED_COLOR;
            $email['tx-color'] = Mails::$TX_CANCELLED_COLOR;

            Mails::emailNotification($email);
            unset($email);
            unset($originator);
            unset($recipient);
        }
        else {
            if($table == 'cargo_truck') {
                $entry = DB_utils::selectTruck($_SESSION['entry-id']);
                $originator = DB_utils::selectUserById($entry->getOriginator());
                $recipient = DB_utils::selectUserById($entry->getRecipient());

                // Add a notification to the receiver of the truck
                $note = new Notification();
                $note->setUserId($newRecipient->getId());
                $note->setOriginatorId($originator->getId());
                $note->setKind(1);
                $note->setEntityKind(2);
                $note->setEntityId($entry->getId());

                DB_utils::addNotification($note);

                // Add a notification to the old recipient of the truck for cancellation
                $note->setUserId($recipient->getId());
                $note->setKind(4);

                DB_utils::addNotification($note);

                // Notify the new recipient
                $email['subject'] = 'New truck order received from '.$originator->getName();
                $email['title'] = 'ROHEL | E-mail';
                $email['header'] = ' You have a new truck order from '.$originator->getName();
                $email['body-1'] = 'has introduced a new truck order for your consideration.';
                $email['body-2'] = 'The unloading date is <strong>'.date(Utils::$PHP_DATE_FORMAT, $entry->getUnloadingDate()).'</strong>';
                $email['originator']['e-mail'] = $originator->getUsername();
                $email['originator']['name'] = $originator->getName();
                $email['recipient']['e-mail'] = $newRecipient->getUsername();
                $email['recipient']['name'] = $newRecipient->getName();
                $email['link']['url'] = 'https://rohel.iedutu.com/?page=truckInfo&id='.$entry->getId();
                $email['link']['text'] = 'View the detailed truck order';
                $email['bg-color'] = Mails::$BG_NEW_COLOR;
                $email['tx-color'] = Mails::$TX_NEW_COLOR;

                Mails::emailNotification($email);
                unset($email);

                $email['subject'] = 'Truck order cancelled by ' . $originator->getName();
                $email['title'] = 'ROHEL | E-mail';
                $email['header'] = 'A truck order was cancelled by ' . $originator->getName();
                $email['body-1'] = 'has cancelled a truck order from <strong>' . $entry->getFromCity() . '</strong>' . '.';
                $email['body-2'] = 'The loading date was <strong>' . date(Utils::$PHP_DATE_FORMAT, $entry->getLoadingDate()) . '</strong>';
                $email['originator']['e-mail'] = $originator->getUsername();
                $email['originator']['name'] = $originator->getName();
                $email['recipient']['e-mail'] = $recipient->getUsername();
                $email['recipient']['name'] = $recipient->getName();
                $email['link']['url'] = 'https://rohel.iedutu.com/?page=trucks';
                $email['link']['text'] = 'View the remaining truck orders';
                $email['bg-color'] = Mails::$BG_CANCELLED_COLOR;
                $email['tx-color'] = Mails::$TX_CANCELLED_COLOR;

                Mails::emailNotification($email);
                unset($email);
                unset($originator);
                unset($recipient);
            }
        }
    }
catch (ApplicationException $ae) {
    return null;
}
    catch (Exception $e) {
    Utils::handleException($e);
    return null;
}

    echo DB_utils::returnValue($table, $_POST['id'], $_POST['value'], $_SESSION['entry-id']);
}