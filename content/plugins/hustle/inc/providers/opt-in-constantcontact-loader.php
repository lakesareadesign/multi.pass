<?php

if ( version_compare( PHP_VERSION, '5.3', '>=' ) ) {
    require_once( dirname( __FILE__ ) . '/../../vendor/Ctct/autoload.php' );
    require_once "opt-in-constantcontact.php";
}