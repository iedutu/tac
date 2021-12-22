<?php
session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

use Rohel\Notification;
use Rohel\Truck;
use Rohel\TruckStop;

if (! Utils::authorized(Utils::$INSERT)) {
    AppLogger::getLogger()->info("User not authorized to insert data in the database.");
    header ( 'Location: /' );
    exit ();
}

if (isset ( $_POST ['_submitted'] )) {
    $truck = new Truck();
    
    try {
        DB::getMDB()->startTransaction();
        $truck->setOriginator($_SESSION['operator']['id']);
        $truck->setRecipient($_POST ['recipient']);
        $truck->setFromCity($_POST ['from_city']);
        $truck->setFromAddress($_POST ['from_address']);
        if(!empty($_POST ['rohel_truck_loading'])) $truck->setLoadingDate(strtotime($_POST ['rohel_truck_loading']));
        if(!empty($_POST ['rohel_truck_unloading'])) $truck->setUnloadingDate(strtotime($_POST ['rohel_truck_unloading']));
        $truck->setFreight($_POST ['freight']);
        if(!empty($_POST['adr'])) $truck->setAdr($_POST ['adr']);
        $truck->setContractType($_POST ['contract_type']);
        switch($truck->getContractType()) {
            case 'Round-trip': {
                $truck->setStatus(AppStatuses::$TRUCK_AVAILABLE);
                break;
            }
            case 'One-way': {
                $truck->setStatus(AppStatuses::$TRUCK_FREE);
                break;
            }
            case 'Free-on-market': {
                $truck->setStatus(AppStatuses::$TRUCK_MARKET);
                break;
            }
            default: {
                $truck->setStatus(0);
            }
        }
        $truck->setAmeta($_POST ['ameta']);
        $truck->setPlateNumber($_POST ['plate_number']);
        $truck->setDetails($_POST ['details']);
        $truck->setClient($_POST ['client']);
        $truck->setUnloadingZone($_POST ['unloading_zone']);
        $truck->setRetourLoadingFrom($_POST ['retour_loading_from']);
        $truck->setRetourUnloadingFrom($_POST ['retour_unloading_from']);
        if(!empty($_POST ['retour_loading_date'])) $truck->setRetourLoadingDate(strtotime($_POST ['retour_loading_date']));
        if(!empty($_POST ['retour_unloading_date'])) $truck->setRetourUnloadingDate(strtotime($_POST ['retour_unloading_date']));

        $truck->setId(DB_utils::insertTruck($truck));
        $truck_final_destination = '';

        $stops = [];
        $error = false;
        for($i=0;$i<sizeof($_POST['stops']);$i++) {
            $stop = new TruckStop();

            if(!empty($_POST['stops'][$i]['volume'])) {
                if(is_numeric($_POST['stops'][$i]['volume'])) {
                    $stop->setVolume($_POST['stops'][$i]['volume']);
                }
                else {
                    $error = true;
                    $_SESSION['alert']['type'] = 'error';
                    $_SESSION['alert']['message'] = 'Wrong number format received for: '.$_POST['stops'][$i]['volume'].'. Good number format: 1.55. Please remove the faulty stop entry from the truck details page and re-enter it.';
                }
            }

            if(!empty($_POST['stops'][$i]['weight'])) {
                if(is_numeric($_POST['stops'][$i]['weight'])) {
                    $stop->setWeight($_POST['stops'][$i]['weight']);
                }
                else {
                    $error = true;
                    $_SESSION['alert']['type'] = 'error';
                    $_SESSION['alert']['message'] = 'Wrong number format received for: '.$_POST['stops'][$i]['weight'].'. Good number format: 1.55. Please remove the faulty stop entry from the truck details page and re-enter it.';
                }
            }

            if(!empty($_POST['stops'][$i]['loading'])) {
                if(is_numeric($_POST['stops'][$i]['loading'])) {
                    $stop->setLoadingMeters($_POST['stops'][$i]['loading']);
                }
                else {
                    $error = true;
                    $_SESSION['alert']['type'] = 'error';
                    $_SESSION['alert']['message'] = 'Wrong number format received for: '.$_POST['stops'][$i]['loading'].'. Good number format: 1.55. Please remove the faulty stop entry from the truck details page and re-enter it.';
                }
            }
            else {
                $error = true;
                $_SESSION['alert']['type'] = 'error';
                $_SESSION['alert']['message'] = 'Loading meters is a mandatory field for each stop. Please remove the faulty stop entry from the truck details page and re-enter it.';
            }

            if(!empty($_POST['stops'][$i]['to_city'])) {
                $stop->setCity($_POST['stops'][$i]['to_city']);
            }
            else {
                $error = true;
                $_SESSION['alert']['type'] = 'error';
                $_SESSION['alert']['message'] = 'City name is a mandatory field for each stop. Please remove the faulty stop entry from the truck details page and re-enter it.';
            }
            $stop->setAddress($_POST['stops'][$i]['to_address']);
            $stop->setStopId($i);
            $stop->setTruckId($truck->getId());

            $truck_final_destination = $stop->getCity();

            DB_utils::insertTruckStop($stop);
            $stops[$i] = $stop;
        }

        $truck->setStop($stops);

        Utils::insertCargoAuditEntry('cargo_truck', 'NEW-ENTRY', null, $truck->getId());

        // Set the trigger for the generation of the Match page
        DB_utils::writeValue('changes', '1');
        DB::getMDB()->commit();

        // Add a notification to the receiver of the truck
        $note = new Notification();
        $note->setUserId($truck->getRecipient());
        $note->setOriginatorId($_SESSION['operator']['id']);
        $note->setKind(AppStatuses::$NOTIFICATION_KIND_NEW);
        $note->setEntityKind(AppStatuses::$NOTIFICATION_ENTITY_KIND_TRUCK);
        $note->setEntityId($truck->getId());

        DB_utils::addNotification($note);

        // Send a notification e-mail to the recipient
        $originator = DB_utils::selectUserById($truck->getOriginator());
        $recipient = DB_utils::selectUserById($truck->getRecipient());

        $email['subject'] = 'New truck order received from '.$originator->getName();
        $email['title'] = 'ROHEL | E-mail';
        $email['header'] = ' You have a new truck order from '.$originator->getName();
        $email['body-1'] = 'has introduced a new truck order for your consideration.';
        $email['body-2'] = 'The unloading date is <strong>'.date(Utils::$PHP_DATE_FORMAT, $truck->getUnloadingDate()).'</strong>';
        $email['originator']['e-mail'] = $originator->getUsername();
        $email['originator']['name'] = $originator->getName();
        $email['recipient']['e-mail'] = $recipient->getUsername();
        $email['recipient']['name'] = $recipient->getName();
        $email['link']['url'] = Mails::$BASE_HREF.'/?page=truckInfo&id='.$truck->getId();
        $email['link']['text'] = 'View the detailed truck order';
        $email['bg-color'] = Mails::$BG_NEW_COLOR;
        $email['tx-color'] = Mails::$TX_NEW_COLOR;

        Mails::emailNotification($email);
    } catch (ApplicationException $ae) {
        $error = true;
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Application error ('.$ae->getCode().':'.$ae->getMessage().'). Please contact your system administrator.';
    } catch (Exception $e) {
        Utils::handleException($e);
        $error = true;
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'General error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';
    }

    if(!$error) {
        $_SESSION['alert']['type'] = 'success';
        $_SESSION['alert']['message'] = 'A new notification was added into the system for the cargo request. ' . $recipient->getName() . ' was notified by e-mail.';
    }

    header ( "Location: /?page=trucks" );
    exit();
}

header ( "Location: /" );
exit();