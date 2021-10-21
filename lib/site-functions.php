<?php

use PHPMailer\PHPMailer\PHPMailer;
use Rohel\Request;
use Rohel\RequestUpdates;
use Rohel\Truck;
use Rohel\TruckUpdates;

class Utils
{
    public static bool $DEBUG = true;
    public static int $CARGO_PERIOD = 5;
    public static int $REPORTS_PERIOD = 180;
    public static int $QUERY = 1;
    public static int $INSERT = 5;
    public static int $ADMIN = 6;
    public static string $PHP_DATE_FORMAT = 'd-m-Y';
    public static string $SQL_DATE_FORMAT = '%d-%m-%Y';
    public static int $PASSWORD_LENGTH = 6;
    public static string $BASE_URL = 'http://rohel.iedutu.com/';

    public static int $REPORTS = 11;
    public static int $OPERATIONAL = 12;
    public static string $CANCELLED = 'CANCELLED';
    public static $WEBMASTER_EMAIL = 'webapp@rohel.ro';
    public static $WEBMASTER_NAME = 'Team Rohel';

    public static function clean_up()
    {
        unset($_SESSION['entry-id']);
//      unset($_SESSION['update_done']);
        unset($_SESSION['email-recipient']);
    }

    private static function randomString(int $length, string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): ?string
    {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        if ($max < 1) {
            return null;
        }
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }

