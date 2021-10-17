<?php

if(!isset($_SESSION['app'])) {
    $_SESSION['app'] = 'cargo';
}

switch($_SESSION['app']) {
    case 'cargo':
    {
        echo '<title>ROHEL | Cargo</title>';
        break;
    }
    case 'newCargo':
    {
        echo '<title>ROHEL | Cargo | New</title>';
        break;
    }
    case 'cargoInfo':
    {
        echo '<title>ROHEL | Cargo | Details</title>';
        break;
    }
    case 'trucks':
    {
        echo '<title>ROHEL | Trucks</title>';
        break;
    }
    case 'matches':
    {
        echo '<title>ROHEL | Matches</title>';
        break;
    }
    case 'newTruck':
    {
        echo '<title>ROHEL | Trucks | New</title>';
        break;
    }
    case 'truckInfo':
    {
        echo '<title>ROHEL | Trucks | Details</title>';
        break;
    }
    default: {
        echo '<title>ROHEL</title>';
        break;
    }
}