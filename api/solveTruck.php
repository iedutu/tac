<?php

use PHPMailer\PHPMailer\PHPMailer;
use Rohel\Notification;

session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";
include $_SERVER["DOCUMENT_ROOT"]."/lib/mail-settings.php";

if (isset ( $_POST ['id'] )) {
    $truck = DB_utils::selectTruck($_POST ['id']);
    if(is_null($truck)) {
        header ( 'Location: /index.php?page=truckInfo&id='.$_POST['id'] );
        exit();
    }

    if($truck->getStatus() > AppStatuses::$TRUCK_PARTIALLY_SOLVED) {
        AppLogger::getLogger()->info('Truck already solved/loaded. Please contact the recipient directly.');
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
        DB_utils::updateTruckStatus($truck, AppStatuses::$TRUCK_FULLY_SOLVED);

        Utils::insertCargoAuditEntry('cargo_truck', 'status', $truck->getId(), AppStatuses::$TRUCK_FULLY_SOLVED);

        // Set the trigger for the generation of the Match page
        DB_utils::writeValue('changes', '1');

        // Add a notification to the receiver of the truck
        $note = new Notification();
        $note->setUserId($truck->getRecipient());
        $note->setOriginatorId($_SESSION['operator']['id']);
        $note->setKind(AppStatuses::$NOTIFICATION_KIND_CHANGED);
        $note->setEntityKind(AppStatuses::$NOTIFICATION_ENTITY_KIND_TRUCK);
        $note->setEntityId($truck->getId());

        DB_utils::addNotification($note);

        // Send a notification e-mail to the recipient
        $originator = DB_utils::selectUserById($truck->getOriginator());
        $recipient = DB_utils::selectUserById($truck->getRecipient());

        $email['subject'] = 'Truck order marked as fully loaded by ' . $recipient->getName();
        $email['title'] = 'ROHEL | E-mail';
        $email['header'] = 'A truck order was marked as fully loaded by ' . $recipient->getName();
        $email['body-1'] = 'has marked as fully loaded a truck order from <strong>' . $truck->getFromCity() . '</strong>' . '.';
        $email['body-2'] = 'The loading date is <strong>' . date(Utils::$PHP_DATE_FORMAT, $truck->getLoadingDate()) . '</strong>';
        $email['originator']['e-mail'] = $recipient->getUsername();
        $email['originator']['name'] = $recipient->getName();
        $email['recipient']['e-mail'] = $originator->getUsername();
        $email['recipient']['name'] = $originator->getName();
        $email['link']['url'] = Mails::$BASE_HREF.'/?page=truckInfo&id=' . $truck->getId();
        $email['link']['text'] = 'View the truck order details';
        $email['bg-color'] = Mails::$BG_FULLY_LOADED_COLOR;
        $email['tx-color'] = Mails::$TX_FULLY_LOADED_COLOR;

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
    $_SESSION['alert']['message'] .= ' Notification e-mail sent to '.$recipient->getName().'.';

    header ( 'Location: /index.php?page=truckInfo&id='.$truck->getId() );
    exit();
}

header ( 'Location: /index.php?page=trucks' );
exit();