<?php
switch($_SESSION['app']) {
    case 'cargo': {
        include 'pages/displayCargos.php';
        break;
    }
    case 'trucks': {
        include 'pages/displayTrucks.php';
        break;
    }
    case 'matches': {
        include 'pages/displayMatches.php';
        break;
    }
    case 'newCargo': {
        include 'pages/newCargo.php';
        break;
    }
    case 'newTruck': {
        include 'pages/newTruck.php';
        break;
    }
    case 'cargoInfo': {
        include 'pages/cargoInfo.php';
        break;
    }
    case 'truckInfo': {
        include 'pages/truckInfo.php';
        break;
    }
    case 'empty': {
        include 'pages/internal/displayEmpty.php';
        break;
    }
    case 'reports': {
        include 'pages/exportData.php';
        break;
    }
    case 'help': {
        include 'pages/displayHelp.php';
        break;
    }
    default: {
        break;
    }
}