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
        DB::getMDB()->insert('cargo_comments', array(
            'operator' => $_SESSION['operator']['username'],
//      'SYS_CREATION_DATE' => date('Y-m-d H:i:s'),
            'comment' => $_POST ['note'],
            'cargo_id' => $_POST ['id']
        ));

        // TODO: Overhaul the audit system.
        Utils::cargo_audit('cargo_comments', 'NEW-ENTRY', null, $_POST ['id']);

        // Add a notification to the receiver of the cargo request
        DB_utils::addNotification($_POST ['recipient'], 1, 4, $_POST ['id']);

        DB::getMDB()->commit();

        $mail_recipient = '';
        $cargo = DB_utils::selectRequest($_POST['id']);

        // Send any relevant e-mail
        $mail = new PHPMailer ();
        include "../lib/mail-settings.php";

        $mail->Subject = "New cargo comment from " . $_SESSION ['operator'];

        $cargo_message = $_POST['_comment'];
        $url = 'http://www.rohel.ro/new/cargo/index.php?page=details&type=cargo&id='.$_GET ['id'];

        if($_SESSION['operator'] == $cargo->getOriginator()) {
            $mail->addAddress ( $cargo->getRecipient(), $cargo->getRecipient() );
            $mail_recipient = $cargo->getRecipient();
        }
        else {
            $mail->addAddress ( $cargo->getOriginator(), $cargo->getOriginator() );
            $mail_recipient = $cargo->getOriginator();
        }

        ob_start ();
        include_once (dirname ( __FILE__ ) . "/../html/cargo_comment.html");
        $body = ob_get_clean ();
        $mail->msgHTML ( $body, dirname ( __FILE__ ), true ); // Create message bodies and embed images

        if(!Utils::$DO_NOT_SEND_MAILS) {
            $mail->send ();
        }
    } catch (\PHPMailer\PHPMailer\Exception $me) {
        Utils::handleMailException($me);
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'E-mail error ('.$me->getCode().':'.$me->getMessage().'). Please contact your system administrator.';

        return 0;
    } catch (MeekroDBException $mdbe) {
        Utils::handleMySQLException($mdbe);
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';

        return 0;
    } catch (Exception $e) {
        Utils::handleException($e);
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'General error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

        return 0;
    }

    $_SESSION['alert']['type'] = 'success';
    $_SESSION['alert']['message'] = 'A new notification was added into the system for the cargo request. '.$mail_recipient.' was notified by e-mail.';
}


header ( "Location: /?page=".$_POST['page']."&id=".$_POST['id'] );
exit();