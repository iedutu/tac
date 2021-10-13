<?php

use Billing\Address;
use Billing\Balance;
use Billing\Card;
use Billing\Car;
use Billing\Notification;
use Billing\Subscriber;
use Billing\Vendor;
use Billing\Station;

include_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/GPBMetadata/Types.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/Request.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/Truck.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/TruckStop.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/User.php";

use \Rohel\Request;
use \Rohel\Truck;
use Rohel\TruckStop;
use \Rohel\User;


include $_SERVER['DOCUMENT_ROOT'] . "/lib/db-settings.php";

class DB_utils
{
    public static function selectCargoFromOptions() {

    }

    public static function selectOffices() {
        try {
            $offices = DB::getMDB()->query('select * from cargo_offices order by importance asc');
            echo '<option value="">All</option>';
            foreach ($offices as $office) {
                echo '<option value="'.$office['name'].'">'.$office['name'].'</option>';
            }
        }
        catch (MeekroDBException $mdbe) {
            error_log("Database error: ".$mdbe->getMessage());
            return false;
        }
        catch (Exception $e) {
            error_log("Database error: ".$e->getMessage());

            return false;
        }
    }

    public static function selectActiveUsers() {
        try {
            $users = DB::getMDB()->query('SELECT * FROM cargo_users where (id <> %s) and (class < 2) order by name asc', $_SESSION['operator']['id']);
            foreach ($users as $user) {
                echo '<option value="'.$user['id'].'">'.$user['name'].'</option>';
            }
        }
        catch (MeekroDBException $mdbe) {
            error_log("Database error: ".$mdbe->getMessage());
            return false;
        }
        catch (Exception $e) {
            error_log("Database error: ".$e->getMessage());

            return false;
        }
    }

    public static function countryMatch(int $other): bool
    {
        try {
            $country = DB::getMDB()->queryOneField('country_id', 'SELECT country_id FROM cargo_users WHERE id = %d', $other);
            error_log('Country selected: '. $country);
        }
        catch (MeekroDBException $mdbe) {
            error_log("Database error: ".$mdbe->getMessage());
            return false;
        }
        catch (Exception $e) {
            error_log("Database error: ".$e->getMessage());

            return false;
        }

        return $country == $_SESSION['operator']['country-id'];
    }

    public static function isEditable(int $originator, int $recipient): array
    {
        // Who can edit the cargo
        // 1. The one who created it
        error_log('isEditable request: ['.$originator.']['.$recipient.']');
        if (($_SESSION['operator']['id'] == $originator) || self::countryMatch($originator)){
            $result['originator'] = true;
        }
        else {
            $result['originator'] = false;
        }

        $result['recipient'] = self::countryMatch($recipient);

        error_log('isEditable response: ['.$result['originator'].']['.$result['recipient'].']');
        return $result;
    }

    public static function selectRequest(int $id): ?Request
    {
        try {
            $row = DB::getMDB()->queryOneRow("select * from cargo_request where id=%d", $id);

            if (is_null($row)) {
                error_log("No cargo_request was found for id=".$id);

                return null;
            }

            $request = new Request();

            if(!empty($row['acceptance'])) $request->setAcceptance(strtotime($row['acceptance']));
            $request->setAcceptedBy($row['accepted_by']);
            $request->setAdr($row['adr']);
            $request->setAmeta($row['ameta']);
            $request->setClient($row['client']);
            $request->setCollies($row['collies']);
            $request->setDescription($row['description']);
            if(!empty($row['expiration'])) $request->setExpiration(strtotime($row['expiration']));
            $request->setFreight($row['freight']);
            $request->setFromAddress($row['from_address']);
            $request->setFromCity($row['from_city']);
            $request->setId($row['id']);
            $request->setInstructions($row['instructions']);
            if(!empty($row['loading_date'])) $request->setLoadingDate(strtotime($row['loading_date']));
            $request->setLoadingMeters($row['loading_meters']);
            $request->setOperator($row['operator']);
            $request->setOrderType($row['order_type']);
            $request->setOriginator($row['originator_id']);
            $request->setPlateNumber($row['plate_number']);
            $request->setRecipient($row['recipient_id']);
            $request->setStatus($row['status']);
            $request->setToAddress($row['to_address']);
            $request->setToCity($row['to_city']);
            if(!empty($row['unloading_date'])) $request->setUnloadingDate(strtotime($row['unloading_date']));
            $request->setVolume($row['volume']);
            $request->setWeight($row['weight']);

            return $request;
        }
        catch (MeekroDBException $mdbe) {
            error_log("Database error: ".$mdbe->getMessage());
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';

            return null;
        }
        catch (Exception $e) {
            error_log("Database error: ".$e->getMessage());
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

            return null;
        }
    }

