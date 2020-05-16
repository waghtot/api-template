<?php
error_log('incomming data: '.file_get_contents('php://input'));
ini_set('error_reporting', E_STRICT);
require_once('app/core/Constants.php');
require_once('vendor/autoload.php');

new ScurityCheck();

new Master();
ob_flush();
