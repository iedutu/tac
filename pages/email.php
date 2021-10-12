<?php

include_once "../vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;


// Send any relevant e-mail
try {
    $mail = new PHPMailer ();
    include "../lib/mail-settings.php";
    $mail->Subject = "e-mail subject";

    $mail->addAddress ( "cristian.ungureanu@gmail.com" );

    ob_start ();
    include_once (dirname ( __FILE__ ) . "/../html/cargo.html");
    $body = ob_get_clean ();
    $mail->msgHTML ( $body, dirname ( __FILE__ ), true ); // Create message bodies and embed images

    // send the message, check for errors
    $mail->send ();

    echo "E-mail sent successfuly!";
} catch (\PHPMailer\PHPMailer\Exception $e) {
    echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
    echo $e->getMessage(); //Boring error messages from anything else!
}