    public static function updateRequest(Request $request): bool
    {
        try {
            $row = DB::getMDB()->update ( 'cargo_request', array (
                'acceptance' => $request->getAcceptance(),
                'accepted_by' => $request->getAcceptedBy(),
                'adr' => $request->getAdr(),
                'ameta' => $request->getAmeta(),
                'client' => $request->getClient(),
                'collies' => $request->getCollies(),
                'description' => $request->getDescription(),
                'expiration' => $request->getExpiration(),
                'freight' => $request->getFreight(),
                'from_address' => $request->getFromAddress(),
                'from_city' => $request->getFromCity(),
                'instructions' => $request->getInstructions(),
                'loading_date' => $request->getLoadingDate(),
                'loading_meters' => $request->getLoadingMeters(),
                'operator' => $_SESSION['operator'],
                'order_type' => $request->getOrderType(),
                'originator' => $request->getOriginator(),
                'plate_number' => $request->getPlateNumber(),
                'recipient' => $request->getRecipient(),
                'status' => $request->getStatus(),
                'to_address' => $request->getToAddress(),
                'to_city' => $request->getToCity(),
                'unloading_date' => $request->getUnloadingDate(),
                'volume' => $request->getVolume(),
                'weight' => $request->getWeight()
            ), "id=%d", $request->getId() );
        }
        catch (MeekroDBException $mdbe) {
            error_log("Database error: ".$mdbe->getMessage());
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';

            return false;
        }
        catch (Exception $e) {
            error_log("Database error: ".$e->getMessage());
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

            return false;
        }

        return true;
    }

