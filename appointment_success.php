<?php
session_start();

// Database connection
$dsn = 'mysql:host=localhost;dbname=hospital_management';
$username = 'root';
$password = '';
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$appointmentId = $_GET['id'];

// Fetch appointment details
$stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = :id");
$stmt->execute([':id' => $appointmentId]);
$appointment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$appointment) {
    die("Appointment not found.");
}

// Fetch doctor name
$stmt = $pdo->prepare("SELECT name FROM doctors WHERE id = :id");
$stmt->execute([':id' => $appointment['doctor']]);
$doctor = $stmt->fetch(PDO::FETCH_ASSOC);

$doctorName = $doctor['name'];
$email = $appointment['email'];
$status = $appointment['status'];

// Send Email Notification
$to = $email;
$subject = "Appointment Confirmation";
$message = "Dear " . $appointment['patient_name'] . ",\n\nYour appointment with Dr. $doctorName is confirmed.\nDate: " . $appointment['appointment_date'] . "\nTime: " . $appointment['appointment_time'] . "\nStatus: $status.\n\nThank you!";
$headers = "From: hospital@example.com";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: url("img14.jpg") no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(2px);
            z-index: -1;
        }

        .container {
            width: 400px;
            background: rgba(255, 255, 255, 0.3);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(15px);
            background: rgba(0, 0, 0, 0.3);
            text-align: center;
			color:white;
			
        }

        h2 {
            color: yellow;
            margin-bottom: 20px;
        }

        .status {
            font-weight: bold;
            padding: 8px;
            border-radius: 5px;
            display: inline-block;
        }

        .status.pending {
            background-color: #ffc107;
            color: #fff;
        }

        .status.confirmed {
            background-color: #28a745;
            color: #fff;
        }

        .status.cancelled {
            background-color: #dc3545;
            color: #fff;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            background: blue;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn:hover {
            background: darkblue;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Appointment Confirmed!</h2>
        <p><strong style=color:black>Patient:</strong> <?php echo htmlspecialchars($appointment['patient_name']); ?></p>
        <p><strong style=color:black>Doctor:</strong> <?php echo htmlspecialchars($doctorName); ?></p>
        <p><strong style=color:black>Date:</strong> <?php echo htmlspecialchars($appointment['appointment_date']); ?></p>
        <p><strong style=color:black>Time:</strong> <?php echo htmlspecialchars($appointment['appointment_time']); ?></p>
        <p><strong style=color:black>Status:</strong> 
            <span class="status <?php echo htmlspecialchars($status); ?>">
                <?php echo ucfirst(htmlspecialchars($status)); ?>
            </span>
        </p>
        <a href="dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>
