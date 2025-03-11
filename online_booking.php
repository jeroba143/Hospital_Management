<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['first_name'])) {
    header("Location: dashboard.php");
    exit();
}

$first_name = $_SESSION['first_name'];

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

// Fetch doctors' names
$stmt = $pdo->prepare("SELECT id, name FROM doctors");
$stmt->execute();
$doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $doctorId = $_POST['doctor'];
    $appointmentDate = $_POST['appointmentDate'];
    $appointmentTime = $_POST['appointmentTime'];

    try {
        $stmt = $pdo->prepare("INSERT INTO appointments (patient_name, email, doctor, appointment_date, appointment_time, status) 
                               VALUES (:patient_name, :email, :doctor, :appointment_date, :appointment_time, 'pending')");
        $stmt->execute([
            ':patient_name' => $first_name,
            ':email' => $email,
            ':doctor' => $doctorId,
            ':appointment_date' => $appointmentDate,
            ':appointment_time' => $appointmentTime
        ]);

        $appointmentId = $pdo->lastInsertId();
        header("Location: appointment_success.php?id=$appointmentId");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Appointment</title>
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background: url("img12.jpg") no-repeat center center fixed; 
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
            padding: 40px;
            background: rgba(0, 0, 0, 0.3); 
            backdrop-filter: blur(2px);
            border-radius: 10px; 
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2); 
            text-align: center;
            color: white;
        }

        h1 { 
            color: yellow; 
        }

        label { 
            font-weight: bold; 
            display: block; 
            margin-top: 10px; 
            text-align: left;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: none;
            border-radius: 5px;
        }

        .btn-container {
            display: flex; 
            flex-direction: column;
            align-items: center;
            gap: 15px;
            margin-top: 15px;
        }

        .btn {
            width: 100%; 
            padding: 12px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            font-weight: bold; 
            text-align: center;
            text-decoration: none;
            display: block;
        }

        .btn-green { background-color: green; color: white; }
        .btn-green:hover { background-color: darkgreen; }

        .btn-blue { background-color: blue; color: white; }
        .btn-blue:hover { background-color: darkblue; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Book an Appointment</h1>
        <form method="POST">
            <label for="patientName">Patient Name:</label>
            <input type="text" name="patientName" value="<?php echo htmlspecialchars($first_name); ?>" readonly required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="doctor">Select Doctor:</label>
            <select name="doctor" required>
                <?php foreach ($doctors as $doctor): ?>
                    <option value="<?php echo $doctor['id']; ?>"><?php echo htmlspecialchars($doctor['name']); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="appointmentDate">Appointment Date:</label>
            <input type="date" name="appointmentDate" required>

            <label for="appointmentTime">Appointment Time:</label>
            <select name="appointmentTime" required>
                <option value="9:00am">9:00 AM</option>
                <option value="10:00am">10:00 AM</option>
                <option value="11:00am">11:00 AM</option>
                <option value="1:00pm">1:00 PM</option>
                <option value="2:00pm">2:00 PM</option>
            </select>

            <div class="btn-container">
                <button type="submit" class="btn btn-green">Book Appointment</button>
                <a href="dashboard.php" class="btn btn-blue">Back to Dashboard</a>
            </div>
        </form>
    </div>
</body>
</html>
