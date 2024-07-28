<?php
session_start();
if ( ! isset( $_SESSION['username'] ) ) {
	header( 'Location: index.php' );
	exit();
}

// Database connection
try {
	$pdo = new PDO( 'mysql:host=localhost;dbname=clinics', 'root', '' );
	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

	// Fetch current user ID
	$stmt = $pdo->prepare( 'SELECT ID FROM users WHERE username = :username' );
	$stmt->execute( array( 'username' => $_SESSION['username'] ) );
	$currentUser = $stmt->fetch( PDO::FETCH_ASSOC );

	if ( ! $currentUser ) {
		echo 'Error: User not found.';
		exit();
	}

	$doctor_id = $currentUser['ID'];
} catch ( PDOException $e ) {
	echo 'Error: ' . $e->getMessage();
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Add Patient</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
	<div class="row justify-content-center mt-5">
		<div class="col-md-8">
			<h2>Add Patient</h2>
			<form action="../../add_patient_process.php" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">
				<div class="form-group">
					<label for="phone">Phone</label>
					<input type="text" class="form-control" id="phone" name="phone" required>
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" id="email" name="email" required>
				</div>
				<div class="form-group">
					<label for="address">Address</label>
					<input type="text" class="form-control" id="address" name="address" required>
				</div>
				<div class="form-group">
					<label for="house_number">House Number</label>
					<input type="text" class="form-control" id="house_number" name="house_number" required>
				</div>
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" class="form-control" id="name" name="name" required>
				</div>
				<div class="form-group">
					<label for="stage">Stage</label>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="stage" id="stage1" value="1" required>
						<label class="form-check-label" for="stage1">1</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="stage" id="stage2" value="2" required>
						<label class="form-check-label" for="stage2">2</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="stage" id="stage3" value="3" required>
						<label class="form-check-label" for="stage3">3</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="stage" id="stage4" value="4" required>
						<label class="form-check-label" for="stage4">4</label>
					</div>
				</div>
				<div class="form-group">
					<label for="diagnose">Diagnose</label>
					<input type="text" class="form-control" id="diagnose" name="diagnose" required>
				</div>
				<div class="form-group">
					<label for="details">Details</label>
					<textarea class="form-control" id="details" name="details" required></textarea>
				</div>
				<div class="form-group">
					<label for="prescription">Prescription</label>
					<input type="file" class="form-control" id="prescription" name="prescription" required>
				</div>
				<button type="submit" class="btn btn-primary">Add Patient</button>
			</form>
		</div>
	</div>
</div>
</body>
</html>
