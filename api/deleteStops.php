<?php

use Rohel\TruckStop;

session_start ();

$truck_id = $_SESSION['entry-id'];
$return = true;
$stops = [];

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";
include $_SERVER["DOCUMENT_ROOT"]."/lib/mail-settings.php";

error_log('Received an array of ['.sizeof($_POST['ids']).'] elements.');
for($i=0;$i<sizeof($_POST['ids']);$i++) {
    error_log('data['.$i.'] = '.$_POST['ids'][$i].'.');
}
try {
    // Retrieve the list of stops for our truck
    $stops_count = DB::getMDB()->queryFirstField("SELECT
                                        count(1)
                                     FROM 
                                        cargo_truck_stops
                                     WHERE
                                        truck_id=%d", $_SESSION['entry-id']);
    error_log('I have ['.$stops_count.'] elements in my DB.');

    // Remove the stops from the database
    // TODO: Shall I mark them as CANCELLED instead?
    // See if the user selected all
    $deleted_stops = 0;
    if($stops_count > sizeof($_POST['ids'])) {
        for ($i = 0; $i < sizeof($_POST['ids']); $i++) {
            DB::getMDB()->delete('cargo_truck_stops', 'id=%d', $_POST['ids'][$i]);
            $deleted_stops++;
        }
    }
    else {
        for ($i = 0; $i < sizeof($_POST['ids']) - 1; $i++) {
            DB::getMDB()->delete('cargo_truck_stops', 'id=%d', $_POST['ids'][$i]);
            $deleted_stops++;
        }
    }

    // Redo the stop_id numbers on the remaining records
    DB::getMDB()->get()->multi_query('SET @num := -1; UPDATE cargo_truck_stops SET stop_id = @num := (@num+1) WHERE truck_id='.$_SESSION['entry-id'].' ORDER BY stop_id');
    while (DB::getMDB()->get()->next_result()) {;}  // Required to fix the sync error: https://stackoverflow.com/questions/27899598/mysqli-multi-query-commands-out-of-sync-you-cant-run-this-command-now

    // Set the trigger for the generation of the Match page
    DB_utils::writeValue('changes', '1');

    // Add a notification to the receiver of the cargo request
    DB_utils::addNotification($_SESSION['recipient-id'], 4, 3, $_SESSION['entry-id']);

    DB::getMDB()->commit();
}
catch (MeekroDBException $mdbe) {
    Utils::handleMySQLException($mdbe);
    return null;
}
catch (Exception $e) {
    Utils::handleException($e);
    return null;
}

if($return) {
    header('Content-Type: application/json');
    echo json_encode(true);
}
else {
    return null;
}