<?php
session_start();
if ( ! isset( $_SESSION['username'] ) ) {
	header( 'Location: index.html' );
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Welcome</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
	<div class="row justify-content-center mt-5">
		<div class="col-md-6">
			<h2>Welcome, <?php echo htmlspecialchars( $_SESSION['name'] ); ?></h2>
			<a href="./forms/add_patient.php" class="btn btn-primary">Add Patient</a>&nbsp;<a href="./list_patients.php" class="btn btn-primary">My Patients</a>&nbsp;<a href="./user/logout.php" class="btn btn-danger">Logout</a>
		</div>
	</div>
</div>
</body>
</html>
