<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=clinics', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch current user ID
    $stmt = $pdo->prepare("SELECT ID FROM users WHERE username = :username");
    $stmt->execute(['username' => $_SESSION['username']]);
    $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$currentUser) {
        echo 'Error: User not found.';
        exit();
    }

    $doctor_id = $currentUser['ID'];

    // Fetch patients' details
    $stmt = $pdo->prepare("
        SELECT pdr.patient_id, pdr.stage, pdr.diagnose, pdr.details, pdr.prescription, u.phone, u.email, u.address, u.house_number, u.name
        FROM patient_doctor_rel pdr
        JOIN users u ON pdr.patient_id = u.ID
        WHERE pdr.doctor_id = :doctor_id
    ");
    $stmt->execute(['doctor_id' => $doctor_id]);
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Patients</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <h2>Doctor's Patients</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>House Number</th>
                        <th>Stage</th>
                        <th>Diagnose</th>
                        <th>Details</th>
                        <th>Prescription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patients as $patient): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($patient['name']); ?></td>
                            <td><?php echo htmlspecialchars($patient['phone']); ?></td>
                            <td><?php echo htmlspecialchars($patient['email']); ?></td>
                            <td><?php echo htmlspecialchars($patient['address']); ?></td>
                            <td><?php echo htmlspecialchars($patient['house_number']); ?></td>
                            <td><?php echo htmlspecialchars($patient['stage']); ?></td>
                            <td><?php echo htmlspecialchars($patient['diagnose']); ?></td>
                            <td><?php echo htmlspecialchars($patient['details']); ?></td>
                            <td><a href="<?php echo htmlspecialchars($patient['prescription']); ?>" target="_blank">View Prescription</a></td>
                            <td><a href="./forms/edit_patient.php?id=<?php echo htmlspecialchars( $patient['patient_id'] ); ?>" target="_blank">Edit</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>