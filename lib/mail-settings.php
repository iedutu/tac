<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if(isset($mail)) {
    $mail->isSMTP();
// Enable SMTP debugging
// SMTP::DEBUG_OFF = off (for production use)
// SMTP::DEBUG_CLIENT = client messages
// SMTP::DEBUG_SERVER = client and server messages
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
//Set the hostname of the mail server
    $mail->Host = 'mail.rohel.ro';
//Set the SMTP port number - likely to be 25, 465 or 587
    $mail->Port = 465;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
//Whether to use SMTP authentication
    $mail->SMTPAuth = true;
//Username to use for SMTP authentication
    $mail->Username = 'webmaster@rohel.ro';
//Password to use for SMTP authentication
    $mail->Password = 'MST-web414';
//Set who the message is to be sent from
    $mail->setFrom('webmaster@rohel.ro', 'Darth Vader');
//Set an alternative reply-to address
    $mail->addReplyTo('no-replyto@rohel.ro', 'No Replies');
//Set who the message is to be sent to
}
?>