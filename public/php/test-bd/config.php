<?php

// define('DB_HOST','127.0.0.1');
// define('DB_PORT',5306);

define('DB_HOST','mysql');
define('DB_PORT',3306);

define('DB_DATABASE','test');
define('DB_USERNAME','mysql');
define('DB_PASSWORD','mysql');

// define('__DEBUG', false);
define('__DEBUG', true);


// ================================================================================
// Debug utilities
// ================================================================================

if(__DEBUG) {
	error_reporting(E_ALL);
	ini_set("display_errors", E_ALL);
} else {
	error_reporting(0);
	ini_set("display_errors", 0);
}

function myLog($msg) {
	if(__DEBUG) {
		echo $msg;
	}
}

function myDump($var) {
	if(__DEBUG) {
		var_dump($var);
	}
}