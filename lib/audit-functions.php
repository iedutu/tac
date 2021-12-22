<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/GPBMetadata/Types.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/Request.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/Truck.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/RequestUpdates.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/TruckUpdates.php";

use PHPMailer\PHPMailer\PHPMailer;
use Rohel\Request;
use Rohel\Truck;
use Rohel\RequestUpdates;
use Rohel\TruckUpdates;

class Audit {
    public static function writeCargo(RequestUpdates $a): bool
    {
        if(isset($_SESSION['role'])) {
            if($_SESSION['role'] == 'originator') {
                $for_whom = 'recipient';
            }
            else {
                if($_SESSION['role'] == 'recipient') {
                    $for_whom = 'originator';
                }
                else {
                    $for_whom = 'unknown';
                }
            }
        }
        else {
            $for_whom = 'unknown';
        }

        $filename = $_SERVER["DOCUMENT_ROOT"] . '/notifications/cargo_request_' . $for_whom.'_'.$_SESSION['entry-id'].'.bin';
        $ok = true;

        try {
            $data = $a->serializeToJsonString();
            file_put_contents($filename, $data);
        } catch (Exception $e) {
            AppLogger::getLogger()->error("Generic write error: " . $e->getMessage());

            return false;
        }

        return $ok;
    }

    public static function readCargo(int $id, string $for_whom): ?RequestUpdates
    {
        $filename = $_SERVER["DOCUMENT_ROOT"] . '/notifications/cargo_request_' . $for_whom.'_'.$id . '.bin';

        try {
            $a = new RequestUpdates();

            if (!is_file($filename)) {
                return $a;
            }

            $data = file_get_contents($filename);
            $a->mergeFromJsonString($data);
        } catch (Exception $e) {
            AppLogger::getLogger()->error("Generic read error while loading a file for [".$for_whom."]: " . $e->getMessage());
            AppLogger::getLogger()->debug("Trace: " . $e->getTraceAsString());

            return new RequestUpdates();
        }

        $a->setId($id);

        return $a;
    }

    public static function clearCargo(int $id, string $for_whom): bool
    {
        $filename = $_SERVER["DOCUMENT_ROOT"] . '/notifications/cargo_request_' . $for_whom.'_'.$id . '.bin';

        try {
            if (is_file($filename)) {
                unlink($filename);
            }
        } catch (Exception $e) {
            Utils::handleException($e);
            return false;
        }

        return true;
    }

    public static function writeTruck(TruckUpdates $a): bool
    {
        if(isset($_SESSION['role'])) {
            if($_SESSION['role'] == 'originator') {
                $for_whom = 'recipient';
            }
            else {
                if($_SESSION['role'] == 'recipient') {
                    $for_whom = 'originator';
                }
                else {
                    $for_whom = 'unknown';
                }
            }
        }
        else {
            $for_whom = 'unknown';
        }

        $filename = $_SERVER["DOCUMENT_ROOT"] . '/notifications/cargo_truck_' . $for_whom.'_'.$_SESSION['entry-id']. '.bin';
        $ok = true;

        try {
            $data = $a->serializeToJsonString();
            file_put_contents($filename, $data);
        } catch (Exception $e) {
            AppLogger::getLogger()->error("Generic write error: " . $e->getMessage());

            return false;
        }

        return $ok;
    }

    public static function readTruck(int $id): ?TruckUpdates
    {
        $for_whom = $_SESSION['role'] ?? 'unknown';
        $filename = $_SERVER["DOCUMENT_ROOT"] . '/notifications/cargo_truck_' . $for_whom.'_'.$id . '.bin';
        $a = new TruckUpdates();

        try {
            if (!is_file($filename)) {
//                AppLogger::getLogger()->error("File not found: " . $filename . ". Returning an empty object.");
                return $a;
            }

            $data = file_get_contents($filename);
            $a->mergeFromJsonString($data);
        } catch (Exception $e) {
            AppLogger::getLogger()->error("Generic read error: " . $e->getMessage());

            return new TruckUpdates();
        }

        $a->setId($id);

        return $a;
    }

    public static function clearTruck(int $id): bool
    {
        $for_whom = $_SESSION['role'] ?? 'unknown';
        $filename = $_SERVER["DOCUMENT_ROOT"] . '/notifications/cargo_truck_' . $for_whom.'_'.$id . '.bin';

        try {
            if (is_file($filename)) {
                unlink($filename);
            }
        } catch (Exception $e) {
            Utils::handleException($e);
            return false;
        }

        return true;
    }

