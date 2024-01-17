<?php
// This is for testing e-mail dispatch

session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/lib/includes.php";

try {
    // Send a notification e-mail to the recipient
    $email['subject'] = 'Testing e-mails - ' . rand(1, 1000);
    $email['title'] = 'ROHEL | E-mail';
    $email['header'] = 'e-mail header';
    $email['body-1'] = 'e-mail body 1';
    $email['body-2'] = 'e-mail body 2';
    $email['originator']['e-mail'] = 'originator@rohel.ro';
    $email['originator']['name'] = 'Mr. Originator';
    $email['recipient']['e-mail'] = 'cristian.ungureanu@gmail.com';
    $email['recipient']['name'] = 'Mr. Recipient';
    $email['link']['url'] = Mails::$BASE_HREF . '/?page=cargo';
    $email['link']['text'] = 'View the remaining cargos';
    $email['bg-color'] = Mails::$BG_CANCELLED_COLOR;
    $email['tx-color'] = Mails::$TX_CANCELLED_COLOR;

    Mails::emailNotification($email);
} catch (ApplicationException $ae) {
    echo 'Application error (' . $ae->getCode() . ': ' . $ae->getMessage() . '). ';
    return 0;
} catch (Exception $e) {
    Utils::handleException($e);
    echo 'Application error (' . $e->getCode() . ': ' . $e->getMessage() . '). ';
    return 0;
}