<?php
session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

use Rohel\Truck;
use Rohel\TruckStop;

if (! Utils::authorized(Utils::$INSERT)) {
    error_log("User not authorized to insert data in the database.");
    header ( 'Location: /' );
    exit ();
}

if (isset ( $_POST ['_submitted'] )) {
    $truck = new Truck();
    
    try {
        $truck->setStatus(1);
        $truck->setOriginator($_SESSION['operator']['id']);
        $truck->setRecipient($_POST ['recipient']);
        $truck->setFromCity($_POST ['from_city']);
        $truck->setFromAddress($_POST ['from_address']);
        if(!empty($_POST ['rohel_truck_loading'])) $truck->setLoadingDate(strtotime($_POST ['rohel_truck_loading']));
        if(!empty($_POST ['rohel_truck_unloading'])) $truck->setUnloadingDate(strtotime($_POST ['rohel_truck_unloading']));
        $truck->setFreight($_POST ['freight']);
        if(!empty($_POST['adr'])) $truck->setAdr($_POST ['adr']);
        $truck->setContractType($_POST ['contract_type']);
        $truck->setAmeta($_POST ['ameta']);
        $truck->setPlateNumber($_POST ['plate_number']);
        $truck->setDetails($_POST ['details']);

        $id = DB_utils::insertTruck($truck);
        $truck_final_destination = '';

        $stops = [];
        for($i=0;$i<sizeof($_POST['stops']);$i++) {
            $stop = new TruckStop();

            $stop->setVolume($_POST['stops'][$i]['volume']);
            $stop->setWeight($_POST['stops'][$i]['weight']);
            $stop->setLoadingMeters($_POST['stops'][$i]['loading_meters']);
            $stop->setCity($_POST['stops'][$i]['to_city']);
            $stop->setAddress($_POST['stops'][$i]['to_address']);
            $stop->setStopId($i);
            $stop->setTruckId($id);

            $truck_final_destination = $stop->getCity();

            DB_utils::insertTruckStop($stop);
            $stops[$i] = $stop;
        }

        $truck->setStop($stops);

        Utils::insertCargoAuditEntry('cargo_truck', 'NEW-ENTRY', null, $truck->getRecipient());

        // Set the trigger for the generation of the Match page
        DB_utils::writeValue('changes', '1');

        // Add a notification to the receiver of the cargo request
        DB_utils::addNotification($truck->getRecipient(), 1, 2, $truck->getId());

        // Send an e-mail notification
        $originator = DB_utils::selectUserById($truck->getOriginator());
        $recipient = DB_utils::selectUserById($truck->getRecipient());

        $email['subject'] = 'New cargo request received from '.$originator->getName();
        $email['title'] = 'ROHEL | E-mail';
        $email['header'] = ' You have a new cargo request from '.$originator->getName();
        $email['template'] = $_SERVER["DOCUMENT_ROOT"].'/html/newTruck.html';
        $email['originator'] = $originator->getUsername();
        $email['recipient'] = $recipient->getUsername();
        $email['status-label'] = 'label-info';
        $email['status-name'] = 'NEW';

        Mails::emailNewTruckEntryNotification($truck, $email);
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
    $_SESSION['alert']['message'] = 'A new notification was added into the system for the truck order. '.$truck->getRecipient().' was notified by e-mail.';

    header ( "Location: /?page=trucks" );
    exit();
}

header ( "Location: /" );
exit();