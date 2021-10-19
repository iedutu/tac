<?php
session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

use PHPMailer\PHPMailer\PHPMailer;
use Rohel\Notification;
use Rohel\TruckStop;

if (! Utils::authorized(Utils::$INSERT)) {
    error_log("User not authorized to insert data in the database.");
	header ( 'Location: /' );
	exit ();
}

if (isset ( $_POST ['_submitted'] )) {
    try {
        $stop = new TruckStop();
        $stop->setStopId($_POST['stop_id']);
        $stop->setTruckId($_SESSION['entry-id']);
        $stop->setCity($_POST['city']);
        $stop->setAddress($_POST['address']);
        $stop->setLoadingMeters($_POST['loading_meters']);
        $stop->setWeight($_POST['weight']);
        $stop->setVolume($_POST['volume']);
        $stop->setCmr($_POST['cmr']);

        $id = DB_utils::insertTruckStop($stop);

        // Set the trigger for the generation of the Match page
        DB_utils::writeValue('changes', '1');

        // Add a notification to the receiver of the truck
        $truck = DB_utils::selectTruck($stop->getTruckId());
        $note = new Notification();
        $note->setUserId($truck->getRecipient());
        $note->setOriginatorId($_SESSION['operator']['id']);
        $note->setKind(1);
        $note->setEntityKind(3);
        $note->setEntityId($truck->getId());

        DB_utils::addNotification($note);

        // Send a notification e-mail to the recipient
        $originator = DB_utils::selectUserById($truck->getOriginator());
        $recipient = DB_utils::selectUserById($truck->getRecipient());

        $email['subject'] = 'New truck order received from '.$originator->getName();
        $email['title'] = 'ROHEL | E-mail';
        $email['header'] = ' You have a new truck order from '.$originator->getName();
        $email['body-1'] = 'has introduced a new scheduled truck stop in <strong>'.$stop->getCity().'</strong>.';
        $email['body-2'] = 'The unloading date is <strong>'.date(Utils::$PHP_DATE_FORMAT, $truck->getUnloadingDate()).'</strong>';
        $email['originator']['e-mail'] = $originator->getUsername();
        $email['originator']['name'] = $originator->getName();
        $email['recipient']['e-mail'] = $recipient->getUsername();
        $email['recipient']['name'] = $recipient->getName();
        $email['link']['url'] = 'https://rohel.iedutu.com/?page=truckInfo&id='.$truck->getId();
        $email['link']['text'] = 'View the detailed truck order';
        $email['bg-color'] = Mails::$BG_NEW_COLOR;
        $email['tx-color'] = Mails::$TX_NEW_COLOR;

        Mails::emailNotification($email);
    } catch (ApplicationException $ae) {
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Application error ('.$ae->getCode().':'.$ae->getMessage().'). Please contact your system administrator.';

        return 0;
    } catch (Exception $e) {
        Utils::handleException($e);
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'General error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

        return 0;
    }

    $_SESSION['alert']['type'] = 'success';
    $_SESSION['alert']['message'] = 'A new notification was added into the system for the truck order. '.$recipient->getName().' was notified by e-mail.';

    header ( 'Location: /?page=truckInfo&id='.$_SESSION['entry-id']);
    exit();
}

header ( "Location: /" );
exit();