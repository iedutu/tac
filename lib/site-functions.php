<?php

use PHPMailer\PHPMailer\PHPMailer;
use Rohel\Request;
use Rohel\Truck;

class Utils {
	public static $DEBUG = true;
	public static $SQL_LIMIT = 256;
	public static $BOTH_RECIPIENTS = true;
	public static $DO_NOT_SEND_MAILS = true;
	public static $CARGO_PERIOD = 5;
	public static $TRUCKS_PERIOD = 3;
	public static $AUDIT_PERIOD = 90;
	public static $REPORTS_PERIOD = 180;
	public static $QUERY = 1;
	public static $ALTER = 2;
	public static $ADD_DOCS = 3;
	public static $DELETE_DOCS = 4;
	public static $INSERT = 5;
	public static $ADMIN = 6;
	public static $DATE_FORMAT = 'Y/m/d';

	public static $OP_APPROVE = 7;
	public static $AC_APPROVE = 8;
	public static $FN_APPROVE = 9;
	public static $PY_APPROVE = 10;

	public static $REPORTS = 11;
	public static $OPERATIONAL = 12;
	public static $SET_CUSTOMS = 13;
	public static $SET_UNLOADING = 14;
	
	public static $AC_UPFRONT_APPROVE = 21;
	public static $AC_FINAL_APPROVE = 22;
	public static $FN_UPFRONT_APPROVE = 23;
	public static $FN_FINAL_APPROVE = 24;
	public static $FN_UPFRONT_DENY = 25;
	public static $FN_FINAL_DENY = 26;
	public static $PY_UPFRONT_APPROVE = 27;
	public static $PY_FINAL_APPROVE = 28;

	public static $DELETE_TRIPS = 29;

	public static $CANCELLED = 'CANCELLED';
	public static $REQUEST_CONFIRMED = 'REQUEST CONFIRMED';
	public static $REQUEST_SENT = 'REQUEST SENT';
	public static $DISPATCH_SENT = 'DISPATCH SENT';
	public static $DISPATCH_FULFILLED = 'DISPATCH FULFILLED';
	public static $REQUEST_DISPATCHED = 'REQUEST DISPATCHED';
	public static $DOCUMENT_AKNOWLEDGED = 'DOCUMENT ACKNOWLEDGED';
	public static $REQUEST_FULFILLED	= 'REQUEST FULFILLED';


	public static function clean_up() {
	    unset($_SESSION['entry-id']);
//      unset($_SESSION['update_done']);
        unset($_SESSION['email-recipient']);
    }

	public static function isCargo(): bool
    {
        if($_SESSION['app']=='cargo') {
            return true;
        }

        if($_SESSION['app']=='newCargo') {
            return true;
        }

        if($_SESSION['app']=='cargoInfo') {
            return true;
        }

	    return false;
    }

    public static function isTruck(): bool
    {
        if($_SESSION['app']=='trucks') {
            return true;
        }

        if($_SESSION['app']=='newTruck') {
            return true;
        }

        if($_SESSION['app']=='truckInfo') {
            return true;
        }

        return false;
    }

    public static function isMatch(): bool
    {
        if($_SESSION['app']=='match') {
            return true;
        }

        return false;
    }

    public static function mailingTruckDetails(Truck $truck): string
    {
        $loading_date = 'N/A';
        $unloading_date = 'N/A';

        if(($truck->getLoadingDate() != null) && ($truck->getLoadingDate() != 0)){
            $loading_date = date('Y-m-d', strtotime($truck->getLoadingDate()));
        }

        if(($truck->getUnloadingDate() != null) && ($truck->getUnloadingDate() != 0)){
            $unloading_date = date('Y-m-d', strtotime($truck->getUnloadingDate()));
        }

        $details = '<table border="0" cellpadding="2" cellspacing="0" class="message">
                    <tr>
                        <td>
                            Originator:
                        </td>
                        <td>
                            '.$truck->getOriginator().'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Recipient:
                        </td>
                        <td>
                            '.$truck->getRecipient().'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Available in:
                        </td>
                        <td>
                            '.$truck->getFromCity().'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Available for:
                        </td>
                        <td>
                            '.$truck->getToCity().'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Available from:
                        </td>
                        <td>
                            '.((empty($truck->getAvailability()))?'N/A':$truck->getAvailability()).'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Available until:
                        </td>
                        <td>
                            '.((empty($truck->getExpiration()))?'N/A':$truck->getExpiration()).'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Details
                        </td>
                        <td>
                            '.((empty($truck->getDetails()))?'N/A':$truck->getDetails()).'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Freight
                        </td>
                        <td>
                            '.((empty($truck->getFreight()))?0:$truck->getFreight()).' euro
                        </td>
                    </tr>
                </table>';

        return $details;
    }