    public static function highlightPageItem(string $table, string $row, int $id) {
        switch($table) {
            case 'cargo_request': {
                if($_SESSION['role'] == 'originator') {
                    $a = self::readCargo($id, 'recipient');
                }
                else {
                    if($_SESSION['role'] == 'recipient') {
                        $a = self::readCargo($id, 'originator');
                    }
                    else {
                        AppLogger::getLogger()->error('Cannot determine to whom I shall write the audit file to.');
                        return;
                    }
                }

                switch($row) {
                    case 'id':              { $a->setId(true); break;}
                    case 'operator':        { $a->setOperator(true); break;}
                    case 'originator_id':   { $a->setOriginator(true); break;}
                    case 'client':          { $a->setClient(true); break;}
                    case 'from_city':       { $a->setFromCity(true); break;}
                    case 'from_address':    { $a->setFromAddress(true); break;}
                    case 'to_city':         { $a->setToCity(true); break;}
                    case 'to_address':      { $a->setToAddress(true); break;}
                    case 'loading_date':    { $a->setLoadingDate(true); break;}
                    case 'unloading_date':  { $a->setUnloadingDate(true); break;}
                    case 'description':     { $a->setDescription(true); break;}
                    case 'collies':         { $a->setCollies(true); break;}
                    case 'weight':          { $a->setWeight(true); break;}
                    case 'volume':          { $a->setVolume(true); break;}
                    case 'loading_meters':  { $a->setLoadingMeters(true); break;}
                    case 'freight':         { $a->setFreight(true); break;}
                    case 'instructions':    { $a->setInstructions(true); break;}
                    case 'acceptance':      { $a->setAcceptance(true); break;}
                    case 'expiration':      { $a->setExpiration(true); break;}
                    case 'plate_number':    { $a->setPlateNumber(true); break;}
                    case 'ameta':           { $a->setAmeta(true); break;}
                    case 'order_type':      { $a->setOrderType(true); break;}
                    case 'adr':             { $a->setAdr(true); break;}
                    case 'recipient_id':    { $a->setRecipient(true); break;}
                    case 'status':          { $a->setStatus(true); break;}
                    case 'accepted_by':     { $a->setAcceptedBy(true); break;}
                    case 'dimensions':      { $a->setDimensions(true); break;}
                    case 'package':         { $a->setPackage(true); break;}
                    case 'shipper':         { $a->setShipper(true); break;}
                    default:                { AppLogger::getLogger()->error('Wrong data row received in Utils::highlightPageItem() => '.$row); break;}
                }
                self::writeCargo($a);

                break;
            }
            case 'cargo_truck': {
                $a = self::readTruck($id);

                switch($row) {
                    case 'id':                      { $a->setId(true); break;}
                    case 'operator':                { $a->setOperator(true); break;}
                    case 'originator_id':           { $a->setOriginator(true); break;}
                    case 'recipient_id':            { $a->setRecipient(true); break;}
                    case 'accepted_by':             { $a->setAcceptedBy(true); break;}
                    case 'status':                  { $a->setStatus(true); break;}
                    case 'from_city':               { $a->setFromCity(true); break;}
                    case 'from_address':            { $a->setFromAddress(true); break;}
                    case 'loading_date':            { $a->setLoadingDate(true); break;}
                    case 'unloading_date':          { $a->setUnloadingDate(true); break;}
                    case 'availability':            { $a->setAvailability(true); break;}
                    case 'acceptance':              { $a->setAcceptance(true); break;}
                    case 'expiration':              { $a->setExpiration(true); break;}
                    case 'details':                 { $a->setDetails(true); break;}
                    case 'freight':                 { $a->setFreight(true); break;}
                    case 'plate_number':            { $a->setPlateNumber(true); break;}
                    case 'ameta':                   { $a->setAmeta(true); break;}
                    case 'cargo_type':              { $a->setCargoType(true); break;}
                    case 'truck_type':              { $a->setTruckType(true); break;}
                    case 'contract_type':           { $a->setContractType(true); break;}
                    case 'adr':                     { $a->setAdr(true); break;}
                    case 'unloading_zone':          { $a->setUnloadingZone(true); break;}
                    case 'retour_loading_from':     { $a->setRetourLoadingFrom(true); break;}
                    case 'retour_unloading_from':   { $a->setRetourUnloadingFrom(true); break;}
                    case 'retour_loading_date':     { $a->setRetourLoadingDate(true); break;}
                    case 'retour_unloading_date':   { $a->setRetourUnloadingDate(true); break;}
                    case 'client':                  { $a->setClient(true); break;}
                    default:                        { AppLogger::getLogger()->error('Wrong data row received: '.$row); break;}
                }

                self::writeTruck($a);

                break;
            }
            default: {
                AppLogger::getLogger()->error('Wrong table received: '.$table);

                break;
            }
        }
    }

}
