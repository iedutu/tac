<?php
    $a = new \Rohel\RequestUpdates();
    error_log('Object initialized.');
    $id = 3;
    $a->setId($id);
    $a->setStatus(true);

    error_log('Status (a): '.$a->getStatus());
    if(!Audit::writeCargo($a)) {
        error_log('Cannot write the file.');
    }

    $b = Audit::readCargo($id);
    if(is_null($b)) {
        error_log('Cannot read the file.');
        return;
    }

    $b->setStatus(true);
    $b->setWeight(true);

    error_log('Status (b): '.$b->getStatus());
    Audit::writeCargo($b);

    $c = Audit::readCargo($id);
    error_log('Status (c): '.$c->getStatus());

    if($c->getPlateNumber()) {
        error_log('Plate number is OK ');
    }