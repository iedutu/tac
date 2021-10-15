<?php

use PHPMailer\PHPMailer\PHPMailer;
use Rohel\Request;
use Rohel\RequestUpdates;
use Rohel\Truck;
use Rohel\TruckUpdates;

class Utils
{
    public static bool $DEBUG = true;
    public static bool $DO_NOT_SEND_MAILS = true;
    public static int $CARGO_PERIOD = 5;
    public static int $REPORTS_PERIOD = 180;
    public static int $QUERY = 1;
    public static int $INSERT = 5;
    public static int $ADMIN = 6;
    public static string $PHP_DATE_FORMAT = 'd/m/Y';
    public static string $SQL_DATE_FORMAT = '%d/%m/%Y';

    public static int $REPORTS = 11;
    public static int $OPERATIONAL = 12;
    public static string $CANCELLED = 'CANCELLED';

    public static function clean_up()
    {
        unset($_SESSION['entry-id']);
//      unset($_SESSION['update_done']);
        unset($_SESSION['email-recipient']);
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

    public static function isCargo(): bool
    {
        if ($_SESSION['app'] == 'cargo') {
            return true;
        }

        if ($_SESSION['app'] == 'newCargo') {
            return true;
        }

        if ($_SESSION['app'] == 'cargoInfo') {
            return true;
        }

        return false;
    }

    public static function isTruck(): bool
    {
        if ($_SESSION['app'] == 'trucks') {
            return true;
        }

        if ($_SESSION['app'] == 'newTruck') {
            return true;
        }

        if ($_SESSION['app'] == 'truckInfo') {
            return true;
        }

        return false;
    }

    public static function isMatch(): bool
    {
        if ($_SESSION['app'] == 'match') {
            return true;
        }

        return false;
    }

    public static function mailingTruckDetails(Truck $truck): string
    {
        $loading_date = 'N/A';
        $unloading_date = 'N/A';

        if (($truck->getLoadingDate() != null) && ($truck->getLoadingDate() != 0)) {
            $loading_date = date('Y-m-d', strtotime($truck->getLoadingDate()));
        }

        if (($truck->getUnloadingDate() != null) && ($truck->getUnloadingDate() != 0)) {
            $unloading_date = date('Y-m-d', strtotime($truck->getUnloadingDate()));
        }

        $details = '<table border="0" cellpadding="2" cellspacing="0" class="message">
                    <tr>
                        <td>
                            Originator:
                        </td>
                        <td>
                            ' . $truck->getOriginator() . '
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Recipient:
                        </td>
                        <td>
                            ' . $truck->getRecipient() . '
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Available in:
                        </td>
                        <td>
                            ' . $truck->getFromCity() . '
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Available for:
                        </td>
                        <td>
                            ' . $truck->getToCity() . '
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Available from:
                        </td>
                        <td>
                            ' . ((empty($truck->getAvailability())) ? 'N/A' : $truck->getAvailability()) . '
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Available until:
                        </td>
                        <td>
                            ' . ((empty($truck->getExpiration())) ? 'N/A' : $truck->getExpiration()) . '
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Details
                        </td>
                        <td>
                            ' . ((empty($truck->getDetails())) ? 'N/A' : $truck->getDetails()) . '
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Freight
                        </td>
                        <td>
                            ' . ((empty($truck->getFreight())) ? 0 : $truck->getFreight()) . ' euro
                        </td>
                    </tr>
                </table>';

        return $details;
    }

    public static function mailingCargoDetails(Request $cargo): string
    {
        $loading_date = 'N/A';
        $unloading_date = 'N/A';

        if (($cargo->getLoadingDate() != null) && ($cargo->getLoadingDate() != 0)) {
            $loading_date = date('Y-m-d', strtotime($cargo->getLoadingDate()));
        }

        if (($cargo->getUnloadingDate() != null) && ($cargo->getUnloadingDate() != 0)) {
            $unloading_date = date('Y-m-d', strtotime($cargo->getUnloadingDate()));
        }

        $details = '
           <table border="0" cellpadding="2" cellspacing="0" class="message">
                <tr>
                    <td>
    Originator:
                    </td>
                    <td>
    ' . $cargo->getOriginator() . '
    </td>
                </tr>
                <tr>
                    <td>
    Recipient:
                    </td>
                    <td>
    ' . $cargo->getRecipient() . '
    </td>
                </tr>
                <tr>
                    <td>
    Client:
                    </td>
                    <td>
    ' . ((!empty($cargo->getClient())) ? 'N/A' : $cargo->getClient()) . '
    </td>
                </tr>
                <tr>
                    <td>
    From:
                    </td>
                    <td>
    ' . $cargo->getFromCity() . '
    </td>
                </tr>
                <tr>
                    <td>
    To:
                    </td>
                    <td>
    ' . $cargo->getToCity() . '
    </td>
                </tr>
                <tr>
                    <td>
    Loading
                    </td>
                    <td>
    ' . $loading_date . '
                    </td>
                </tr>
                <tr>
                    <td>
    Unloading
                    </td>
                    <td>
    ' . $unloading_date . '
                    </td>
                </tr>
                <tr>
                    <td>
    Goods description
    </td>
                    <td>
    ' . ((!empty($cargo->getDescription())) ? 'N/A' : $cargo->getDescription()) . '
    </td>
                </tr>
                <tr>
                    <td>
    Number of collies
    </td>
                    <td>
    ' . (($cargo->getCollies() == 0) ? 'N/A' : $cargo->getCollies()) . '
    </td>
                </tr>
                <tr>
                    <td>
    Gross weight
    </td>
                    <td>
    ' . (($cargo->getWeight() == 0) ? 'N/A' : $cargo->getWeight()) . ' kg
    </td>
                </tr>
                <tr>
                    <td>
    Volume
                    </td>
                    <td>
    ' . (($cargo->getVolume() == 0) ? 'N/A' : $cargo->getVolume()) . ' cbm
    </td>
                </tr>
                <tr>
                    <td>
    Loading meters
    </td>
                    <td>
    ' . (($cargo->getLoadingMeters() == 0) ? 'N/A' : $cargo->getLoadingMeters()) . ' m
    </td>
                </tr>
                <tr>
                    <td>
    Freight
                    </td>
                    <td>
    ' . (($cargo->getFreight() == 0) ? 'N/A' : $cargo->getFreight()) . '
    </td>
                </tr>
                <tr>
                    <td>
    Plate number
    </td>
                    <td>
    ' . ((!empty($cargo->getPlateNumber())) ? 'N/A' : $cargo->getPlateNumber()) . '
    </td>
                </tr>
                <tr>
                    <td>
    AMETA
                    </td>
                    <td>
    ' . ((!empty($cargo->getAmeta())) ? 'N/A' : $cargo->getAmeta()) . '
    </td>
                </tr>
            </table>
    ';

        return $details;
    }

    public static function email_notification(string $element_name, string $element_value, string $id): bool
    {
        // Send any relevant e-mail
        $mail = new PHPMailer ();
        include $_SERVER["DOCUMENT_ROOT"] . "/lib/mail-settings.php";

        $entity = '';
        switch ($_SESSION['app']) {
            case 'cargoInfo':
            {
                $entity = 'Cargo request';
                break;
            }
            case 'truckInfo':
            {
                $entity = 'Truck';
                break;
            }
            default:
            {
                $entity = 'Unknown';
                break;
            }
        }
        $mail->Subject = $entity . ' modified by ' . $_SESSION ['operator']['username'];

        $url = 'http://rohel.iedutu.com/?page=' . $_SESSION['app'] . '&id=' . $id;

        $mail->addAddress($_SESSION['email-recipient'], $_SESSION['email-recipient']);
        $mail->addAddress($_SESSION['operator']['username'], $_SESSION['operator']['username']);

        ob_start();
        include $_SERVER["DOCUMENT_ROOT"] . "/html/updateField.html";

        $body = ob_get_clean();
        $mail->msgHTML($body, dirname(__FILE__), true); // Create message bodies and embed images

        if (!Utils::$DO_NOT_SEND_MAILS) {
            $mail->send();
        }

        return true;
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

    public static function cargo_audit($table, $field, $key, $new) {
        DB::getMDB()->insert ( 'cargo_audit', array (
            'operator_id' => $_SESSION ['operator']['id'],
            'operator' => $_SESSION ['operator']['username'],
            'IP' => $_SERVER['REMOTE_ADDR'],
            'table' => $table,
            'field' => $field,
            'key' => $key,
            'new' => $new
        ) );
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
    }

    public static function audit_update(string $table, string $row, int $id) {
        error_log('audit_update with ['.$table.'], ['.$row.'], ['.$id.']');

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

                error_log('Audit file read');

                switch($row) {
                    case 'id':              { $a->setId(true); break;}
                    case 'operator':        { $a->setOperator(true); break;}
                    case 'originator':      { $a->setOriginator(true); break;}
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
                    case 'recipient':       { $a->setRecipient(true); break;}
                    case 'status':          { $a->setStatus(true); break;}
                    case 'accepted_by':     { $a->setAcceptedBy(true); break;}
                    default:                { error_log('Wrong data row received: '.$row); break;}
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
                    case 'originator':      { $a->setOriginator(true); break;}
                    case 'recipient':       { $a->setRecipient(true); break;}
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
                    case 'order_type':      { $a->setOrderType(true); break;}
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
