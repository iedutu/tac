<?php

if(!isset($_SESSION['app'])) {
    $_SESSION['app'] = 'cargo';
}

switch($_SESSION['app']) {
    case 'cargo': {
        echo '<script src="/assets/js/data-cargos-ajax.js"></script>';

        break;
    }
    case 'trucks': {
        echo '<script src="/assets/js/data-trucks-ajax.js"></script>';

        break;
    }
    case 'matches': {
        echo '<script src="/assets/js/data-matches-ajax.js"></script>';

        break;
    }
    case 'newTruck': {
        echo '<script src="/assets/js/datepicker-truck.js"></script>';
        echo '<script src="/assets/js/form-validation-truck.js"></script>';
        echo '<script src="/assets/js/form-repeater-truck.js"></script>';

        break;
    }
    case 'newCargo': {
        echo '<script src="/assets/js/datepicker-cargo.js"></script>';
        echo '<script src="/assets/js/form-validation-cargo.js"></script>';

        break;
    }
    case 'cargoInfo': {
//        echo '<script src="/assets/js/src/jquery.jeditable.js"></script>';
        echo '<script src="/assets/js/jeditable/jquery.jeditable.min.js"></script>';
        echo '<script src="/assets/js/src/jquery.jeditable.datepicker.js"></script>';
        echo '<script src="/assets/js/jeditable-cargo.js"></script>';
        echo '<script src="/assets/js/data-cargo-comments.js"></script>';
        echo '<script src="/assets/js/form-validation-cargo-note.js"></script>';

        break;
    }
    case 'truckInfo': {
        echo '<script src="/assets/js/jeditable/jquery.jeditable.min.js"></script>';
        echo '<script src="/assets/js/src/jquery.jeditable.datepicker.js"></script>';
        echo '<script src="/assets/js/jeditable-truck.js"></script>';
        if(isset($_SESSION['originator'])) {
            echo '<script src="/assets/js/data-truck-stops-ajax.js"></script>';
            echo '<script src="/assets/js/form-validation-truck_stop.js"></script>';
        }
        else {
            echo '<script src="/assets/js/data-truck-stops-ajax-read-only.js"></script>';
        }

        break;
    }
    case 'reports': {
        echo '<script src="/assets/js/datepicker-reports.js"></script>';
        echo '<script src="/assets/js/form-validation-reports.js"></script>';

        break;
    }
    case 'empty': {

        break;
    }
    default: {
        break;
    }
}