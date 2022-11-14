<?php
	require_once('config.php');

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Connect to Database and create User table
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	$connectionString = "mysql:host=". DB_HOST;

	if(defined('DB_PORT'))
		$connectionString .= ";port=". DB_PORT;

	$connectionString .= ";dbname=" . DB_DATABASE;
	$connectionString .= ";charset=utf8";			// MySql database uses for example utf8_unicode_ci

	// ================================================================================
	// Debug utilities
	// ================================================================================

	$options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		);
	try {
		$pdo = new PDO($connectionString,DB_USERNAME,DB_PASSWORD,$options);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $erreur) {
			myLog('Erreur : '.$erreur->getMessage());
			exit(-1);
	}
