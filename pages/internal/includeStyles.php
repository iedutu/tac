<?php

if(empty($_SESSION['app'])) {
    $_SESSION['app'] = 'cargo';
}

switch($_SESSION['app']) {
    case 'cargo': {
        break;
    }
    case 'trucks': {
        break;
    }
    default: {
        break;
    }
}