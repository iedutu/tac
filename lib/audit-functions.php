<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/GPBMetadata/Types.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/Request.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/Truck.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/RequestUpdates.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/datatypes/Rohel/TruckUpdates.php";

use Google\Protobuf\Internal\GPBDecodeException;
use PHPMailer\PHPMailer\PHPMailer;
use Rohel\Request;
use Rohel\Truck;
use Rohel\RequestUpdates;
use Rohel\TruckUpdates;

class Audit {
    public static function writeCargo(RequestUpdates $a): bool
    {
        $filename = $_SERVER["DOCUMENT_ROOT"].'/notifications/cargo_request_'.$a->getId().'.bin';
        $ok = true;

        try {
            if($file = fopen($filename, "w") == false) {
                error_log("Filesystem write error. Filename: ".$filename);

                return false;
            }

            if(Utils::$DEBUG) {
                $ok = $a->serializeToJsonStream($file);
            }
            else {
                $ok = $a->serializeToStream($file);
            }
        }
        catch(Exception $e) {
            error_log("Generic write error: ".$e->getMessage());

            return false;
        }

        return $ok;
    }

    public static function readCargo(int $id): ?RequestUpdates
    {
        $filename = $_SERVER["DOCUMENT_ROOT"].'/notifications/cargo_request_'.$id.'.bin';

        try {
            if($file = fopen($filename, "r") == false) {
                return null;
            }

            $a = new RequestUpdates();

            if(Utils::$DEBUG) {
                $a->parseFromJsonStream($file, false);
            }
            else {
                $a->parseFromStream($file);
            }
        }
        catch(Exception $e) {
            error_log("Generic read error: ".$e->getMessage());

            return null;
        }

        $a->setId($id);

        return $a;
    }

    public static function writeTruck(TruckUpdates $a): bool
    {
        $filename = $_SERVER["DOCUMENT_ROOT"].'/notifications/cargo_truck_'.$a->getId().'.bin';
        $ok = true;

        try {
            if ($file = fopen($filename, "w") == false) {
                return false;
            }

            if (Utils::$DEBUG) {
                $ok = $a->serializeToJsonStream($file);
            } else {
                $ok = $a->serializeToStream($file);
            }
        }
        catch(Exception $e) {
            error_log("Generic write error: ".$e->getMessage());

            return false;
        }

        return $ok;
    }

    public static function readTruck(int $id): ?TruckUpdates
    {
        $filename = $_SERVER["DOCUMENT_ROOT"].'/notifications/truck_request_'.$id.'.bin';

        try {
            if ($file = fopen($filename, "r") == false) {
                return null;
            }

            $a = new TruckUpdates();

            if (Utils::$DEBUG) {
                $a->parseFromJsonStream($file, false);
            } else {
                $a->parseFromStream($file);
            }
        }
        catch(GPBDecodeException $e) {
            error_log("Truck updates read/parse error: ".$e->getMessage());

            return null;
        }
        catch(Exception $e) {
            error_log("Generic error: ".$e->getMessage());

            return null;
        }

        return $a;
    }
}
