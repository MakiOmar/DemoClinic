<?php
session_start();
require './helpers.php';
require './controllers/userController.php';
require './controllers/pdrController.php';

try {
	$pdo = new PDO( 'mysql:host=localhost;dbname=clinics', 'root', '' );
	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$userController = new UserController( $pdo );
	$pdrController = new PdrController( $pdo );

	if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		// Insert patient into users table
		$username     = 'patient_' . uniqid(); // Generate a unique username
		$phone        = $_POST['phone'];
		$email        = $_POST['email'];
		$address      = $_POST['address'];
		$house_number = $_POST['house_number'];
		$name         = $_POST['name'];
		$password     = uniqid(); // Generate a unique password
		$role         = 'patient';
		$phone        = $_POST['phone'];
		$address      = $_POST['address'];
		$house_number = $_POST['house_number'];
		$patient_id= isset( $_POST['patient_id'] ) ? intval( $_POST['patient_id'] ) : false ;

		// Insert into patient_doctor_rel table
		$doctor_id = intval( $_POST['doctor_id'] );
		$stage     = $_POST['stage'];
		$diagnose  = $_POST['diagnose'];
		$details   = $_POST['details'];

		if ( ! $patient_id ) {
			$createUser = $userController->createUser( $username, $name, $email, $password, $role, $phone, $address, $house_number );
			if ( $createUser ) {
				$patient_id = $pdo->lastInsertId();
	
				$uploadFile = handle_uploads();
	
				if ( $uploadFile !== false ) {
					$pdrController->insertRel( $doctor_id, $patient_id, $stage, $diagnose, $details, $uploadFile );
	
					header( 'Location: ./views/success.php' );
					exit();
				} else {
					echo 'Error: File upload failed.';
				}
			} else {
				echo 'Error: Could not add patient.';
			}
		} else {
			$userController->updateUser( $patient_id, $name, $email, $phone, $house_number, $address );
			$uploadFile = handle_uploads();
			if ( $uploadFile !== false ) {
				var_dump();
				$pdrController->updateRel( $doctor_id, $patient_id, $stage, $diagnose, $details, $uploadFile );

				header( 'Location: ./views/forms/edit_patient.php?id=' . $patient_id );
				exit();
			} else {
				echo 'Error: File upload failed.';
			}
		}
	}
} catch ( PDOException $e ) {
	echo 'Error: ' . $e->getMessage();
}
