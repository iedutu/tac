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
    public static bool $ALLOW_MAILS = true;
    public static string $BASE_HREF = 'https://cat.rohel.ro';

    public static string $BG_INFO_COLOR = '#8950FC';
    public static string $TX_INFO_COLOR = '#ffffff';
    public static string $BG_SUCCESS_COLOR = '#1BC5BD';
    public static string $TX_SUCCESS_COLOR = '#ffffff';
    public static string $BG_WARNING_COLOR = '#FFA800';
    public static string $TX_WARNING_COLOR = '#ffffff';
    public static string $BG_DANGER_COLOR = '#F64E60';
    public static string $TX_DANGER_COLOR = '#ffffff';
    public static string $BG_DARK_COLOR = '#181C32';
    public static string $TX_DARK_COLOR = '#ffffff';
    public static string $BG_PRIMARY_COLOR = '#0BB783';
    public static string $TX_PRIMARY_COLOR = '#ffffff';
    public static string $BG_SECONDARY_COLOR = '#E4E6EF';
    public static string $TX_SECONDARY_COLOR = '#3F4254';
    public static string $BG_LIGHT_COLOR = '#F3F6F9';
    public static string $TX_LIGHT_COLOR = '#7E8299';

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
            $mail->setFrom('webmaster@cat.rohel.ro ', 'Team Rohel');
            $mail->addReplyTo($email['originator']['e-mail'], $email['originator']['name']);

            ob_start();
            include($_SERVER["DOCUMENT_ROOT"].'/assets/html/'.$template);
            $body = ob_get_clean();
            $mail->msgHTML($body, dirname(__FILE__), true); // Create message bodies and embed images
            if (self::$ALLOW_MAILS) {
                if(!$mail->send()) {
                    AppLogger::getLogger()->error('Unable to send mail.');
                }
            }
        } catch (\PHPMailer\PHPMailer\Exception $me) {
            Utils::handleMailException($me);
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['message'] = 'E-mail error ('.$me->getCode().':'.$me->errorMessage().'). Please contact your system administrator.';
            throw new ApplicationException(($me->errorMessage()));
        }
    }
}
