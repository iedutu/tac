<?php

if(!isset($_SESSION['app'])) {
    $_SESSION['app'] = 'cargo';
}

switch($_SESSION['app']) {
    case 'cargo': {
        echo '<link href="/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />';
        break;
    }
    case 'trucks': {
        echo '<link href="/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />"></script>';
        break;
    }
    default: {
        break;
    }
}