    public static function mailingCargoDetails(Request $cargo): string
    {
        $loading_date = 'N/A';
        $unloading_date = 'N/A';

        if(($cargo->getLoadingDate() != null) && ($cargo->getLoadingDate() != 0)){
            $loading_date = date('Y-m-d', strtotime($cargo->getLoadingDate()));
        }

        if(($cargo->getUnloadingDate() != null) && ($cargo->getUnloadingDate() != 0)){
            $unloading_date = date('Y-m-d', strtotime($cargo->getUnloadingDate()));
        }

        $details = '
           <table border="0" cellpadding="2" cellspacing="0" class="message">
                <tr>
                    <td>
    Originator:
                    </td>
                    <td>
    '.$cargo->getOriginator().'
    </td>
                </tr>
                <tr>
                    <td>
    Recipient:
                    </td>
                    <td>
    '.$cargo->getRecipient().'
    </td>
                </tr>
                <tr>
                    <td>
    Client:
                    </td>
                    <td>
    '.((!empty($cargo->getClient()))?'N/A':$cargo->getClient()).'
    </td>
                </tr>
                <tr>
                    <td>
    From:
                    </td>
                    <td>
    '.$cargo->getFromCity().'
    </td>
                </tr>
                <tr>
                    <td>
    To:
                    </td>
                    <td>
    '.$cargo->getToCity().'
    </td>
                </tr>
                <tr>
                    <td>
    Loading
                    </td>
                    <td>
    '.$loading_date.'
                    </td>
                </tr>
                <tr>
                    <td>
    Unloading
                    </td>
                    <td>
    '.$unloading_date.'
                    </td>
                </tr>
                <tr>
                    <td>
    Goods description
    </td>
                    <td>
    '.((!empty($cargo->getDescription()))?'N/A':$cargo->getDescription()).'
    </td>
                </tr>
                <tr>
                    <td>
    Number of collies
    </td>
                    <td>
    '.(($cargo->getCollies() == 0)?'N/A':$cargo->getCollies()).'
    </td>
                </tr>
                <tr>
                    <td>
    Gross weight
    </td>
                    <td>
    '.(($cargo->getWeight() == 0)?'N/A':$cargo->getWeight()).' kg
    </td>
                </tr>
                <tr>
                    <td>
    Volume
                    </td>
                    <td>
    '.(($cargo->getVolume() == 0)?'N/A':$cargo->getVolume()).' cbm
    </td>
                </tr>
                <tr>
                    <td>
    Loading meters
    </td>
                    <td>
    '.(($cargo->getLoadingMeters() == 0)?'N/A':$cargo->getLoadingMeters()).' m
    </td>
                </tr>
                <tr>
                    <td>
    Freight
                    </td>
                    <td>
    '.(($cargo->getFreight() == 0)?'N/A':$cargo->getFreight()).'
    </td>
                </tr>
                <tr>
                    <td>
    Plate number
    </td>
                    <td>
    '.((!empty($cargo->getPlateNumber()))?'N/A':$cargo->getPlateNumber()).'
    </td>
                </tr>
                <tr>
                    <td>
    AMETA
                    </td>
                    <td>
    '.((!empty($cargo->getAmeta()))?'N/A':$cargo->getAmeta()).'
    </td>
                </tr>
            </table>
    ';

        return $details;
    }

