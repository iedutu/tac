<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/GPBMetadata/Types.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/Request.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/Truck.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/TruckStop.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/User.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/TruckMatch.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/Notification.php";

use Rohel\CargoNote;
use Rohel\Notification;
use Rohel\TruckMatch;
use Rohel\Request;
use Rohel\Truck;
use Rohel\TruckStop;
use Rohel\User;

include $_SERVER['DOCUMENT_ROOT'] . "/lib/db-settings.php";
include $_SERVER['DOCUMENT_ROOT'] . "/lib/site-settings.php";


class DB_utils
{
    // Private functions
    static function row2user($row): User
    {
        $user = new User();
        $user->setId($row['id']);
        $user->setUsername($row['username']);
        $user->setPassword($row['password']);
        $user->setName($row['name']);
        $user->setClass($row['class']);
        $user->setCountryName($row['country_name']);
        $user->setCountryId($row['country_id']);
        $user->setInsert($row['insert']);
        $user->setReports($row['reports']);
        $user->setOffice($row['office_name']);

        return $user;
    }

    static function row2request($row): Request
    {
        $request = new Request();

        if(!empty($row['SYS_CREATION_DATE'])) $request->setCreationDate(strtotime($row['SYS_CREATION_DATE']));
        if(!empty($row['SYS_UPDATE_DATE'])) $request->setUpdateDate(strtotime($row['SYS_UPDATE_DATE']));
        if(!empty($row['acceptance'])) $request->setAcceptance(strtotime($row['acceptance']));
        if(!empty($row['accepted_by'])) $request->setAcceptedBy($row['accepted_by']);
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
        $request->setDimensions($row['dimensions']);
        $request->setPackage($row['package']);
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

    static function row2truck($row): Truck
    {
        $truck = new Truck();

        if(!empty($row['SYS_CREATION_DATE'])) $truck->setCreationDate(strtotime($row['SYS_CREATION_DATE']));
        if(!empty($row['SYS_UPDATE_DATE'])) $truck->setUpdateDate(strtotime($row['SYS_UPDATE_DATE']));
        if(!empty($row['acceptance'])) $truck->setAcceptance(strtotime($row['acceptance']));
        if(!empty($row['accepted_by'])) $truck->setAcceptedBy($row['accepted_by']);

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
        $truck->setId($row['id']);
        if(!empty($row['loading_date'])) $truck->setLoadingDate(strtotime($row['loading_date']));
        $truck->setOperator($row['operator']);
        $truck->setStatusChangedBy($row['status_changed_by']);
        $truck->setOriginator($row['originator_id']);
        $truck->setPlateNumber($row['plate_number']);
        $truck->setStatus($row['status']);
        $truck->setRecipient($row['recipient_id']);
        $truck->setTruckType($row['truck_type']);
        if(!empty($row['unloading_date'])) $truck->setUnloadingDate(strtotime($row['unloading_date']));

        return $truck;
    }

    static function row2stop($row): TruckStop
    {
        $stop = new TruckStop();

        if(!empty($row['SYS_CREATION_DATE'])) $stop->setCreationDate(strtotime($row['SYS_CREATION_DATE']));
        if(!empty($row['SYS_UPDATE_DATE'])) $stop->setUpdateDate(strtotime($row['SYS_UPDATE_DATE']));
        $stop->setId($row['id']);
        $stop->setOperator($row['operator']);
        $stop->setLoadingMeters($row['loading_meters']);
        $stop->setVolume($row['volume']);
        $stop->setWeight($row['weight']);
        $stop->setTruckId($row['truck_id']);
        $stop->setStopId($row['stop_id']);
        $stop->setAddress($row['address']);
        if(!empty($row['cmr'])) $stop->setCmr($row['cmr']);
        $stop->setCity($row['city']);

        return $stop;
    }

    static function row2notification($row): Notification
    {
        $notification = new Notification();

        $notification->setId($row['id']);
        $notification->setKind($row['notification_kind']);
        $notification->setEntityKind($row['entity_kind']);
        $notification->setEntityId($row['entity_id']);
        $notification->setUserId($row['user_id']);
        $notification->setOriginatorId($row['originator_id']);
        $notification->setViewed($row['viewed']);

        return $notification;
    }

    // Public functions
    /**
     * @throws ApplicationException
     */
    public static function changeUserPassword(string $username, string $password): bool
    {
        try {
            DB::getMDB()->update('cargo_users', array(
                'password' => $password,
                'reset_key' => null
            ), "(username=%s) and (NOW() < (DATE_ADD(SYS_UPDATE_DATE, INTERVAL 2 HOUR)))", $username);
            $result = (DB::getMDB()->affectedRows() == 1);
            DB::getMDB()->commit();

            return $result;
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            throw new ApplicationException($mdbe->getMessage());
        }
    }

    /**
     * @throws ApplicationException
     */
    public static function addResetKey(string $username, string $reset_key): bool
    {
        try {
            DB::getMDB()->update('cargo_users', array(
                'reset_key' => $reset_key
            ), "username=%s", $username);
            DB::getMDB()->commit();

            return true;
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            throw new ApplicationException($mdbe->getMessage());
        }
    }

    public static function selectOffices(): bool
    {
        try {
            $offices = DB::getMDB()->query('select * from cargo_offices order by importance');
            foreach ($offices as $office) {
                echo '<option value="'.$office['name'].'">'.$office['name'].'</option>';
            }
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            return false;
        }
        catch (Exception $e) {
            Utils::handleException($e);
            return false;
        }

        return true;
    }

    public static function selectActiveUsers(): bool
    {
        try {
            $users = DB::getMDB()->query ( "SELECT
                                               a.id as 'id', a.name as 'name'
                                            FROM 
                                               cargo_users a,
                                               cargo_offices b,
                                               cargo_countries c  
                                            WHERE
                                               (a.office_id = b.id) and
                                               (b.country = c.id) and
                                               (a.id<>%d) and
                                               (a.class<2)
                                            ORDER BY a.name", $_SESSION['operator']['id']);
            foreach ($users as $user) {
                echo '<option value="'.$user['id'].'">'.$user['name'].'</option>';
            }
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            return false;
        }
        catch (Exception $e) {
            Utils::handleException($e);
            return false;
        }

        return true;
    }

    public static function countryMatch(int $other): bool
    {
        try {
            $country = DB::getMDB()->queryOneField('country_id', 'SELECT 
                                                                    b.country as "country_id"
                                                                  FROM 
                                                                    cargo_users a,
                                                                    cargo_offices b
                                                                  WHERE 
                                                                    (a.office_id = b.id) and
                                                                    a.id = %d', $other);
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            return false;
        }
        catch (Exception $e) {
            Utils::handleException($e);
            return false;
        }

        return $country == $_SESSION['operator']['country-id'];
    }

    public static function isEditable(int $originator, int $recipient): array
    {
        // Who can edit the cargo
        // 1. The one who created it
        if (($_SESSION['operator']['id'] == $originator) || self::countryMatch($originator)){
            $result['originator'] = true;
        }
        else {
            $result['originator'] = false;
        }

        $result['recipient'] = self::countryMatch($recipient);
        return $result;
    }

    public static function selectRequest(int $id): ?Request
    {
        try {
            $row = DB::getMDB()->queryOneRow("select * from cargo_request where id=%d", $id);

            if (empty($row)) {
                return null;
            }

            return self::row2request($row);

        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';

            return null;
        }
        catch (Exception $e) {
            Utils::handleException($e);
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

            return null;
        }
    }

    /**
     * @throws ApplicationException
     */
    public static function insertRequest(Request $entry): int
    {
        try {
            DB::getMDB()->insert('cargo_request', array(
                'originator_id' => $_SESSION['operator']['id'],
                'status_changed_by' => $_SESSION['operator']['id'],
                'operator' => $_SESSION['operator']['username'],
                'SYS_CREATION_DATE' => date('Y-m-d H:i:s'),
                'status' => $entry->getStatus(),
                'client' => $entry->getClient(),
                'recipient_id' => $entry->getRecipient(),
                'from_city' => $entry->getFromCity(),
                'to_city' => $entry->getToCity(),
                'from_address' => $entry->getFromAddress(),
                'to_address' => $entry->getToAddress(),
                'expiration' => DB::getMDB()->sqleval("from_unixtime(%d)",$entry->getExpiration()),
                'loading_date' => DB::getMDB()->sqleval("from_unixtime(%d)",$entry->getLoadingDate()),
                'unloading_date' => DB::getMDB()->sqleval("from_unixtime(%d)",$entry->getUnloadingDate()),
                'description' => $entry->getDescription(),
                'collies' => $entry->getCollies(),
                'weight' => $entry->getWeight(),
                'volume' => $entry->getVolume(),
                'loading_meters' => $entry->getLoadingMeters(),
                'dimensions' => $entry->getDimensions(),
                'package' => $entry->getPackage(),
                'instructions' => $entry->getInstructions(),
                'freight' => $entry->getFreight(),
                'order_type' => $entry->getOrderType(),
                'adr' => (empty($entry->getAdr())?null:$entry->getAdr())
            ));

            return DB::getMDB()->insertId();
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            throw new ApplicationException($mdbe->getMessage());
        }
    }

    public static function updateRequest(Request $request): bool
    {
        try {
            $result = DB::getMDB()->update ( 'cargo_request', array (
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
                'dimensions' => $request->getDimensions(),
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

            DB::getMDB()->commit();

            return $result;
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';

            return false;
        }
        catch (Exception $e) {
            Utils::handleException($e);
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

            return false;
        }
    }

    public static function selectTruck(int $id): ?Truck
    {
        try {
            $row = DB::getMDB()->queryOneRow("select * 
                                                  from 
                                                     cargo_truck 
                                                  where 
                                                     id=%d", $id);
            if (empty($row)) {
                return null;
            }

            $truck = self::row2truck($row);

            // Add the truck stops
            $results = DB::getMDB()->query("select * 
                                                  from 
                                                     cargo_truck_stops 
                                                  where 
                                                     truck_id=%d
                                                  order by stop_id", $id);
            if (empty($results)) {
                AppLogger::getLogger()->error('No cargo_truck_stops was found for truck_id='.$id.' in selectTruck(). At least one is required.');

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
                if(!empty($row['SYS_CREATION_DATE'])) $stop->setCreationDate(strtotime($row['SYS_CREATION_DATE']));
                if(!empty($row['SYS_UPDATE_DATE'])) $stop->setUpdateDate(strtotime($row['SYS_UPDATE_DATE']));

                $stops[$i] = $stop;
                $i++;
            }
            $truck->setStop($stops);

            return $truck;
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            return null;
        }
        catch (Exception $e) {
            Utils::handleException($e);
            return null;
        }
    }

    /**
     * @throws ApplicationException
     */
    public static function insertTruck(Truck $entry): int
    {
        try {
            DB::getMDB()->insert('cargo_truck', array(
                'originator_id' => $_SESSION['operator']['id'],
                'status_changed_by' => $_SESSION['operator']['id'],
                'operator' => $_SESSION['operator']['username'],
                'SYS_CREATION_DATE' => date('Y-m-d H:i:s'),
                'status' => $entry->getStatus(),
                'recipient_id' => $entry->getRecipient(),
                'from_city' => $entry->getFromCity(),
                'from_address' => $entry->getFromAddress(),
                'expiration' => DB::getMDB()->sqleval("from_unixtime(%d)",$entry->getExpiration()),
                'loading_date' => DB::getMDB()->sqleval("from_unixtime(%d)",$entry->getLoadingDate()),
                'unloading_date' => DB::getMDB()->sqleval("from_unixtime(%d)",$entry->getUnloadingDate()),
                'freight' => $entry->getFreight(),
                'contract_type' => $entry->getContractType(),
                'details' => $entry->getDetails(),
                'plate_number' => $entry->getPlateNumber(),
                'ameta' => $entry->getAmeta(),
                'adr' => (empty($entry->getAdr())?null:$entry->getAdr())
            ));

            return DB::getMDB()->insertId();
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            throw new ApplicationException($mdbe->getMessage());
        }
    }

    /**
     * @throws ApplicationException
     */
    public static function insertTruckStop(TruckStop $entry): int
    {
        try {
            $stops_count = DB::getMDB()->queryFirstField("SELECT
                                        count(1)
                                     FROM 
                                        cargo_truck_stops
                                     WHERE
                                        truck_id=%d", $entry->getTruckId());
            if($entry->getStopId() > $stops_count) {
                $entry->setStopId($stops_count);
            }

            DB::getMDB()->insert('cargo_truck_stops', array(
                'operator' => $_SESSION['operator']['username'],
                'SYS_CREATION_DATE' => date('Y-m-d H:i:s'),
                'truck_id' => $entry->getTruckId(),
                'stop_id' => $entry->getStopId(),
                'city' => $entry->getCity(),
                'cmr' => $entry->getCmr(),
                'address' => $entry->getAddress(),
                'loading_meters' => $entry->getLoadingMeters(),
                'weight' => $entry->getWeight(),
                'volume' => $entry->getVolume()
            ));

            $id = DB::getMDB()->insertId();
            DB::getMDB()->query('UPDATE cargo_truck_stops SET stop_id=stop_id+1 WHERE ((truck_id=%d) AND (stop_id>=%d) AND (id<>%d))', $entry->getTruckId(), $entry->getStopId(), $id);
            DB::getMDB()->commit();

            return $id;
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            throw new ApplicationException($mdbe->getMessage());
        }
    }

    /**
     * @throws ApplicationException
     */
    public static function insertCargoNote(CargoNote $entry): int
    {
        try {
            DB::getMDB()->insert('cargo_comments', array(
                'operator_id' => $_SESSION['operator']['id'],
                'SYS_CREATION_DATE' => date('Y-m-d H:i:s'),
                'comment' => $entry->getNote(),
                'cargo_id' => $entry->getCargoId()
            ));
            DB::getMDB()->commit();

            return DB::getMDB()->insertId();
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            throw new ApplicationException($mdbe->getMessage());
        }
    }

    /**
     * @throws ApplicationException
     */
    public static function cancelCargo(int $id): bool
    {
        try {
            DB::getMDB()->update('cargo_request', array(
                'status_changed_by' => $_SESSION['operator']['id'],
                'status' => AppStatuses::$CARGO_CANCELLED
            ), "id=%d", $id);
            DB::getMDB()->commit();

            return true;
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            throw new ApplicationException($mdbe->getMessage());
        }
    }

    /**
     * @throws ApplicationException
     */
    public static function acknowledgeCargo(Request $cargo, string $field, ?string $value): bool
    {
        AppLogger::getLogger()->info('Cargo to be acknowledged: '.$cargo->serializeToJsonString());
        AppLogger::getLogger()->info('Fields to change: id=('.$field.'), value=('.$value.')');

        try {
            if(empty($value)) {
                DB::getMDB()->update('cargo_request', array(
                    'acceptance' => date("Y-m-d H:i:s"),
                    'accepted_by' => $cargo->getAcceptedBy(),
                    'status_changed_by' => $cargo->getAcceptedBy(),
                    'status' => AppStatuses::$CARGO_ACCEPTED
                ), "id=%d", $cargo->getId());
            }
            else {
                DB::getMDB()->update('cargo_request', array(
                    'acceptance' => date("Y-m-d H:i:s"),
                    'accepted_by' => $cargo->getAcceptedBy(),
                    'status_changed_by' => $cargo->getAcceptedBy(),
                    $field => $value,
                    'status' => AppStatuses::$CARGO_ACCEPTED
                ), "id=%d", $cargo->getId());
            }
            DB::getMDB()->commit();

            return true;
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            throw new ApplicationException($mdbe->getMessage());
        }
    }

    /**
     * @throws ApplicationException
     */
    public static function deleteTruckStops(Truck $truck, $post): bool
    {
        try {
            // Retrieve the list of stops for our truck
            $stops_count = DB::getMDB()->queryFirstField("SELECT
                                        count(1)
                                     FROM 
                                        cargo_truck_stops
                                     WHERE
                                        truck_id=%d", $truck->getId());

            // Remove the stops from the database
            // TODO: Shall I mark them as CANCELLED instead?
            // See if the user selected all
            $deleted_stops = 0;
            if($stops_count > sizeof($post)) {
                for ($i = 0; $i < sizeof($post); $i++) {
                    DB::getMDB()->delete('cargo_truck_stops', 'id=%d', $post[$i]);
                    $deleted_stops++;
                }
            }
            else {
                for ($i = 0; $i < sizeof($post) - 1; $i++) {
                    DB::getMDB()->delete('cargo_truck_stops', 'id=%d', $post[$i]);
                    $deleted_stops++;
                }
            }

            // Redo the stop_id numbers on the remaining records
            DB::getMDB()->get()->multi_query('SET @num := -1; UPDATE cargo_truck_stops SET stop_id = @num := (@num+1) WHERE truck_id='.$truck->getId().' ORDER BY stop_id');
            while (DB::getMDB()->get()->next_result()) {;}  // Required to fix the sync error: https://stackoverflow.com/questions/27899598/mysqli-multi-query-commands-out-of-sync-you-cant-run-this-command-now
            DB::getMDB()->commit();

            return true;
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            throw new ApplicationException($mdbe->getMessage());
        }
    }

    /**
     * @throws ApplicationException
     */
    public static function updateTruckStatus(Truck $truck, int $status): bool
    {
        try {
            DB::getMDB()->update ( 'cargo_truck', array (
                'status_changed_by' => $_SESSION['operator']['id'],
                'status' => $status
            ), "id=%d", $truck->getId());
            DB::getMDB()->commit();

            return true;
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            throw new ApplicationException($mdbe->getMessage());
        }
    }

    /**
     * @throws ApplicationException
     */
    public static function updateGenericField(string $key, string $value, int $id): ?string
    {
        try {
            switch ($_SESSION['app']) {
                case 'cargoInfo':
                {
                    $table = 'cargo_request';
                    break;
                }
                case 'truckInfo':
                {
                    $table = 'cargo_truck';
                    break;
                }
                default:
                {
                    AppLogger::getLogger()->error('In-place editing failed. Requested to change a filed without being notified of which page we are on.');
                    return null;
                }
            }

            self::beforeUpdateGenericField($table, $key, $value, $id);
            switch ($_POST['id']) {
                case 'acceptance':
                case 'availability':
                case 'expiration':
                case 'loading_date':
                case 'unloading_date':
                {
                    DB::getMDB()->update($table, array(
                        $key => DB::getMDB()->sqleval("str_to_date(%s, %s)", $value, Utils::$SQL_DATE_FORMAT),
                        'operator' => $_SESSION['operator']['username'],
                    ), "id=%d", $id);
                    DB::getMDB()->commit();

                    break;
                }
                default:
                {
                    DB::getMDB()->update($table, array(
                        $key => $value,
                        'operator' => $_SESSION['operator']['username'],
                    ), "id=%d", $id);
                    DB::getMDB()->commit();

                    break;
                }
            }
            self::afterUpdateGenericField($table, $key, $value, $id);
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            throw new ApplicationException($mdbe->getMessage());
        }

        return $table;
    }

    /**
     * @throws ApplicationException
     */
    public static function updateRecipient(string $value, int $entity_id): ?string
    {
        try {
            switch ($_SESSION['app']) {
                case 'cargoInfo':
                {
                    $table = 'cargo_request';
                    break;
                }
                case 'truckInfo':
                {
                    $table = 'cargo_truck';
                    break;
                }
                default:
                {
                    AppLogger::getLogger()->error('In-place editing failed. Requested to change a filed without being notified of which page we are on.');
                    return null;
                }
            }

            $newRecipient = DB_utils::selectUser($value);

            DB::getMDB()->update($table, array(
                'recipient_id' => $newRecipient->getId(),
                'operator' => $_SESSION['operator']['username'],
            ), "id=%d", $entity_id);
            DB::getMDB()->commit();

            $_SESSION['recipient-id'] = $newRecipient->getId();
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            throw new ApplicationException($mdbe->getMessage());
        }

        return $table;
    }

    /**
     * @throws ApplicationException
     */
    public static function insertMatch(TruckMatch $match): bool
    {
        try {
            DB::getMDB()->insert('cargo_match', array(
                'operator' => $match->getOperator(),
                'SYS_CREATION_DATE' => date('Y-m-d H:i:s'),
                'status' => $match->getStatus(),
                'details' => $match->getDetails(),
                'originator_id' => $match->getOriginatorId(),
                'recipient_id' => $match->getRecipientId(),
                'from_city' => $match->getFromCity(),
                'to_city' => $match->getToCity(),
                'availability' => (empty($match->getAvailability()) ? null : DB::getMDB()->sqleval("FROM_UNIXTIME(%d)",$match->getAvailability())),
                'order_type' => $match->getOrderType(),
                'adr' => $match->getAdr(),
                'ameta' => $match->getAmeta(),
                'item_kind' => $match->getItemKind(),
                'item_id' => $match->getItemId(),
                'item_date' => (empty($match->getItemDate()) ? null : DB::getMDB()->sqleval("FROM_UNIXTIME(%d)",$match->getItemDate())),
                'loading_meters' => $match->getLoadingMeters(),
                'volume' => $match->getVolume(),
                'weight' => $match->getWeight(),
                'plate_number' => $match->getPlateNumber()
            ));

            DB::getMDB()->commit();
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            throw new ApplicationException($mdbe);
        }

        return true;
    }

    public static function updateTruck(Truck $truck): bool
    {
        try {
            $result = DB::getMDB()->update ( 'cargo_truck', array (
                'acceptance' => $truck->getAcceptance(),
                'accepted_by' => $truck->getAcceptedBy(),
                'adr' => $truck->getAdr(),
                'ameta' => $truck->getAmeta(),
                'expiration' => $truck->getExpiration(),
                'freight' => $truck->getFreight(),
                'from_address' => $truck->getFromAddress(),
                'from_city' => $truck->getFromCity(),
                'loading_date' => $truck->getLoadingDate(),
                'operator' => $_SESSION['operator']['username'],
                'originator' => $truck->getOriginator(),
                'plate_number' => $truck->getPlateNumber(),
                'recipient' => $truck->getRecipient(),
                'status' => $truck->getStatus(),
                'unloading_date' => $truck->getUnloadingDate(),
                'availability' => $truck->getAvailability(),
                'cargo_type' => $truck->getCargoType(),
                'truck_type' => $truck->getTruckType(),
                'contract_type' => $truck->getContractType()
            ), "id=%d", $truck->getId() );

            DB::getMDB()->commit();

            return $result;
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';

            return false;
        }
        catch (Exception $e) {
            Utils::handleException($e);
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

            return false;
        }
    }

    /**
     * @throws ApplicationException
     */
    public static function selectUser(string $username): ?User
    {
        try {
            $row = DB::getMDB()->queryOneRow("select a.*, b.name as 'office_name', c.name as 'country_name', c.id as 'country_id' 
                                                  from 
                                                     cargo_users a,
                                                     cargo_offices b,
                                                     cargo_countries c  
                                                  where
                                                     (a.office_id = b.id)
                                                     and
                                                     (b.country = c.id)
                                                     and
                                                     (a.username=%s)", $username);
            if (empty($row)) {
                AppLogger::getLogger()->error("No cargo_users was found for username=".$username);

                return null;
            }

            return self::row2user($row);
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';
            throw new ApplicationException($mdbe);
        }
    }

    /**
     * @throws ApplicationException
     */
    public static function selectUsernames(int $me)
    {
        try {
            // Different countries only
            /*
            return DB::getMDB()->query ( "SELECT
                                                a.id as 'id', a.username as 'username'
                                             FROM
                                                cargo_users a,
                                                cargo_offices b,
                                                cargo_countries c
                                             WHERE
                                                (a.office_id = b.id) and
                                                (b.country = c.id) and
                                                (a.id<>%d) and
                                                (c.id<>%d) and
                                                (a.class<2)
                                             ORDER BY a.name", $_SESSION['operator']['id'], $_SESSION['operator']['country-id']);
            */

            return DB::getMDB()->query ( "SELECT
                                        id, username
                                     FROM 
                                        cargo_users
                                     WHERE
                                        (id<>%d) and
                                        (class<2)
                                     ORDER BY name", $me);
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            throw new ApplicationException($mdbe);
        }
    }

    public static function selectUserById(int $id): ?User
    {
        try {
            $row = DB::getMDB()->queryOneRow("select a.*, b.name as 'office_name', c.name as 'country_name', c.id as 'country_id' 
                                                  from 
                                                     cargo_users a,
                                                     cargo_offices b,
                                                     cargo_countries c  
                                                  where
                                                     (a.office_id = b.id)
                                                     and
                                                     (b.country = c.id)
                                                     and
                                                     (a.id=%d)", $id);
            if (empty($row)) {
                AppLogger::getLogger()->error("No cargo_users was found for id=".$id);

                return null;
            }

            return self::row2user($row);
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';

            return null;
        }
        catch (Exception $e) {
            Utils::handleException($e);
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

            return null;
        }
    }

    public static function selectUserByResetKey(string $reset_key): ?User
    {
        try {
            $row = DB::getMDB()->queryOneRow("select a.*, b.name as 'office_name', c.name as 'country_name', c.id as 'country_id' 
                                                  from 
                                                     cargo_users a,
                                                     cargo_offices b,
                                                     cargo_countries c  
                                                  where
                                                     (a.office_id = b.id)
                                                     and
                                                     (b.country = c.id)
                                                     and
                                                     (a.reset_key=%s)", $reset_key);
            if (empty($row)) {
                AppLogger::getLogger()->error("No cargo_users was found for reset_key=".$reset_key);

                return null;
            }

            return self::row2user($row);
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';

            return null;
        }
        catch (Exception $e) {
            Utils::handleException($e);
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

            return null;
        }
    }

    public static function readValue(string $key): ?string
    {
        try {
            return DB::getMDB()->queryFirstField("select value from cargo_settings where `key`=%s", $key);
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            return null;
        }
        catch (Exception $e) {
            Utils::handleException($e);
            return null;
        }
    }

    /**
     * @throws ApplicationException
     */
    public static function writeValue(string $key, string $value): ?bool
    {
        try {
            return DB::getMDB()->update ( 'cargo_settings', array (
                'value' => $value
            ), "`key`=%s", $key );
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            throw new ApplicationException($mdbe->getMessage());
        }
    }

    /**
     * @throws ApplicationException
     */
    public static function selectNotification(int $id): ?Notification
    {
        try {
            $row = DB::getMDB()->queryOneRow("select * from cargo_notifications where id=%d", $id);
            if (empty($row)) {
 //             AppLogger::getLogger()->error("No cargo_notification was found for id=".$id);

                return null;
            }

            return self::row2notification($row);
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';
            throw new ApplicationException($mdbe);
        }
    }

    /**
     * @throws ApplicationException
     */
    public static function clearNotifications(int $user_id, int $entity_kind, int $entity_id): ?bool
    {
        try {

            $result = DB::getMDB()->update ( 'cargo_notifications', array (
                'viewed' => 1
            ), "(user_id=%d) and (entity_kind=%d) and (entity_id=%d) and (viewed=0)",  $user_id, $entity_kind, $entity_id);

            if(self::notificationsCount() == 0) {
                $_SESSION['operator']['notification-count'] = 0;
            }

            return $result;
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            throw new ApplicationException($mdbe);
        }
    }

    public static function handleNotifications(): bool
    {
        try {
            $rows = DB::getMDB()->query('SELECT 
                                            a.*, b.name 
                                         FROM 
                                            cargo_notifications a, cargo_users b 
                                         WHERE
                                            (a.originator_id = b.id)
                                            and
                                            (a.user_id=%d) 
                                            and
                                            (a.viewed=0)
                                         ORDER BY SYS_CREATION_DATE', $_SESSION['operator']['id']);
            if(!empty($rows)) {
                echo '
        <!--begin::Separator-->
        <div class="separator separator-dashed my-7"></div>
        <!--end::Separator-->

        <!--begin::Notifications-->
        <div class="pt-5">
            <!--begin:Heading-->
            <h5 class="mb-7">Recent Notifications</h5>
            <!--end:Heading-->
                ';

                foreach ($rows as $row) {
                    $notification = new Notification();

                    $notification->setId($row['id']);
                    $notification->setFrom($row['name']);
                    $notification->setEntityId($row['entity_id']);
                    $notification->setEntityKind($row['entity_kind']);
                    $notification->setKind($row['notification_kind']);

                    $title = '';
                    $label = '';
                    $text = '';
                    $url = '';
                    $empty = false;

                    switch ($notification->getKind()) {
                        case 1:
                        { // New item
                            $label = 'btn-light-primary';
                            switch ($notification->getEntityKind()) {
                                case 1:
                                { // Cargo
                                    $title = 'New cargo request';
                                    $text = 'A new cargo request was added by ' . $notification->getFrom();
                                    $url = '/?source=notifications&page=cargoInfo&id=' . $notification->getEntityId();

                                    break;
                                }
                                case 2:
                                { // Truck
                                    $title = 'New available truck';
                                    $text = 'A new available truck was added by ' . $notification->getFrom();
                                    $url = '/?source=notifications&page=truckInfo&id=' . $notification->getEntityId();

                                    break;
                                }
                                case 3:
                                { // Truck stop
                                    $title = 'New truck stop added';
                                    $text = 'A new truck stop was added for an existing truck by ' . $notification->getFrom();
                                    $url = '/?source=notifications&page=truckInfo&id=' . $notification->getEntityId();

                                    break;
                                }
                                case 4:
                                { // Cargo comment
                                    $title = 'New cargo comment added';
                                    $text = 'A new comment was added for an existing cargo by ' . $notification->getFrom();
                                    $url = '/?source=notifications&page=cargoInfo&id=' . $notification->getEntityId();

                                    break;
                                }
                                default:
                                { // Cargo notification
                                    return false;
                                }
                            }

                            break;
                        }
                        case 2:
                        { // Changed item
                            $label = 'btn-light-warning';
                            switch ($notification->getEntityKind()) {
                                case 1:
                                { // Cargo
                                    $title = 'Changed cargo';
                                    $text = 'An existing cargo request was modified by  ' . $notification->getFrom();
                                    $url = '/?source=notifications&page=cargoInfo&id=' . $notification->getEntityId();

                                    break;
                                }
                                case 2:
                                { // Truck
                                    $title = 'Changed available truck';
                                    $text = 'An existing available truck was modified by  ' . $notification->getFrom();
                                    $url = '/?source=notifications&page=truckInfo&id=' . $notification->getEntityId();

                                    break;
                                }
                                default:
                                { // Truck stop
                                    $empty = true;
                                }
                            }

                            break;
                        }
                        case 3:
                        { // Approved item
                            $label = 'btn-light-success';
                            switch ($notification->getEntityKind()) {
                                case 1:
                                { // Cargo
                                    $title = 'Approved cargo';
                                    $text = 'Your cargo request was approved by  ' . $notification->getFrom();
                                    $url = '/?source=notifications&page=cargoInfo&id=' . $notification->getEntityId();

                                    break;
                                }
                                default:
                                { // Cargo notification
                                    $empty = true;
                                }
                            }

                            break;
                        }
                        case 4:
                        { // Removed item
                            $label = 'btn-light-danger';
                            switch ($notification->getEntityKind()) {
                                case 1:
                                { // Cargo
                                    $title = 'Cancelled cargo request';
                                    $text = 'A cargo request was removed by ' . $notification->getFrom();
                                    $url = '/?source=notifications&page=cargoInfo&id='.$notification->getEntityId();

                                    break;
                                }
                                case 2:
                                { // Truck
                                    $title = 'Cancelled truck';
                                    $text = 'A truck entry was removed by ' . $notification->getFrom();
                                    $url = '/?source=notifications&page=truckInfo&id='.$notification->getEntityId();

                                    break;
                                }
                                case 3:
                                { // Truck stop
                                    $title = 'Removed truck stop';
                                    $text = 'A scheduled stop for an existing truck was removed by ' . $notification->getFrom();
                                    $url = '/?source=notifications&page=truckInfo&id=' . $notification->getEntityId();

                                    break;
                                }
                                default:
                                { // Cargo notification
                                    $empty = true;
                                }
                            }

                            break;
                        }
                        default:
                        {
                            return false;
                        }
                    }

                    if (!$empty) echo '
            <!--begin::Item-->
            <div class="bg-gray-100 d-flex align-items-center p-5 rounded gutter-b">
                <!--begin::Icon-->
                <div class="d-flex flex-center position-relative ml-4 mr-6 ml-lg-6 mr-lg-10">
					<span class="svg-icon svg-icon-4x svg-icon-primary position-absolute opacity-15">
						<!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-polygon.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" width="70px" height="70px" viewBox="0 0 70 70" fill="none">
							<g stroke="none" stroke-width="1" fill-rule="evenodd">
							<path d="M28 4.04145C32.3316 1.54059 37.6684 1.54059 42 4.04145L58.3109 13.4585C62.6425 15.9594 65.3109 20.5812 65.3109 25.5829V44.4171C65.3109 49.4188 62.6425 54.0406 58.3109 56.5415L42 65.9585C37.6684 68.4594 32.3316 68.4594 28 65.9585L11.6891 56.5415C7.3575 54.0406 4.68911 49.4188 4.68911 44.4171V25.5829C4.68911 20.5812 7.3575 15.9594 11.6891 13.4585L28 4.04145Z" fill="#000000" />									</g>
						</svg>
                        <!--end::Svg Icon-->
					</span>
                    <span class="svg-icon svg-icon-lg svg-icon-primary position-absolute">
						<!--begin::Svg Icon | path:assets/media/svg/icons/Files/File-done.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
    								<path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z M10.875,15.75 C11.1145833,15.75 11.3541667,15.6541667 11.5458333,15.4625 L15.3791667,11.6291667 C15.7625,11.2458333 15.7625,10.6708333 15.3791667,10.2875 C14.9958333,9.90416667 14.4208333,9.90416667 14.0375,10.2875 L10.875,13.45 L9.62916667,12.2041667 C9.29375,11.8208333 8.67083333,11.8208333 8.2875,12.2041667 C7.90416667,12.5875 7.90416667,13.1625 8.2875,13.5458333 L10.2041667,15.4625 C10.3958333,15.6541667 10.6354167,15.75 10.875,15.75 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
									<path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#000000" />
							</g>
						</svg>
                        <!--end::Svg Icon-->
					</span>
                </div>
                <!--end::Icon-->

                <!--begin::Description-->
                <div class="ml-1">
           			<a href="' . $url . '" class="btn btn-sm ' . $label . ' font-weight-bolder py-1 px-3">' . $title . '</a>
                    <p class="m-0 text-dark-50 font-weight-bold">' . $text . '</p>
                </div>
                <!--end::Description-->
            </div>
            <!--end::Item-->
				';
                }

                echo '
        </div>
        <!--end::Notifications-->
                ';
            }
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';

            return false;
        }
        catch (Exception $e) {
            Utils::handleException($e);
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

            return false;
        }

        return true;
    }

    public static function notificationMessage(): ?string
    {
        try {
            if(empty($_SESSION['operator']['notification-count'])) {
                $count = self::notificationsCount();
            }
            else {
                $count = $_SESSION['operator']['notification-count'];
            }

            if($count == 0) {
                return '<small class="d-block pt-2 font-size-sm" style="color: darkgreen">No new notifications!</small>';
            }
            else {
                return '<small class="d-block pt-2 font-size-sm" style="color: red">'.$count.' messages</small>';
            }
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';

            return null;
        }
        catch (Exception $e) {
            Utils::handleException($e);
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'Database error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

            return null;
        }
    }

    public static function notificationsCount(): int
    {
        try {
            $row = DB::getMDB()->queryFirstField('SELECT 
                                            count(1) 
                                         FROM 
                                            cargo_notifications 
                                         WHERE
                                            (user_id=%d) 
                                            and
                                            (viewed=0)
                                         ORDER BY SYS_CREATION_DATE', $_SESSION['operator']['id']);

            if(empty($row)) {
                return 0;
            }
            else {
                return intval($row);
            }
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);

            return 0;
        }
        catch (Exception $e) {
            Utils::handleException($e);

            return 0;
        }
    }

    /**
     * @throws ApplicationException
     */
    public static function addNotification(Notification $note): int
    {
        try {
            DB::getMDB()->insert('cargo_notifications', array(
                'operator' => $_SESSION['operator']['username'],
                'SYS_CREATION_DATE' => date('Y-m-d H:i:s'),
                'viewed' => 0,
                'user_id' => $note->getUserId(),
                'originator_id' => $note->getOriginatorId(),
                'notification_kind' => $note->getKind(),
                'entity_kind' => $note->getEntityKind(),
                'entity_id' => $note->getEntityId()
            ));

            DB::getMDB()->commit();

            return DB::getMDB()->insertId();
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            throw new ApplicationException($mdbe->getMessage());
        }
    }

    public static function generateMatches() {
        try {
            if(self::readValue('changes') == '0') {
                return;
            }
            else {
                self::writeValue('changes', '0');
            }

            // Clean-up the table
            DB::getMDB()->query('TRUNCATE cargo_match');

            // Select all NEW and ACCEPTED trucks
            $t_rows = DB::getMDB()->query ('SELECT * FROM cargo_truck WHERE (status < '.AppStatuses::$TRUCK_CANCELLED.') ORDER BY SYS_CREATION_DATE DESC');
            $i = 0;
            foreach($t_rows as $t_row) {
                $truck = self::row2truck($t_row);

                $s_rows = DB::getMDB()->query ('SELECT * FROM cargo_truck_stops WHERE truck_id=%d ORDER BY stop_id', $truck->getId());
                $j = 0;
                foreach($s_rows as $s_row) {
                    $stop = self::row2stop($s_row);

                    // Create the match
                    $match = new TruckMatch();
                    $originator = DB_utils::selectUserById($truck->getOriginator());

                    $match->setWeight($stop->getWeight());
                    $match->setVolume($stop->getVolume());
                    $match->setLoadingMeters($stop->getLoadingMeters());
                    $match->setAdr($truck->getAdr());
                    $match->setDetails($truck->getDetails());
                    $match->setPlateNumber($truck->getPlateNumber());
                    $match->setAmeta($truck->getAmeta());
                    $match->setAvailability($truck->getUnloadingDate());
                    $match->setFromCity($stop->getCity());
                    $match->setToCity($originator->getCountryName());
                    $match->setItemDate($truck->getCreationDate());
                    $match->setItemId($truck->getId());
                    $match->setOrderType('N/A');
                    $match->setItemKind('truckInfo');
                    $match->setOperator($_SESSION['operator']['username']);
                    $match->setOriginatorId($truck->getOriginator());
                    $match->setRecipientId($truck->getRecipient());

                    switch($truck->getStatus()) {
                        case AppStatuses::$TRUCK_AVAILABLE: {
                            $match->setStatus(AppStatuses::$MATCH_AVAILABLE);

                            break;
                        }
                        case AppStatuses::$TRUCK_FREE: {
                            $match->setStatus(AppStatuses::$MATCH_FREE);

                            break;
                        }
                        case AppStatuses::$TRUCK_NEW: {
                            $match->setStatus(AppStatuses::$MATCH_NEW);

                            break;
                        }
                        case AppStatuses::$TRUCK_PARTIALLY_SOLVED: {
                            $match->setStatus(AppStatuses::$MATCH_PARTIAL);

                            break;
                        }
                        case AppStatuses::$TRUCK_FULLY_SOLVED: {
                            $match->setStatus(AppStatuses::$MATCH_SOLVED);

                            break;
                        }
                        case AppStatuses::$TRUCK_CANCELLED: {
                            $match->setStatus(0);

                            break;
                        }
                    }

                    DB_utils::insertMatch($match);
                    unset($match);
                }

                unset($truck);
            }

            // Select all NEW and ACCEPTED cargo
            $c_rows = DB::getMDB()->query ('SELECT * FROM cargo_request WHERE (status = '.AppStatuses::$CARGO_NEW.') OR (status = '.AppStatuses::$CARGO_ACCEPTED.') ORDER BY SYS_CREATION_DATE DESC');
            $i = 0;
            foreach($c_rows as $c_row) {
                $cargo = self::row2request($c_row);

                // Create the match
                $match = new TruckMatch();

                $match->setWeight($cargo->getWeight());
                $match->setVolume($cargo->getVolume());
                $match->setLoadingMeters($cargo->getLoadingMeters());
                $match->setAdr($cargo->getAdr());
                $match->setOrderType($cargo->getOrderType());
                $match->setPlateNumber($cargo->getPlateNumber());
                $match->setAmeta($cargo->getAmeta());
                $match->setAvailability($cargo->getLoadingDate());
                $match->setFromCity($cargo->getFromCity());
                $match->setToCity($cargo->getToCity());
                $match->setItemDate($cargo->getCreationDate());
                $match->setItemId($cargo->getId());
                $match->setOrderType($cargo->getOrderType());
                $match->setItemKind('cargoInfo');
                $match->setOperator($_SESSION['operator']['username']);
                $match->setOriginatorId($cargo->getOriginator());
                $match->setRecipientId($cargo->getRecipient());

                if(empty($cargo->getPlateNumber())) {
                    $match->setStatus(AppStatuses::$MATCH_NEEDED);
                }
                else {
                    $match->setStatus(AppStatuses::$MATCH_SOLVED);
                }

                DB_utils::insertMatch($match);
                unset($match);
                unset($cargo);
            }

            DB::getMDB()->commit();
        }
        catch (MeekroDBException $mdbe) {
            Utils::handleMySQLException($mdbe);
            return null;
        }
        catch (Exception $e) {
            Utils::handleException($e);
            return null;
        }
    }

    /**
     * @throws ApplicationException
     */
    private static function beforeUpdateGenericField(string $table, string $key, string $value, int $entity_id): void
    {
        // use for any changes required before a generic update
    }

    private static function afterUpdateGenericField(string $table, string $key, string $value, int $entity_id)
    {
        // use for any changes required after a generic update
    }

    public static function returnValue(string $table, string $key, string $value, int $entity_id): string
    {
        // ugly hack to fool the SELECT jeditor. Does not work ...
        return $value;
    }
}
