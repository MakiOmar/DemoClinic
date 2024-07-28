<?php
session_start();
require 'UserController.php';

try {
	$pdo = new PDO( 'mysql:host=localhost;dbname=clinics', 'root', '' );
	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$userController = new UserController( $pdo );

	if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		$username = $_POST['username'];
		$name     = $_POST['name'];
		$email    = $_POST['email'];
		$password = $_POST['password'];
		$password = $_POST['password'];
		$role     = 'doctor';

		if ( $userController->createUser( $username, $name, $email, $password, $role ) ) {
			$_SESSION['username'] = $username;
			$_SESSION['name']     = $name;
			header( 'Location: ../views/welcome.php' );
		} else {
			echo 'Error: Could not register user.';
		}
	}
} catch ( PDOException $e ) {
	echo 'Error: ' . $e->getMessage();
}
