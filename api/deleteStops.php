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
    // TODO: This might be MySQL specific!!!
    DB::getMDB()->get()->multi_query('SET @num := -1; UPDATE cargo_truck_stops SET stop_id = @num := (@num+1) WHERE truck_id='.$_SESSION['entry-id'].' ORDER BY stop_id;');
}
catch (MeekroDBException $mdbe) {
    error_log("Database error: ".$mdbe->getMessage());
    $return = false;
}
catch (Exception $e) {
    error_log("Database error: ".$e->getMessage());
    $return = false;
}

if($return) {
    header('Content-Type: application/json');
    echo json_encode(true);
}
else {
    return null;
}