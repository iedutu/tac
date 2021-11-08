<?php
session_start ();
return null;

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

try {
    $email['subject'] = 'New truck order received from Cristian';
    $email['title'] = 'ROHEL | E-mail';
    $email['header'] = ' You have a new truck order from Cristian';
    $email['body-1'] = 'has introduced a new truck order for your consideration.';
    $email['body-2'] = 'The unloading date is <strong>26/5/2021</strong>';
    $email['originator']['e-mail'] = 'ioana.pavel@rohel.ro';
    $email['originator']['name'] = 'Ioana';
    $email['recipient']['e-mail'] = 'cristian.ungureanu@gmail.com';
    $email['recipient']['name'] = 'Cristian';
    $email['link']['url'] = 'https://rohel.iedutu.com/?page=truckInfo&id=1';
    $email['link']['text'] = 'View the detailed truck order';
    $email['bg-color'] = Mails::$BG_NEW_COLOR;
    $email['tx-color'] = Mails::$TX_NEW_COLOR;

    Mails::$ALLOW_MAILS = true;
    Mails::emailNotification($email);
    echo 'Done !';
} catch (ApplicationException $ae) {
    return 0;
} catch (Exception $e) {
    Utils::handleException($e);
    return 0;
}
