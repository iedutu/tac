<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

if(!empty($_POST['id'])) {
    try {
        $table = DB_utils::updateGenericField($_POST['id'], $_POST['value'], $_SESSION['entry-id']);

        Utils::insertCargoAuditEntry($table, $_POST['id'], $_SESSION['entry-id'], $_POST['value']);
        Utils::audit_update($table, $_POST['id'], $_SESSION['entry-id']);

        // Set the trigger for the generation of the Match page
        DB_utils::writeValue('changes', '1');

        // Add a notification to the receiver of the cargo request
        DB_utils::addNotification($_SESSION['recipient-id'], 2, $_SESSION['entry-kind'], $_SESSION['entry-id']);

        // Send a notification e-mail to the recipient
        $recipient = DB_utils::selectUserById($_SESSION['recipient-id']);
        $originator = DB_utils::selectUserById($_SESSION['originator-id']);

        if($_SESSION['app'] = 'cargo') {
            $cargo = DB_utils::selectRequest($_SESSION['entry-id']);

            $email['subject'] = 'Cargo request modified by ' . $originator->getName();
            $email['title'] = 'ROHEL | E-mail';
            $email['header'] = 'A cargo request was modified by ' . $originator->getName();
            $email['body-1'] = 'has modified a field ('.$_POST['id'].' => '.$_POST['value'].') on cargo request bound to <strong>' . $cargo->getToCity() . '</strong>' . '.';
            $email['body-2'] = 'The loading date is <strong>' . date(Utils::$PHP_DATE_FORMAT, $cargo->getLoadingDate()) . '</strong>';
            $email['link']['url'] = 'https://rohel.iedutu.com/?page=cargoInfo&id='.$cargo->getId();
            $email['link']['text'] = 'View the cargo request details';
        }
        else {
            $truck = DB_utils::selectTruck($_SESSION['entry-id']);

            $email['subject'] = 'Truck order modified by ' . $originator->getName();
            $email['title'] = 'ROHEL | E-mail';
            $email['header'] = 'A truck order was modified by ' . $originator->getName();
            $email['body-1'] = 'has modified a field ('.$_POST['id'].' => '.$_POST['value'].') on truck order from <strong>' . $truck->getFromCity() . '</strong>' . '.';
            $email['body-2'] = 'The loading date is <strong>' . date(Utils::$PHP_DATE_FORMAT, $truck->getLoadingDate()) . '</strong>';
            $email['link']['url'] = 'https://rohel.iedutu.com/?page=truckInfo&id='.$truck->getId();
            $email['link']['text'] = 'View the truck order details';
        }

        $email['originator']['e-mail'] = $originator->getUsername();
        $email['originator']['name'] = $originator->getName();
        $email['recipient']['e-mail'] = $recipient->getUsername();
        $email['recipient']['name'] = $recipient->getName();
        $email['bg-color'] = Mails::$BG_UPDATED_COLOR;
        $email['tx-color'] = Mails::$TX_UPDATED_COLOR;

        Mails::emailNotification($email);
    }
    catch (ApplicationException $ae) {
        return null;
    }
    catch (Exception $e) {
        Utils::handleException($e);
        return null;
    }

    echo $_POST['value'];
}
