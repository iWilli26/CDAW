<?php
	require_once("initPDO.php");
	require_once("createUserTable.php");

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// User class
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	class User
	{
		// added by PDO
		// private $id;
		// private $name;
		// private $email;

		public static function getAllUsers() {
			global $pdo;	// we will improve this later
			$request = $pdo->prepare("select * from users");
			if (!$request) {
				var_dump(debug_backtrace());
				die('Error while doing request ' . $sqlRequest);
			}
			// $request->setFetchMode(PDO::FETCH_CLASS,'User');
			$request->setFetchMode(PDO::FETCH_CLASS,get_called_class());
			$request->execute();
			$allUsers = $request->fetchAll();

			return $allUsers;
		}

		// instance-side method to render a User object to HTML
		public function toHtml() {
			echo "<tr>"
				. "<td>". $this->id . "</td>"
				. "<td>". $this->name . "</td>"
				. "<td>" . $this->email . "</td></tr>";
		}

		// class-side method to render an array of users as an HTML table
		public static function showUsersAsTable($users) {
			echo '<table><thead>
					<tr><th>Id</th><th>Nom</th><th>Email</th></tr></thead><tbody>';
			foreach($users as $u) {
				$u->toHtml();
				// print_r($u);
			}
			echo '</tbody></table>';
		}

		public static function showAllUsersAsTable() {
			static::showUsersAsTable(static::getAllUsers());
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<style>
		table {
			border-top: 1px solid black;
			border-bottom: 1px solid black;
		}

		td {
			text-align: center;
			padding-left: 2em;
			padding-right: 2em;
		}
		</style>
	</head>
	<body>
		<h1>Users</h1>
		<?php
			User::showAllUsersAsTable();
		?>
	</body>
</html>

