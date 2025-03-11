<?php
session_start();

// Check if appointment ID is in URL
if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$appointmentId = $_GET['id'];

// Database connection
$dsn = 'mysql:host=localhost;dbname=hospital_management';
$username = 'root';
$password = '';
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch appointment details
$query = "SELECT appointments.*, doctors.name AS doctor_name 
          FROM appointments 
          JOIN doctors ON appointments.doctor = doctors.id 
          WHERE appointments.id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $appointmentId);
$stmt->execute();
$appointment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$appointment) {
    die("Appointment not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: auto;
        }
        h2 {
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Appointment Confirmed!</h2>
        <p><strong>Patient Name:</strong> <?php echo htmlspecialchars($appointment['patient_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($appointment['email']); ?></p>
        <p><strong>Doctor:</strong> <?php echo htmlspecialchars($appointment['doctor_name']); ?></p>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($appointment['appointment_date']); ?></p>
        <p><strong>Time:</strong> <?php echo htmlspecialchars($appointment['appointment_time']); ?></p>
        <p><strong>Status:</strong> <span style="color: <?php echo ($appointment['status'] == 'confirmed') ? 'green' : 'orange'; ?>">
            <?php echo htmlspecialchars($appointment['status']); ?>
        </span></p>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
