<?php

use Rohel\Notification;

session_start();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

if(!empty($_POST['id'])) {
    try {
        $table = DB_utils::updateGenericField($_POST['id'], $_POST['value'], $_SESSION['entry-id']);

        Utils::insertCargoAuditEntry($table, $_POST['id'], $_SESSION['entry-id'], $_POST['value']);
        Utils::highlightPageItem($table, $_POST['id'], $_SESSION['entry-id']);

        // Set the trigger for the generation of the Match page
        DB_utils::writeValue('changes', '1');

        // Send a notification e-mail to the recipient
        $recipient = DB_utils::selectUserById($_SESSION['recipient-id']);
        $originator = DB_utils::selectUserById($_SESSION['originator-id']);

        switch($table) {
            case 'cargo_request': {
                $cargo = DB_utils::selectRequest($_SESSION['entry-id']);

                // Add a notification to the receiver of the cargo
                $note = new Notification();

                if($_SESSION['role'] == 'recipient') {
                    $note->setUserId($cargo->getOriginator());
                } else {
                    $note->setUserId($cargo->getRecipient());
                }

                $note->setOriginatorId($_SESSION['operator']['id']);

                // When the recipient is changed
                if($_POST['id'] == 'recipient') {
                    $note->setKind(1);
                }
                else {
                    $note->setKind(2);
                }

                $note->setEntityKind(1);
                $note->setEntityId($cargo->getId());

                DB_utils::addNotification($note);

                $email['subject'] = 'cargo modified by ' . $originator->getName();
                $email['title'] = 'ROHEL | E-mail';
                $email['header'] = 'A cargo was modified by ' . $originator->getName();
                $email['body-1'] = 'has modified a field ('.$_POST['id'].' => '.$_POST['value'].') on cargo bound to <strong>' . $cargo->getToCity() . '</strong>' . '.';
                $email['body-2'] = 'The loading date is <strong>' . date(Utils::$PHP_DATE_FORMAT, $cargo->getLoadingDate()) . '</strong>';
                $email['link']['url'] = Mails::$BASE_HREF.'/?page=cargoInfo&id='.$cargo->getId();
                $email['link']['text'] = 'View the cargo details';

                break;
            }
            case 'cargo_truck':  {
                $truck = DB_utils::selectTruck($_SESSION['entry-id']);

                // Add a notification to the receiver of the cargo
                $note = new Notification();
                $note->setUserId($truck->getRecipient());
                $note->setOriginatorId($_SESSION['operator']['id']);

                // When the recipient is changed
                if($_POST['id'] == 'recipient') {
                    $note->setKind(1);
                }
                else {
                    $note->setKind(2);
                }

                $note->setEntityKind(2);
                $note->setEntityId($truck->getId());

                DB_utils::addNotification($note);

                $email['subject'] = 'Truck order modified by ' . $originator->getName();
                $email['title'] = 'ROHEL | E-mail';
                $email['header'] = 'A truck order was modified by ' . $originator->getName();
                $email['body-1'] = 'has modified a field ('.$_POST['id'].' => '.$_POST['value'].') on truck order from <strong>' . $truck->getFromCity() . '</strong>' . '.';
                $email['body-2'] = 'The loading date is <strong>' . date(Utils::$PHP_DATE_FORMAT, $truck->getLoadingDate()) . '</strong>';
                $email['link']['url'] = Mails::$BASE_HREF.'/?page=truckInfo&id='.$truck->getId();
                $email['link']['text'] = 'View the truck order details';

                break;
            }
            default: {
                Utils::log('Unknown page set-up when trying for a generic update.');
                return false;
            }
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

    echo DB_utils::returnValue($table, $_POST['id'], $_POST['value'], $_SESSION['entry-id']);
}
