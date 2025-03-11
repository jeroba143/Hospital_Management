<?php
session_start();

// Check if the patient is logged in
if (!isset($_SESSION['first_name'])) {
    header("Location: login.php");
    exit();
}

$first_name = $_SESSION['first_name']; // Get logged-in patient's name

// Database connection
include 'db.php';

// Fetch appointments for the logged-in patient
$stmt = $conn->prepare("SELECT * FROM appointments WHERE patient_name = ?");
$stmt->bind_param("s", $first_name);
$stmt->execute();
$result = $stmt->get_result();

$appointments = [];
while ($appointment = $result->fetch_assoc()) {
    $doctorId = $appointment['doctor'];
    $doctorStmt = $conn->prepare("SELECT name FROM doctors WHERE id = ?");
    $doctorStmt->bind_param("i", $doctorId);
    $doctorStmt->execute();
    $doctorResult = $doctorStmt->get_result();
    $doctor = $doctorResult->fetch_assoc();
    
    $appointment['doctor_name'] = $doctor['name'];
    $appointments[] = $appointment;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
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
            width: 1000px; /* Increased size */
            background: rgba(255, 255, 255, 0.3);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(15px);
            background: rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        h2 {
            color: yellow;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(5px);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
            color: black;
        }

        th {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
        }

        /* Status Colors */
        .pending { background-color: yellow; color: black; }
        .accepted { background-color: lightgreen; color: black; }
        .rejected { background-color: lightcoral; color: black; }

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
        <h2>Your Bookings, <?php echo htmlspecialchars($first_name); ?>!</h2>

        <?php if (count($appointments) > 0): ?>
            <table>
                <tr>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
                <?php foreach ($appointments as $appointment): 
                    $status = strtolower(htmlspecialchars($appointment['status']));
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                        <td class="<?php echo $status; ?>"><?php echo ucfirst($status); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p style="color:white;">You don't have any bookings yet.</p>
        <?php endif; ?>

        <a href="dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>
