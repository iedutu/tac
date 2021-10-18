<?php

use PHPMailer\PHPMailer\PHPMailer;
use Rohel\Request;
use Rohel\Truck;

class Mails
{
    public static bool $DEBUG = true;
    public static bool $DO_NOT_SEND_MAILS = true;
    public static string $BASE_HREF = 'https://rohel.iedutu.com';
    public static string $NEW_COLOR = '#7952B3';
    public static string $PARTIALLY_LOADED_COLOR = '#7952B3';
    public static string $FULLY_LOADED_COLOR = '#7952B3';
    public static string $ACKNOWLEDGED_COLOR = '#7952B3';
    public static string $CANCELLED_COLOR = '#7952B3';
    public static string $DELETED_COLOR = '#7952B3';
    public static string $UPDATED_COLOR = '#7952B3';

    public static function clean_up()
    {
        unset($_SESSION['email-recipient']);
    }

    /**
     * @throws ApplicationException
     */
    public static function emailNotification($email) {
        try {
            $mail = new PHPMailer ();
            include $_SERVER["DOCUMENT_ROOT"] . "/lib/mail-settings.php";

            $mail->Subject = $email['subject'];
            $mail->addAddress($email['recipient']['address'], $email['recipient']['name']);
            $mail->setFrom('webapp@rohel.ro', 'Team Rohel');
            $mail->addReplyTo($email['originator']['address'], $email['originator']['name']);

            ob_start();
            include_once($_SERVER["DOCUMENT_ROOT"].'/assets/html/template.php');
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
