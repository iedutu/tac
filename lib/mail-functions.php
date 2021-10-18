<?php

use PHPMailer\PHPMailer\PHPMailer;
use Rohel\Request;
use Rohel\Truck;

class Mails
{
    // .info: #8950FC       #ffffff
    // .success: #1BC5BD    #ffffff
    // .warning: #FFA800    #ffffff
    // .danger: #F64E60     #ffffff
    // .dark: #181C32       #ffffff
    // .primary: #0BB783    #ffffff
    // .secondary: #E4E6EF  #3F4254
    // .light: #F3F6F9      #7E8299

    public static bool $DEBUG = true;
    public static bool $DO_NOT_SEND_MAILS = true;
    public static string $BASE_HREF = 'https://rohel.iedutu.com';

    public static string $BG_NEW_COLOR = '#8950FC';
    public static string $BG_PARTIALLY_LOADED_COLOR = '#8950FC';
    public static string $BG_FULLY_LOADED_COLOR = '#1BC5BD';
    public static string $BG_ACKNOWLEDGED_COLOR = '#1BC5BD';
    public static string $BG_CANCELLED_COLOR = '#F64E60';
    public static string $BG_DELETED_COLOR = '#F64E60';
    public static string $BG_UPDATED_COLOR = '#E4E6EF';

    public static string $TX_NEW_COLOR = '#ffffff';
    public static string $TX_PARTIALLY_LOADED_COLOR = '#ffffff';
    public static string $TX_FULLY_LOADED_COLOR = '#ffffff';
    public static string $TX_ACKNOWLEDGED_COLOR = '#ffffff';
    public static string $TX_CANCELLED_COLOR = '#ffffff';
    public static string $TX_DELETED_COLOR = '#ffffff';
    public static string $TX_UPDATED_COLOR = '#3F4254';

    public static function clean_up()
    {
        unset($_SESSION['email-recipient']);
    }

    /**
     * @throws ApplicationException
     */
    public static function emailNotification($email, string $template = 'template.php') {
        try {
            $mail = new PHPMailer ();
            include $_SERVER["DOCUMENT_ROOT"] . "/lib/mail-settings.php";

            $mail->Subject = $email['subject'];
            $mail->addAddress($email['recipient']['e-mail'], $email['recipient']['name']);
            $mail->setFrom('webapp@rohel.ro', 'Team Rohel');
            $mail->addReplyTo($email['originator']['e-mail'], $email['originator']['name']);

            ob_start();
            include_once($_SERVER["DOCUMENT_ROOT"].'/assets/html/'.$template);
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
}
