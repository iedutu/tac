<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/GPBMetadata/Types.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/Request.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/Truck.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/RequestUpdates.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/TruckUpdates.php";

use PHPMailer\PHPMailer\PHPMailer;
use Rohel\Request;
use Rohel\Truck;
use Rohel\RequestUpdates;
use Rohel\TruckUpdates;

class Audit {
    public static function writeCargo(RequestUpdates $a): bool
    {
        if(isset($_SESSION['role'])) {
            if($_SESSION['role'] == 'originator') {
                $for_whom = 'recipient';
            }
            else {
                if($_SESSION['role'] == 'recipient') {
                    $for_whom = 'originator';
                }
                else {
                    $for_whom = 'unknown';
                }
            }
        }
        else {
            $for_whom = 'unknown';
        }

        $filename = $_SERVER["DOCUMENT_ROOT"] . '/notifications/cargo_request_' . $for_whom.'_'.$_SESSION['entry-id'].'.bin';
        $ok = true;

        try {
            $data = '';
            if (Utils::$DEBUG) {
                $data = $a->serializeToJsonString();
            } else {
                $data = $a->serializeToString();
            }

            error_log("Data to be written: " . $data);
            error_log("Filename: " . $filename);
            file_put_contents($filename, $data);
        } catch (Exception $e) {
            error_log("Generic write error: " . $e->getMessage());

            return false;
        }

        return $ok;
    }

    public static function readCargo(int $id, string $for_whom): ?RequestUpdates
    {
        $filename = $_SERVER["DOCUMENT_ROOT"] . '/notifications/cargo_request_' . $for_whom.'_'.$id . '.bin';

        try {
            $a = new RequestUpdates();

            if (!is_file($filename)) {
                error_log("File not found: " . $filename . ". Returning an empty object.");
                return $a;
            }

            $data = file_get_contents($filename);
            error_log("Data read: " . $data);

            if (Utils::$DEBUG) {
                $a->mergeFromJsonString($data);
            } else {
                $a->mergeFromString($data);
            }
        } catch (Exception $e) {
            error_log("Generic read error: " . $e->getMessage());

            return null;
        }

        $a->setId($id);

        return $a;
    }

    public static function writeTruck(TruckUpdates $a): bool
    {
        if(isset($_SESSION['role'])) {
            if($_SESSION['role'] == 'originator') {
                $for_whom = 'recipient';
            }
            else {
                if($_SESSION['role'] == 'recipient') {
                    $for_whom = 'originator';
                }
                else {
                    $for_whom = 'unknown';
                }
            }
        }
        else {
            $for_whom = 'unknown';
        }

        $filename = $_SERVER["DOCUMENT_ROOT"] . '/notifications/cargo_truck_' . $for_whom.'_'.$a->getId() . '.bin';
        $ok = true;

        try {
            if (Utils::$DEBUG) {
                $data = $a->serializeToJsonString();
            } else {
                $data = $a->serializeToString();
            }

            error_log("Data to be written: " . $data);
            file_put_contents($filename, $data);
        } catch (Exception $e) {
            error_log("Generic write error: " . $e->getMessage());

            return false;
        }

        return $ok;
    }

    public static function readTruck(int $id): ?TruckUpdates
    {
        $for_whom = $_SESSION['role'] ?? 'unknown';
        $filename = $_SERVER["DOCUMENT_ROOT"] . '/notifications/cargo_truck_' . $for_whom.'_'.$id . '.bin';
        $a = new TruckUpdates();

        try {
            if (!is_file($filename)) {
                error_log("File not found: " . $filename . ". Returning an empty object.");
                return $a;
            }

            $data = file_get_contents($filename);
            error_log("Data read: " . $data);

            if (Utils::$DEBUG) {
                $a->mergeFromJsonString($data);
            } else {
                $a->mergeFromString($data);
            }
        } catch (Exception $e) {
            error_log("Generic read error: " . $e->getMessage());

            return null;
        }

        $a->setId($id);

        return $a;
    }
}
