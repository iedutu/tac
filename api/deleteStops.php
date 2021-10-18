<?php

use Rohel\TruckStop;

session_start ();

$truck_id = $_SESSION['entry-id'];
$return = true;
$stops = [];

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

try {
    $truck = DB_utils::selectTruck($_SESSION['entry-id']);
    if(empty($truck)) {
        header ( 'Location: /index.php?page=trucks' );
        exit();
    }

    if(empty($_POST['ids'])) {
        header ( 'Location: /index.php?page=trucks' );
        exit();
    }

    DB_utils::deleteTruckStops($truck, $_POST['ids']);

    // Set the trigger for the generation of the Match page
    DB_utils::writeValue('changes', '1');

    // Add a notification to the receiver of the cargo request
    DB_utils::addNotification($truck->getRecipient(), 4, 3, $truck->getId());

    // Send a notification e-mail to the recipient
    $originator = DB_utils::selectUserById($truck->getOriginator());
    $recipient = DB_utils::selectUserById($truck->getRecipient());

    $email['subject'] = 'Change in scheduled stops by ' . $originator->getName();
    $email['title'] = 'ROHEL | E-mail';
    $email['header'] = 'A number of scheduled stops were removed by ' . $originator->getName();
    $email['body-1'] = 'has removed <strong>'.sizeof($_POST['ids']).'</strong> scheduled stops from a truck order from <strong>' . $truck->getFromCity() . '</strong>' . '.';
    $email['body-2'] = 'The loading date is <strong>' . date(Utils::$PHP_DATE_FORMAT, $truck->getLoadingDate()) . '</strong>';
    $email['originator']['e-mail'] = $originator->getUsername();
    $email['originator']['name'] = $originator->getName();
    $email['recipient']['e-mail'] = $recipient->getUsername();
    $email['recipient']['name'] = $recipient->getName();
    $email['link']['url'] = 'https://rohel.iedutu.com/?page=truckInfo&id='.$truck->getId();
    $email['link']['text'] = 'View the truck order details';
    $email['bg-color'] = Mails::$BG_DELETED_COLOR;
    $email['tx-color'] = Mails::$TX_DELETED_COLOR;

    Mails::emailNotification($email);
}
catch (ApplicationException $ae) {
    return false;
}
catch (Exception $e) {
    Utils::handleException($e);
    return false;
}

header('Content-Type: application/json');
echo json_encode(true);