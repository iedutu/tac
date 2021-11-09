<?php

use Rohel\Notification;

session_start();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

if(!empty($_POST['id'])) {
    try {
        $status = 0;

        switch($_POST['value']) {
            case 'Round-trip': {
                $status = AppStatuses::$TRUCK_AVAILABLE;
                break;
            }
            case 'One-way': {
                $status = AppStatuses::$TRUCK_FREE;
                break;
            }
            case 'Free-on-market': {
                $status = AppStatuses::$TRUCK_NEW;
                break;
            }
        }

        $table = DB_utils::updateGenericField($_POST['id'], $_POST['value'], $_SESSION['entry-id']);
        $truck = DB_utils::selectTruck($_SESSION['entry-id']);

        DB_utils::updateTruckStatus($truck, $status);

        Utils::insertCargoAuditEntry($table, $_POST['id'], $_SESSION['entry-id'], $_POST['value']);
        Utils::highlightPageItem($table, $_POST['id'], $_SESSION['entry-id']);

        // Set the trigger for the generation of the Match page
        DB_utils::writeValue('changes', '1');

        // Send a notification e-mail to the recipient
        $recipient = DB_utils::selectUserById($_SESSION['recipient-id']);
        $originator = DB_utils::selectUserById($_SESSION['originator-id']);

        // Add a notification to the receiver of the cargo
        $note = new Notification();
        $note->setUserId($truck->getRecipient());
        $note->setOriginatorId($_SESSION['operator']['id']);
        $note->setKind(AppStatuses::$NOTIFICATION_KIND_CHANGED);
        $note->setEntityKind(AppStatuses::$NOTIFICATION_ENTITY_KIND_TRUCK);
        $note->setEntityId($truck->getId());

        DB_utils::addNotification($note);

        $email['subject'] = 'Truck order modified by ' . $originator->getName();
        $email['title'] = 'ROHEL | E-mail';
        $email['header'] = 'A truck order was modified by ' . $originator->getName();
        $email['body-1'] = 'has modified a field ('.$_POST['id'].' => '.$_POST['value'].') on truck order from <strong>' . $truck->getFromCity() . '</strong>' . '.';
        $email['body-2'] = 'The loading date is <strong>' . date(Utils::$PHP_DATE_FORMAT, $truck->getLoadingDate()) . '</strong>';
        $email['link']['url'] = Mails::$BASE_HREF.'/?page=truckInfo&id='.$truck->getId();
        $email['link']['text'] = 'View the truck order details';

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
