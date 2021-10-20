<?php

use Rohel\Notification;

session_start();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

if(!empty($_POST['id'])) {
    try {
        $table = DB_utils::updateRecipient($_POST['value'], $_SESSION['entry-id']);

        Utils::insertCargoAuditEntry($table, $_POST['id'], $_SESSION['entry-id'], $_POST['value']);
        Utils::audit_update($table, $_POST['id'], $_SESSION['entry-id']);

        // Set the trigger for the generation of the Match page
        DB_utils::writeValue('changes', '1');

        // Send a notification e-mail to both the old and new recipient
        $recipient = DB_utils::selectUserById($_SESSION['recipient-id']);
        $newRecipient = DB_utils::selectUser($_POST['value']);
        $originator = DB_utils::selectUserById($_SESSION['originator-id']);

        if($table == 'cargo_request') {
            $entry = DB_utils::selectRequest($_SESSION['entry-id']);
            $originator = DB_utils::selectUserById($entry->getOriginator());
            $recipient = DB_utils::selectUserById($entry->getRecipient());

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
                $entry = self::selectTruck($_SESSION['entry-id']);
                $originator = self::selectUserById($entry->getOriginator());
                $recipient = self::selectUserById($entry->getRecipient());

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