    public static function email_notification(string $element_name, string $element_value, string $id) {
        // Send any relevant e-mail
        try {
            $mail = new PHPMailer ();
            include $_SERVER["DOCUMENT_ROOT"] . "/lib/mail-settings.php";

            $entity = '';
            switch($_SESSION['app']) {
                case 'cargoInfo': {
                    $entity = 'Cargo request';
                    break;
                }
                case 'truckInfo': {
                    $entity = 'Truck';
                    break;
                }
                default: {
                    $entity = 'Unknown';
                    break;
                }
            }
            $mail->Subject = $entity.' modified by ' . $_SESSION ['operator'];

            $url='http://rohel.iedutu.com/?page='.$_SESSION['app'].'&id='.$id;

            $mail->addAddress ( $_SESSION['email-recipient'], $_SESSION['email-recipient'] );
            $mail->addAddress ( $_SESSION['operator'], $_SESSION['operator'] );

            ob_start ();
            include $_SERVER["DOCUMENT_ROOT"]."/html/updateField.html";

            $body = ob_get_clean ();
            $mail->msgHTML ( $body, dirname ( __FILE__ ), true ); // Create message bodies and embed images

            if(!Utils::$DO_NOT_SEND_MAILS) {
                $mail->send ();
            }
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            error_log("E-Mail error: ".$e->errorMessage());
        } catch (Exception $e) {
            error_log("E-Mail error: ".$e->getMessage());
        }
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
				'operator_id' => $_SESSION ['operator_id'],
				'operator' => $_SESSION ['operator'],
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
				'operator' => $_SESSION ['operator'],
				'IP' => $_SERVER['REMOTE_ADDR'],
				'table' => $table,
				'field' => $field,
				'key' => $key,
				'new' => $new
		) );
	}

	public static function cargo_audit($table, $field, $key, $new) {
		DB::getMDB()->insert ( 'cargo_audit', array (
				'operator_id' => $_SESSION ['operator_id'],
				'operator' => $_SESSION ['operator'],
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
	
	public static function authorized($page, $operation) {
		if(is_string($operation)) {
			$_operation = (int)$operation;
		}
		else {
			$_operation = $operation;
		}
		
		if (!isset($_SESSION ['operator_id'])) {
			return false;
		}

		switch($_operation) {
			case Utils::$QUERY: return true;
			case Utils::$ADMIN: return ($_SESSION['class'] == 0)?true:false;
			case Utils::$OPERATIONAL: return ($_SESSION['class'] == 1)?true:false;

			case Utils::$REPORTS: return $_SESSION['operator_class']['reports'];
			case Utils::$INSERT: return $_SESSION['operator_class']['insert'];
			case Utils::$ADD_DOCS: return $_SESSION['operator_class']['documents'];
			case Utils::$DELETE_DOCS: return $_SESSION['operator_class']['documents'];
			case Utils::$DELETE_TRIPS: return $_SESSION['operator_class']['remove'];
			case Utils::$OP_APPROVE: return $_SESSION['operator_class']['operational'];
			case Utils::$AC_APPROVE: return $_SESSION['operator_class']['accounting'];
//			case Utils::$FN_APPROVE: return $_SESSION['operator_class']['financial'];
			case Utils::$FN_APPROVE:
									{
										if($_SESSION['operator_class']['financial']) {
											if($page == null) {
												return true;
											}
											
											if(($page == 'BUCHAREST') && ($_SESSION['operator'] == 'florentina.burnuz@rohel.ro')) {
												return true;
											}
											
											if(($page == 'BUCHAREST') && ($_SESSION['operator'] == 'raluca.rada@rohel.ro')) {
												return true;
											}
											
											if(($page == 'ATHENS') && ($_SESSION['operator'] == 'giannakou@unit-hellas.gr')) {
												return true;
											}
											
											if(($page == 'THESSALONIKI') && ($_SESSION['operator'] == 'vagia@unit-hellas.gr')) {
												return true;
											}
											
											if(($page == 'KISHINEV') && ($_SESSION['operator'] == 'tatiana@translink.md')) {
												return true;
											}
										}
										
										return false;
									 }
			case Utils::$PY_APPROVE:
									{
										if($_SESSION['operator_class']['payments']) {
											if($page == null) {
												return true;
											}
											
											if(($page == 'BUCHAREST') && ($_SESSION['operator'] == 'florentina.burnuz@rohel.ro')) {
												return true;
											}
											
											if(($page == 'BUCHAREST') && ($_SESSION['operator'] == 'raluca.rada@rohel.ro')) {
												return true;
											}
											
											if(($page == 'ATHENS') && ($_SESSION['operator'] == 'giannakou@unit-hellas.gr')) {
												return true;
											}
											
											if(($page == 'THESSALONIKI') && ($_SESSION['operator'] == 'vagia@unit-hellas.gr')) {
												return true;
											}
											
											if(($page == 'KISHINEV') && ($_SESSION['operator'] == 'tatiana@translink.md')) {
												return true;
											}
										}
										
										return false;
									 }
//			case Utils::$PY_APPROVE: return $_SESSION['operator_class']['payments'];
			case Utils::$SET_CUSTOMS: return $_SESSION['operator_class']['set_customs'];
			case Utils::$SET_UNLOADING: return $_SESSION['operator_class']['set_unloading'];
			default: return false;
		}
	}
	
	public static function authorizedDocs() {		
		if (!isset($_SESSION ['operator_id'])) {
			return false;
		}
	}
	
	public static function all_documents($trip_id, $number) {
		$invoices = intval(DB::getMDB()->queryOneField('count(1)', 'select count(1) from documents where deleted=0 and trip_id=%d and type="INVOICE" and status="OK"', $trip_id));
		$cmrs = intval(DB::getMDB()->queryOneField('count(1)', 'select count(1) from documents where deleted=0 and trip_id=%d and type="CMR" and status="OK"', $trip_id));
		$custom_documents = intval(DB::getMDB()->queryOneField('count(1)', 'select count(1) from documents where deleted=0 and trip_id=%d and type="CUSTOMS" and status="OK"', $trip_id));
		
		if($_SESSION['application'] == 'BG') {
			return (($invoices == 1) && ($cmrs == $number));
		}
		
		if($_SESSION['application'] == 'RS') {
			return ($cmrs == $number);
		}
		
		if($_SESSION['application'] == 'RU') {
			return (($invoices == 1) && ($cmrs == $number) && ($custom_documents == $number));
		}
		
		return false;
	}

	public static function all_CMR_OK($trip_id) {
		$row = DB::getMDB()->queryFirstRow('select * from trips where id=%d', $trip_id);
		$customers = explode("+", $row['client']);
		$cnumber = sizeof($customers);
		
		$cmr_nok = intval(DB::getMDB()->queryOneField('count(1)', 'select count(1) from documents where deleted=0 and trip_id=%d and type="CMR" and status="NOK"', $trip_id));
		$cmr_ok = intval(DB::getMDB()->queryOneField('count(1)', 'select count(1) from documents where deleted=0 and trip_id=%d and type="CMR" and status="OK"', $trip_id));
		
		return (($cmr_ok == $cnumber) && ($cmr_nok == 0));
	}
	
	public static function computePlannedPaymentDate_RU($trip_id) {
		$row = DB::getMDB()->queryFirstRow('select * from trips where id=%d', $trip_id);
		$original_date = date('Y-m-d', strtotime(DB::getMDB()->queryOneField('max(reception_date)', 'select max(reception_date) from documents where type="CMR" and status="OK" and deleted=0 and trip_id=%d', $trip_id)));
		
		// default
		$planned_date = date('Y-m-d', strtotime($original_date. ' + 25 days'));
		
		if($row['due_agency'] == 'BUCHAREST') {
			$planned_date = date('Y-m-d', strtotime($original_date. ' + 25 days'));
		}
		
		if($row['due_agency'] == 'KISHINEV') {
			$planned_date = date('Y-m-d', strtotime($original_date. ' + 21 days'));
		}
		
		if(($row['registration'] == 'GREECE') && (($row['due_agency'] == 'ATHENS') || ($row['due_agency'] == 'SALONIC'))) {
			$planned_date = date('Y-m-d', strtotime($original_date. ' + 45 days')); // Changed 04.01.2016 - original value = 60 days
		}
		
		if((!($row['registration'] == 'GREECE')) && (($row['due_agency'] == 'ATHENS') || ($row['due_agency'] == 'SALONIC'))) {
			$planned_date = date('Y-m-d', strtotime($original_date. ' + 30 days')); // Changed 04.01.2016 - original value = 37 days
		}
		
//		$old_planned_date = DB::getMDB()->queryOneField('planned_payment_date', 'select planned_payment_date from trips where id=%d and status=0', $trip_id);		
//		if(($old_planned_date == null) || ((($old_planned_date != null) && ($planned_date > date('Y-m-d', strtotime($old_planned_date)))))) {
//			echo '<br>Original date: ['.$original_date.'], Old planned date: ['.$old_planned_date.'], Planned date: ['.$planned_date.']';
		
		DB::getMDB()->update('trips', array(
			'planned_payment_date' => $planned_date,
			'OPERATOR_ID' => $_SESSION['operator_id'],
			'OPERATOR' => $_SESSION['operator'],
			), "id=%d", $trip_id);
		
		Utils::audit ('trips', 'planned_payment_date', $trip_id, $planned_date);

//		}		
	}
	
	public static function computePlannedPaymentDate_BG($trip_id) {
		/******
		 * Manual entry only
		 ******/
	}
	
	public static function computePlannedPaymentDate_RS($trip_id) {
		/******
		 * Manual entry only
		 ******/
	}
	
	public static function alertOP($trip_id) {
		$results = DB::getMDB()->query ( "SELECT * FROM users WHERE CLASS>0 AND APP_".$_SESSION['application']."=1 AND (approve_op=1 or OPERATOR_ID=(select originator from trips where id=".$trip_id."))" );
		if ($results != null) {
			$ameta = DB::getMDB()->queryOneField('ameta', "SELECT ameta FROM trips WHERE id=%d", $trip_id);
			$doc = DB::getMDB()->queryFirstRow("SELECT * FROM documents WHERE trip_id=%d AND type='CMR' AND status='NOK' AND deleted=0 ORDER BY SYS_UPDATE_DATE DESC ", $trip_id);
			
			$mail = new PHPMailer ();
			$mail->CharSet = 'utf-8';
			/*
			 * sendmail()
			 *
			$mail->isMail ();
			$mail->setFrom ( "no-reply@rohel.ro", "ROHEL Web Team" );
			$mail->addReplyTo ( "no-reply@rohel.ro", "ROHEL Web Team" );
			 *
			 *
			 */
			 
			/*
			 * smtp()
			 */
			$mail->isSMTP();
			$mail->SMTPDebug = 2; // 0 = production
			$mail->Debugoutput = 'html';
			$mail->Host = "mail.rohel.ro";
			$mail->Port = 465;
			$mail->SMTPAuth = true;
			$mail->Username = "webmaster@rohel.ro";
			$mail->Password = "MST-web414";
			$mail->setFrom('webmaster@rohel.ro', 'ROHEL Web Team');
			$mail->addReplyTo('replyto@rohel.ro', 'No reply');

			$mail->Subject = "NOK CMR added to AMETA ".$ameta;

			foreach ( $results as $row ) {
				$mail->addAddress ( $row['OPERATOR'], $row['OPERATOR'] );
			}

/*
			$mail->addAddress ( 'cristian.ungureanu@gmail.com', '' );
			$mail->addAddress ( 'jo.ioana.pavel@gmail.com', '' );
*/

			ob_start ();
			include_once (dirname ( __FILE__ ) . "/../html/op.html");
			$body = ob_get_clean ();
			$mail->msgHTML ( $body, dirname ( __FILE__ ), true ); // Create message bodies and embed images
		                                                      
			// send the message, check for errors
			if (! $mail->send ()) {
				// error
			}
		}
	}

	public static function alertFN($trip_id) {
		$results = DB::getMDB()->query ( "SELECT * FROM users WHERE CLASS>0 AND APP_".$_SESSION['application']."=1 AND approve_op=1" );
		if ($results != null) {
			$trip = DB::getMDB()->queryFirstRow("SELECT * FROM trips WHERE id=%d", $trip_id);
			
			$mail = new PHPMailer ();
			$mail->CharSet = 'utf-8';

			/*
			 * sendmail()
			 *
			$mail->isMail ();
			$mail->setFrom ( "no-reply@rohel.ro", "ROHEL Web Team" );
			$mail->addReplyTo ( "no-reply@rohel.ro", "ROHEL Web Team" );
			 *
			 *
			 */
			 
			/*
			 * smtp()
			 */
			$mail->isSMTP();
			$mail->SMTPDebug = 2; // 0 = production
			$mail->Debugoutput = 'html';
			$mail->Host = "mail.rohel.ro";
			$mail->Port = 465;
			$mail->SMTPAuth = true;
			$mail->Username = "webmaster@rohel.ro";
			$mail->Password = "MST-web414";
			
			$mail->setFrom('webmaster@rohel.ro', 'ROHEL Web Team');
			$mail->addReplyTo('replyto@rohel.ro', 'No reply');
			$mail->Subject = "New payment date for AMETA ".$trip['ameta'];

			foreach ( $results as $row ) {
				$mail->addAddress ( $row['OPERATOR'], $row['OPERATOR'] );
			}

/*
			$mail->addAddress ( 'cristian.ungureanu@gmail.com', '' );
			$mail->addAddress ( 'jo.ioana.pavel@gmail.com', '' );
*/

			ob_start ();
			include_once (dirname ( __FILE__ ) . "/../html/fn.html");
			$body = ob_get_clean ();
			$mail->msgHTML ( $body, dirname ( __FILE__ ), true ); // Create message bodies and embed images
		                                                      
			// send the message, check for errors
			if (! $mail->send ()) {
				// error
			}
		}
	}
}