        return $str;
    }

    public static function handleMySQLException(MeekroDBException $mdbe)
    {
        error_log("Database error: " . $mdbe->getMessage());
        error_log("Database error query: " . $mdbe->getQuery());
        error_log("Database error code: " . $mdbe->getCode());
    }

    public static function handleException(Exception $e)
    {
        error_log("General error: " . $e->getMessage());
        error_log("Error code: " . $e->getCode());
        error_log("Error trace: " . $e->getTraceAsString());
    }

    public static function handleMailException(\PHPMailer\PHPMailer\Exception $e)
    {
        error_log("Mailing error: " . $e->errorMessage());
        error_log("Error code: " . $e->getCode());
        error_log("Error trace: " . $e->getTraceAsString());
    }

    public static function resetPassword(string $username): bool
    {
        try {
            $recipient = DB_utils::selectUser($username);
            if(empty($recipient)) return false;
            $password = self::randomString(self::$PASSWORD_LENGTH);
            error_log('New password: '.$password);
            error_log('Old password: '.hash('sha256', 'pavel'));

            if (DB_utils::changeUserPassword($username, hash('sha256', $password))) {
                $email['subject'] = 'ROHEL | New application password ';
                $email['title'] = 'ROHEL | E-mail';
                $email['header'] = 'New application password generated';
                $email['body-1'] = 'Hi ' . $recipient->getName() . '!';
                $email['body-2'] = 'Please use the following password for your next visit to our application: <strong>' . $password . '</strong>';
                $email['recipient']['e-mail'] = $recipient->getUsername();
                $email['recipient']['name'] = $recipient->getName();
                $email['originator']['e-mail'] = Utils::$WEBMASTER_EMAIL;
                $email['originator']['name'] = Utils::$WEBMASTER_NAME;
                $email['link']['url'] = self::$BASE_URL;
                $email['link']['text'] = 'Application link';
                $email['bg-color'] = Mails::$BG_ACKNOWLEDGED_COLOR;
                $email['tx-color'] = Mails::$TX_CANCELLED_COLOR;

                Mails::emailNotification($email, 'template-2.php');
                return true;
            }
        }
        catch(ApplicationException $ae) {
            return false;
        }
        catch(Exception $e) {
            self::handleException($e);
            return false;
        }

        return false;
    }

    public static function isCargo(): bool
    {
        if (($_SESSION['app'] == 'cargo') || ($_SESSION['app'] == 'newCargo') || ($_SESSION['app'] == 'cargoInfo')){
            return true;
        }

        if ((!empty($_GET['page'])) && (!empty($_GET['data']))) {
            if($_GET['page'] == 'reports' && $_GET['data'] == 'cargo') {
                return true;
            }
        }

        return false;
    }

    public static function isTruck(): bool
    {
        if (($_SESSION['app'] == 'trucks') || ($_SESSION['app'] == 'newTruck') || ($_SESSION['app'] == 'truckInfo')){
            return true;
        }

        if ((!empty($_GET['page'])) && (!empty($_GET['data']))) {
            if($_GET['page'] == 'reports' && $_GET['data'] == 'trucks') {
                return true;
            }
        }

        return false;
    }

    public static function isMatch(): bool
    {
        if ($_SESSION['app'] == 'matches'){
            return true;
        }

        if ((!empty($_GET['page'])) && (!empty($_GET['data']))) {
            if($_GET['page'] == 'reports' && $_GET['data'] == 'matches') {
                return true;
            }
        }

        return false;
    }

    public static function cargoUpdateStatuses() {
        $today = date("Y-m-d");
        $last_date = DB::getMDB()->queryOneField("cargo_last_update", "SELECT cargo_last_update FROM configuration");

        if(($last_date == null) || Utils::isPast($last_date)) {
            DB::getMDB()->update ( 'cargo_request', array (
                'status' => 2
            ), "((status = 1) AND (SYSDATE() >= (acceptance + INTERVAL %d DAY)))", Utils::$CARGO_PERIOD );

            DB::getMDB()->update ( 'cargo_truck', array (
                'status' => 2
            ), "((status = 1) AND (SYSDATE() >= (acceptance + INTERVAL %d DAY)))", Utils::$CARGO_PERIOD );

            DB::getMDB()->update ( "configuration", array (
                "cargo_last_update" => $today
            ), "1=1");

            $_SESSION["update_done"] = 1;
            DB::getMDB()->commit ();
        }
    }

    public static function isPast($time) {
        return (strtotime($time) < time());
    }

    public static function isFuture($time) {
        return (strtotime($time) > time());
    }

    public static function touchUser($table, $field, $i, $id) {
        if (isset ( $_POST [$field.$i] )) {
            DB::getMDB()->update ( $table, array (
                $field => 1
            ), "id=%d", $id );
        }
        else {
            DB::getMDB()->update ( $table, array (
                $field => 0
            ), "id=%d", $id );
        }
    }

    public static function audit($table, $field, $key, $new) {
        DB::getMDB()->insert ( 'audit', array (
            'operator_id' => $_SESSION ['operator']['id'],
            'operator' => $_SESSION ['operator']['username'],
            'APP' => $_SESSION ['application'],
            'IP' => $_SERVER['REMOTE_ADDR'],
            'table' => $table,
            'field' => $field,
            'key' => $key,
            'new' => $new
        ) );
    }

    public static function trucks_audit($table, $field, $key, $new) {
        DB::getMDB()->insert ( 'trucks_audit', array (
            'operator' => $_SESSION ['operator']['username'],
            'IP' => $_SERVER['REMOTE_ADDR'],
            'table' => $table,
            'field' => $field,
            'key' => $key,
            'new' => $new
        ) );
    }

    /**
     * @throws ApplicationException
     */
    public static function insertCargoAuditEntry($table, $field, $key, $new) {
        try {
            DB::getMDB()->insert('cargo_audit', array(
                'operator_id' => $_SESSION ['operator']['id'],
                'operator' => $_SESSION ['operator']['username'],
                'IP' => $_SERVER['REMOTE_ADDR'],
                'table' => $table,
                'field' => $field,
                'key' => $key,
                'new' => $new
            ));
        }
        catch(MeekroDBException $mdbe) {
            self::handleMySQLException($mdbe);
            throw new ApplicationException($mdbe->getMessage());
        }
    }

    public static function insertUserAuditEntry() {
        try {
            DB::getMDB()->insert('cargo_user_audit', array(
                'operator_id' => $_SESSION ['operator']['id'],
                'IP' => $_SERVER['REMOTE_ADDR']
            ));
        }
        catch(MeekroDBException $mdbe) {
            self::handleMySQLException($mdbe);
            throw new ApplicationException($mdbe->getMessage());
        }
    }

    public static function docs_audit($table, $field, $key, $new) {
        DB::getMDB()->insert ( 'docs_audit', array (
            'operator_id' => $_SESSION['operator_id'],
            'operator' => $_SESSION['operator'],
            'IP' => $_SERVER['REMOTE_ADDR'],
            'table' => $table,
            'field' => $field,
            'key' => $key,
            'new' => $new
        ) );
    }

    public static function docs_confirm_audit($table, $field, $key, $new, $op_id, $op) {
        DB::getMDB()->insert ( 'docs_audit', array (
            'operator_id' => $op_id,
            'operator' => $op,
            'IP' => $_SERVER['REMOTE_ADDR'],
            'table' => $table,
            'field' => $field,
            'key' => $key,
            'new' => $new
        ) );
    }

    public static function logout() {
        session_destroy();
        $_SESSION = array();
    }

    public static function authorized($operation) {
        if(is_string($operation)) {
            $_operation = (int)$operation;
        }
        else {
            $_operation = $operation;
        }

        if (!isset($_SESSION ['operator']['id'])) {
            return false;
        }

        switch($_operation) {
            case Utils::$QUERY: return true;
            case Utils::$ADMIN: return $_SESSION['operator']['class'] == 0;
            case Utils::$OPERATIONAL: return $_SESSION['operator']['class'] == 1;

            case Utils::$REPORTS: return $_SESSION['operator']['reports'];
            case Utils::$INSERT: return $_SESSION['operator']['insert'];
            default: return false;
        }
    }

    public static function authorizedDocs() {
        if (!isset($_SESSION ['operator']['id'])) {
            return false;
        }

        return true;
    }

    public static function highlightPageItem(string $table, string $row, int $id) {
        switch($table) {
            case 'cargo_request': {
                if($_SESSION['role'] == 'originator') {
                    $a = Audit::readCargo($id, 'recipient');
                }
                else {
                    if($_SESSION['role'] == 'recipient') {
                        $a = Audit::readCargo($id, 'originator');
                    }
                    else {
                        error_log('Cannot determine to whom I shall write the audit file to.');
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
                    default:                { error_log('Wrong data row received in Utils::highlightPageItem() => '.$row); break;}
                }
                Audit::writeCargo($a);

                break;
            }
            case 'cargo_truck': {
                // TODO: Read it from file
                $a = Audit::readTruck($id);

                switch($row) {
                    case 'id':              { $a->setId(true); break;}
                    case 'operator':        { $a->setOperator(true); break;}
                    case 'originator_id':   { $a->setOriginator(true); break;}
                    case 'recipient_id':    { $a->setRecipient(true); break;}
                    case 'accepted_by':     { $a->setAcceptedBy(true); break;}
                    case 'status':          { $a->setStatus(true); break;}
                    case 'from_city':       { $a->setFromCity(true); break;}
                    case 'from_address':    { $a->setFromAddress(true); break;}
                    case 'loading_date':    { $a->setLoadingDate(true); break;}
                    case 'unloading_date':  { $a->setUnloadingDate(true); break;}
                    case 'availability':    { $a->setAvailability(true); break;}
                    case 'acceptance':      { $a->setAcceptance(true); break;}
                    case 'expiration':      { $a->setExpiration(true); break;}
                    case 'details':         { $a->setDetails(true); break;}
                    case 'freight':         { $a->setFreight(true); break;}
                    case 'plate_number':    { $a->setPlateNumber(true); break;}
                    case 'ameta':           { $a->setAmeta(true); break;}
                    case 'cargo_type':      { $a->setCargoType(true); break;}
                    case 'truck_type':      { $a->setTruckType(true); break;}
                    case 'contract_type':   { $a->setContractType(true); break;}
                    case 'adr':             { $a->setAdr(true); break;}
                    default:                {error_log('Wrong data row received: '.$row); break;}
                }
                Audit::writeTruck($a);

                break;
            }
            default: {
                error_log('Wrong table received: '.$table);

                break;
            }
        }
    }
}

class ApplicationException extends Exception
{
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Throwable $previous = null) {
        // some code

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    public function customFunction() {
        echo "A custom function for this type of exception\n";
    }
}
