<?php

use PHPMailer\PHPMailer\PHPMailer;
use Rohel\Request;
use Rohel\RequestUpdates;
use Rohel\Truck;
use Rohel\TruckUpdates;

class Utils
{
    public static bool $DEBUG = false;
    public static int $CARGO_PERIOD = 7;
    public static int $SOLVED_TRUCK_DAYS = 2;
    public static int $REPORTS_PERIOD = 180;
    public static int $QUERY = 1;
    public static int $INSERT = 5;
    public static int $ADMIN = 6;
    public static string $PHP_DATE_FORMAT = 'd-m-Y';
    public static string $SQL_DATE_FORMAT = '%d-%m-%Y';
    public static int $PASSWORD_LENGTH = 6;
    public static string $BASE_URL = 'https://cat.rohel.ro/';
    public static string $TIMEZONE = 'Europe/Bucharest';
    public static int $REPORTS = 11;
    public static int $OPERATIONAL = 12;
    public static string $CANCELLED = 'CANCELLED';
    public static int $DECIMALS = 2;

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
        AppLogger::getLogger()->error("Database error: " . $mdbe->getMessage());
        AppLogger::getLogger()->error("Database error query: " . $mdbe->getQuery());
        AppLogger::getLogger()->error("Database error code: " . $mdbe->getCode());
    }

    public static function handleException(Exception $e)
    {
        AppLogger::getLogger()->error("General error: " . $e->getMessage());
        AppLogger::getLogger()->error("Error code: " . $e->getCode());
        AppLogger::getLogger()->error("Error trace: " . $e->getTraceAsString());
    }

    public static function handleMailException(\PHPMailer\PHPMailer\Exception $e)
    {
        AppLogger::getLogger()->error("Mailing error: " . $e->errorMessage());
        AppLogger::getLogger()->error("Error code: " . $e->getCode());
        AppLogger::getLogger()->error("Error trace: " . $e->getTraceAsString());
    }

    public static function addResetKey(string $username): bool
    {
        try {
            $recipient = DB_utils::selectUser($username);
            if(empty($recipient)) return false;

            $reset_key = hash('sha256', self::randomString(self::$PASSWORD_LENGTH));

            if (DB_utils::addResetKey($username, $reset_key)) {
                $email['subject'] = 'ROHEL | New application password ';
                $email['title'] = 'ROHEL | E-mail';
                $email['header'] = 'New application password requested';
                $email['body-1'] = 'Hi ' . $recipient->getName() . '!';
                $email['body-2'] = 'Someone requested a new password for your account. If you are not aware of this, simply disregard this message.<br><br> If you want to change your password, please confirm by using the link below and a new password will be generated for you and you will receive it in a new e-mail.';
                $email['recipient']['e-mail'] = $recipient->getUsername();
                $email['recipient']['name'] = $recipient->getName();
                $email['originator']['e-mail'] = Mails::$WEBMASTER_EMAIL;
                $email['originator']['name'] = Mails::$WEBMASTER_NAME;
                $email['link']['url'] = self::$BASE_URL.'api/resetPassword.php?key='.$reset_key;
                $email['link']['text'] = 'Confirm here your request for a new password';
                $email['bg-color'] = Mails::$BG_ACKNOWLEDGED_COLOR;
                $email['tx-color'] = Mails::$TX_ACKNOWLEDGED_COLOR;

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

    public static function resetPassword(string $reset_key): bool
    {
        try {
            $recipient = DB_utils::selectUserByResetKey($reset_key);
            if(empty($recipient)) return false;
            $password = self::randomString(self::$PASSWORD_LENGTH);

            if (DB_utils::changeUserPassword($recipient->getUsername(), hash('sha256', $password))) {
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
                    default:                { AppLogger::getLogger()->error('Wrong data row received in Utils::highlightPageItem() => '.$row); break;}
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
                    default:                {AppLogger::getLogger()->error('Wrong data row received: '.$row); break;}
                }
                Audit::writeTruck($a);

                break;
            }
            default: {
                AppLogger::getLogger()->error('Wrong table received: '.$table);

                break;
            }
        }
    }

    public static function updateNotifications()
    {
    // Notifications clean-up
    try {
        DB_utils::clearNotifications($_SESSION['operator']['id'], 1, $_SESSION['entry-id']);
        $_SESSION['operator']['notification-count'] = DB_utils::notificationsCount();
        if($_SESSION['operator']['notification-count'] == 0) {
        echo '
        <script>
            if(document.getElementById("kt_user_icon_ring")) {
                document.getElementById("kt_user_icon_ring").classList.remove("pulse-ring");
            }
            if(document.getElementById("kt_quick_user_toggle")) {
                document.getElementById("kt_quick_user_toggle").classList.remove("pulse");
                document.getElementById("kt_quick_user_toggle").classList.remove("pulse-danger");
                document.getElementById("kt_quick_user_toggle").removeAttribute("data-toggle");
                document.getElementById("kt_quick_user_toggle").removeAttribute("data-placement");
                document.getElementById("kt_quick_user_toggle").removeAttribute("title");
            }
        </script>
        ';
        }
        else {
            echo '
            <script>
                document.getElementById("kt_quick_user_toggle").setAttribute("title", "You have '.$_SESSION['operator']['notification-count'].' new notifications!");
            </script>
            ';
        }
    } catch (ApplicationException $e) {
        //
    }
    }

    public static function isHelp(): bool
    {
        if (!empty($_GET['page'])) {
            if($_GET['page'] == 'help') {
                return true;
            }
        }

        return false;
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

class AppStatuses {
    public static int $APP_CARGO        = 1;
    public static int $APP_TRUCK        = 2;
    public static int $APP_MATCHES      = 3;

    public static int $CARGO_NEW        = 1;
    public static int $CARGO_ACCEPTED   = 2;
    public static int $CARGO_SOLVED     = 3;
    public static int $CARGO_CANCELLED  = 4;
    public static int $CARGO_EXPIRED    = 5;

    public static int $TRUCK_AVAILABLE          = 1;
    public static int $TRUCK_FREE               = 2;
    public static int $TRUCK_MARKET             = 3;
    public static int $TRUCK_PARTIALLY_SOLVED   = 4;
    public static int $TRUCK_FULLY_SOLVED       = 5;
    public static int $TRUCK_CANCELLED          = 6;

    public static int $MATCH_AVAILABLE  = 1;
    public static int $MATCH_NEEDED     = 2;
    public static int $MATCH_FREE       = 3;
    public static int $MATCH_MARKET     = 4;
    public static int $MATCH_PARTIAL    = 5;
    public static int $MATCH_SOLVED     = 6;

    public static int $NOTIFICATION_KIND_NEW        = 1;
    public static int $NOTIFICATION_KIND_CHANGED    = 2;
    public static int $NOTIFICATION_KIND_APPROVED   = 3;
    public static int $NOTIFICATION_KIND_CANCELLED  = 4;

    public static int $NOTIFICATION_ENTITY_KIND_CARGO       = 1;
    public static int $NOTIFICATION_ENTITY_KIND_TRUCK       = 2;
    public static int $NOTIFICATION_ENTITY_KIND_TRUCK_STOP  = 3;
    public static int $NOTIFICATION_ENTITY_KIND_CARGO_NOTE  = 4;
}
