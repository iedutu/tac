<?php

use PHPMailer\PHPMailer\PHPMailer;
use Rohel\Request;
use Rohel\Truck;

class Mails
{
    public static bool $DEBUG = true;
    public static bool $DO_NOT_SEND_MAILS = true;

    public static function clean_up()
    {
        unset($_SESSION['email-recipient']);
    }

    /**
     * @throws ApplicationException
     */
    public static function emailNewCargoEntryNotification(Request $entry, $email) {
        try {
            $mail = new PHPMailer ();
            include $_SERVER["DOCUMENT_ROOT"] . "/lib/mail-settings.php";

            $mail->Subject = $email['subject'];

            $mail->addAddress($email['recipient'], $email['recipient']);

            ob_start();
            include_once($email['template']);
            $body = ob_get_clean();
            $mail->msgHTML($body, dirname(__FILE__), true); // Create message bodies and embed images
            if (!self::$DO_NOT_SEND_MAILS) {
                $mail->send();
            }
        } catch (\PHPMailer\PHPMailer\Exception $me) {
            Utils::handleMailException($me);
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'E-mail error ('.$me->getCode().':'.$me->errorMessage().'). Please contact your system administrator.';
            throw new ApplicationException(($me->errorMessage()));
        }

    }

    /**
     * @throws ApplicationException
     */
    public static function emailNewTruckEntryNotification(Truck $entry, $email) {
        return;

        try {
            $mail = new PHPMailer ();
            include $_SERVER["DOCUMENT_ROOT"] . "/lib/mail-settings.php";

            $mail->Subject = $email['subject'];

            $mail->addAddress($email['recipient'], $email['recipient']);

            ob_start();
            include_once($email['template']);
            $body = ob_get_clean();
            $mail->msgHTML($body, dirname(__FILE__), true); // Create message bodies and embed images
            if (!self::$DO_NOT_SEND_MAILS) {
                $mail->send();
            }
        } catch (\PHPMailer\PHPMailer\Exception $me) {
            Utils::handleMailException($me);
            throw new ApplicationException(($me->errorMessage()));
        }

    }

}
