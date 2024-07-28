<?php
session_start();
try {
	$pdo = new PDO( 'mysql:host=localhost;dbname=clinics', 'root', '' );
	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

	if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		$username = $_POST['username'];
		$password = $_POST['password'];

		$stmt = $pdo->prepare( 'SELECT * FROM users WHERE username = :username' );
		$stmt->execute( array( 'username' => $username ) );
		$user = $stmt->fetch( PDO::FETCH_ASSOC );

		if ( $user && password_verify( $password, $user['password'] ) ) {
			$_SESSION['username'] = $username;
			$_SESSION['name']     = $user['name'];
			header( 'Location: ../welcome.php' );
		} else {
			echo 'Invalid credentials';
			echo '<a class="btn btn-primary" href="./index.php">العودة للصفحة الرئيسية</a>';
		}
	}
} catch ( PDOException $e ) {
	echo 'Error: ' . $e->getMessage();
}
