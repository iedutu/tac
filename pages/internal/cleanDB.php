<?php

include $_SERVER["DOCUMENT_ROOT"]."/vendor/autoload.php";
include $_SERVER["DOCUMENT_ROOT"]."/lib/db-settings.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/lib/site-functions.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/lib/db-functions.php";

DB::getMDB()->query('delete from cargo_truck_comments');
DB::getMDB()->query('delete from cargo_comments');
DB::getMDB()->query('delete from cargo_notifications');
DB::getMDB()->query('delete from cargo_truck_stops');
DB::getMDB()->query('delete from cargo_audit');
DB::getMDB()->query('delete from cargo_match');
DB::getMDB()->query('delete from cargo_request');
DB::getMDB()->query('delete from cargo_truck');

DB::getMDB()->query('ALTER TABLE cargo_truck_comments AUTO_INCREMENT = 1');
DB::getMDB()->query('ALTER TABLE cargo_notifications AUTO_INCREMENT = 1');
DB::getMDB()->query('ALTER TABLE cargo_truck_stops AUTO_INCREMENT = 1');
DB::getMDB()->query('ALTER TABLE cargo_audit AUTO_INCREMENT = 1');
DB::getMDB()->query('ALTER TABLE cargo_match AUTO_INCREMENT = 1');
DB::getMDB()->query('ALTER TABLE cargo_request AUTO_INCREMENT = 1');
DB::getMDB()->query('ALTER TABLE cargo_truck AUTO_INCREMENT = 1');
DB::getMDB()->query('ALTER TABLE cargo_comments AUTO_INCREMENT = 1');

echo 'Database clean-up complete!';
