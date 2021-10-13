<?php
session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

use PHPMailer\PHPMailer\PHPMailer;

if (! Utils::authorized(Utils::$INSERT)) {
    error_log("User not authorized to insert data in the database.");
	header ( 'Location: /' );
	exit ();
}

if (isset ( $_POST ['_submitted'] )) {
    try {
        $stop_id = $_POST['stop_id'];
        $stops_count = DB::getMDB()->queryFirstField("SELECT
                                        count(1)
                                     FROM 
                                        cargo_truck_stops
                                     WHERE
                                        truck_id=%d", $_SESSION['entry-id']);
        if($stop_id > $stops_count + 1) {
            $stop_id = $stops_count + 1;
        }

        DB::getMDB()->insert('cargo_truck_stops', array(
            'operator' => $_SESSION['operator']['username'],
            'SYS_CREATION_DATE' => date('Y-m-d H:i:s'),
            'city' => $_POST ['city'],
            'truck_id' => $_SESSION['entry-id'],
            'stop_id' => $stop_id-1,
            'volume' => $_POST ['volume'],
            'weight' => $_POST ['weight'],
            'loading_meters' => $_POST ['loading_meters'],
            'cmr' => $_POST ['cmr']
        ));

        $rec_id = DB::getMDB()->insertId();

        DB::getMDB()->query('UPDATE cargo_truck_stops SET stop_id=stop_id+1 WHERE ((truck_id=%d) AND (stop_id>=%d) AND (id<>%d))', $_SESSION['entry-id'], $stop_id-1, $rec_id);

        DB::getMDB()->commit();
    }
    catch (MeekroDBException $mdbe) {
        error_log("Database error: ".$mdbe->getMessage());
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';

        return 0;
    }
    catch (Exception $e) {
        error_log("Database error: ".$e->getMessage());
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Database error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

        return 0;
    }

	$id = DB::getMDB()->insertId();
	$url = 'http://www.rohel.ro/new/tac/?page=details&type=truck&id='.$id;

    try {
        // e-mail confirmation
        $mail = new PHPMailer ();
        include "../lib/mail-settings.php";

        $mail->Subject = "New truck stop added by " . $_POST['originator'];

        $cargo_details = 'TBD';

        $mail->addAddress ( $_POST['recipient'], $_POST['recipient'] );

        ob_start ();
        include_once (dirname ( __FILE__ ) . "../../html/new_truck.html");
        $body = ob_get_clean ();
        $mail->msgHTML ( $body, dirname ( __FILE__ ), true ); // Create message bodies and embed images
        if(!Utils::$DO_NOT_SEND_MAILS) {
            $mail->send ();
        }
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        error_log("E-mail error: ".$e->errorMessage());
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'E-mail error ('.$e->getCode().':'.$e->errorMessage().'). Please contact your system administrator.';
    } catch (Exception $e) {
        error_log("E-mail error: ".$e->getMessage());
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'E-mail error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';
    }

    header ( 'Location: /?page=truckInfo&id='.$_SESSION['entry-id']);
    exit();
}

header ( "Location: /" );
exit();