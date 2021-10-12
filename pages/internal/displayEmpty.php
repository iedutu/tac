<?php
    $a = new \Rohel\RequestUpdates();
    error_log('Object initialized.');
    $id = 3;
    $a->setId($id);

    error_log('Status (a): '.$a->getStatus());
    if(!Audit::writeCargo($a)) {
        error_log('Cannot write the file.');
    }

    $b = Audit::readCargo($id);
    if(is_null($b)) {
        error_log('Cannot read the file.');
        return;
    }

    $b->setStatus(false);
    $b->setWeight(false);

    error_log('Status (b): '.$b->getStatus());
    Audit::writeCargo($b);

    $c = Audit::readCargo($id);
    error_log('Status (c): '.$c->getStatus());