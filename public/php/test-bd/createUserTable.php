<?php

// returns true if $tableName exists
function tableExists($dbh, $tableName)
{
	$result = $dbh->query("SHOW TABLES LIKE '$tableName'");
	return ($result !== false && $result->rowCount() > 0);
}

	try {

		if(!tableExists($pdo,'users')) {
			$pdo->exec("CREATE TABLE IF NOT EXISTS users (id INT not null AUTO_INCREMENT, name VARCHAR(30), email VARCHAR(30), primary key (id))");

			$pdo->exec("DELETE FROM users");
			$pdo->exec("INSERT INTO users (name,email) VALUES('riri', 'riri@disney.com')");
			$pdo->exec("INSERT INTO users (name,email) VALUES('fifi', 'fifi@disney.com')");
			$pdo->exec("INSERT INTO users (name,email) VALUES('loulou', 'loulou@disney.com')");
		}
	}
	catch (PDOException $erreur) {
		myLog('Erreur : '.$erreur->getMessage());
	}

?>