    public static function selectTruck(int $id): ?Truck
    {
        try {
            $row = DB::getMDB()->queryOneRow("select * 
                                                  from 
                                                     cargo_truck 
                                                  where 
                                                     id=%d", $id);
            if (is_null($row)) {
                error_log('No cargo_truck was found for id='.$id.' in selectTruck()');

                return null;
            }

            $truck = new Truck();
            if(!empty($row['acceptance'])) $truck->setAcceptance(strtotime($row['acceptance']));
            $truck->setAcceptedBy($row['accepted_by']);
            $truck->setAdr($row['adr']);
            $truck->setAmeta($row['ameta']);
            if(!empty($row['availability'])) $truck->setAvailability(strtotime($row['availability']));
            $truck->setCargoType($row['cargo_type']);
            $truck->setContractType($row['contract_type']);
            $truck->setDetails($row['details']);
            if(!empty($row['expiration'])) $truck->setExpiration(strtotime($row['expiration']));
            $truck->setFreight($row['freight']);
            $truck->setFromAddress($row['from_address']);
            $truck->setFromCity($row['from_city']);
            $truck->setId($id);
            if(!empty($row['loading_date'])) $truck->setLoadingDate(strtotime($row['loading_date']));
            $truck->setOperator($row['operator']);
            $truck->setOrderType($row['order_type']);
            $truck->setOriginator($row['originator_id']);
            $truck->setPlateNumber($row['plate_number']);
            $truck->setStatus($row['status']);
            $truck->setRecipient($row['recipient_id']);
            $truck->setTruckType($row['truck_type']);
            if(!empty($row['unloading_date'])) $truck->setUnloadingDate(strtotime($row['unloading_date']));

            // Add the truck stops
            $results = DB::getMDB()->query("select * 
                                                  from 
                                                     cargo_truck_stops 
                                                  where 
                                                     truck_id=%d
                                                  order by stop_id asc", $id);
            if (is_null($results)) {
                error_log('No cargo_truck_stops was found for truck_id='.$id.' in selectTruck(). At least one is required.');

                return null;
            }

            $i = 0;
            $stops = [];
            foreach ($results as $result) {
                $stop = new TruckStop();
                $stop->setId($result['id']);
                $stop->setTruckId($result['truck_id']);
                $stop->setCity($result['city']);
                if(!empty($row['cmr'])) $stop->setCmr($result['cmr']);
                if(!empty($row['weight'])) $stop->setWeight($result['weight']);
                if(!empty($row['volume'])) $stop->setVolume($result['volume']);
                if(!empty($row['loading_meters'])) $stop->setLoadingMeters($result['loading_meters']);

                $stops[$i] = $stop;
                $i++;
            }
            $truck->setStop($stops);

            return $truck;
        }
        catch (MeekroDBException $mdbe) {
            error_log("Database error: ".$mdbe->getMessage());
            return null;
        }
        catch (Exception $e) {
            error_log("Database error: ".$e->getMessage());
            return null;
        }
    }

    public static function updateTruck(Truck $truck): bool
    {
        try {
            $row = DB::getMDB()->update ( 'cargo_truck', array (
                'acceptance' => $truck->getAcceptance(),
                'accepted_by' => $truck->getAcceptedBy(),
                'adr' => $truck->getAdr(),
                'ameta' => $truck->getAmeta(),
                'expiration' => $truck->getExpiration(),
                'freight' => $truck->getFreight(),
                'from_address' => $truck->getFromAddress(),
                'from_city' => $truck->getFromCity(),
                'loading_date' => $truck->getLoadingDate(),
                'operator' => $_SESSION['operator'],
                'order_type' => $truck->getOrderType(),
                'originator' => $truck->getOriginator(),
                'plate_number' => $truck->getPlateNumber(),
                'recipient' => $truck->getRecipient(),
                'status' => $truck->getStatus(),
                'to_address' => $truck->getToAddress(),
                'to_city' => $truck->getToCity(),
                'unloading_date' => $truck->getUnloadingDate(),
                'availability' => $truck->getAvailability(),
                'cargo_type' => $truck->getCargoType(),
                'truck_type' => $truck->getTruckType(),
                'contract_type' => $truck->getContractType()
            ), "id=%d", $truck->getId() );
        }
        catch (MeekroDBException $mdbe) {
            error_log("Database error: ".$mdbe->getMessage());
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';

            return false;
        }
        catch (Exception $e) {
            error_log("Database error: ".$e->getMessage());
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

            return false;
        }

        return true;
    }

    public static function selectUser(string $username): ?User
    {
        try {
            $row = DB::getMDB()->queryOneRow("select * 
                                                  from 
                                                     cargo_users 
                                                  where 
                                                     username=%s", $username);
            if (is_null($row)) {
                error_log("No cargo_users was found for username=".$username);

                return null;
            }

            $user = new User();
            $user->setId($row['id']);
            $user->setUsername($username);
            $user->setPassword($row['password']);
            $user->setName($row['name']);
            $user->setClass($row['class']);
            $user->setCountryId($row['country_id']);
            $user->setInsert($row['insert']);
            $user->setReports($row['reports']);

            return $user;
        }
        catch (MeekroDBException $mdbe) {
            error_log("Database error: ".$mdbe->getMessage());
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';

            return null;
        }
        catch (Exception $e) {
            error_log("Database error: ".$e->getMessage());
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

            return null;
        }
    }

    public static function selectUserById(int $id): ?User
    {
        try {
            $row = DB::getMDB()->queryOneRow("select * 
                                                  from 
                                                     cargo_users 
                                                  where 
                                                     id=%s", $id);
            if (is_null($row)) {
                error_log("No cargo_users was found for id=".$id);

                return null;
            }

            $user = new User();
            $user->setId($row['id']);
            $user->setUsername($row['username']);
            $user->setPassword($row['password']);
            $user->setName($row['name']);
            $user->setClass($row['class']);
            $user->setCountryId($row['country_id']);
            $user->setInsert($row['insert']);
            $user->setReports($row['reports']);

            return $user;
        }
        catch (MeekroDBException $mdbe) {
            error_log("Database error: ".$mdbe->getMessage());
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';

            return null;
        }
        catch (Exception $e) {
            error_log("Database error: ".$e->getMessage());
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

            return null;
        }
    }
}
