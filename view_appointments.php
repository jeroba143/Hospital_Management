<?php
session_start();

// Check if doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    die("Access Denied. Please log in as a doctor.");
}

$doctorId = $_SESSION['doctor_id']; // Doctor ID from session

// Database connection
$pdo = new PDO('mysql:host=localhost;dbname=hospital_management', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

// Fetch appointments only for the logged-in doctor
$stmt = $pdo->prepare("SELECT * FROM appointments WHERE doctor = :doctor_id");
$stmt->execute(['doctor_id' => $doctorId]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <style>
       body { 
            font-family: 'Poppins', sans-serif; 
            background: url("img13.jpg") no-repeat center center fixed; 
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
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            margin: auto;
			
        }
        h1 {
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        select {
            padding: 5px;
            font-size: 14px;
        }
        .btn-update {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }
        .btn-update:hover {
            background-color: #218838;
        }
        .btn-updated {
            background-color: #ffc107;
            color: black;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Appointments</h1>
    <table>
        <tr>
            <th>Patient</th>
            <th>Email</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($appointments as $appointment): ?>
            <tr>
                <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
                <td><?php echo htmlspecialchars($appointment['email']); ?></td>
                <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                <td>
                    <select class="status-select" data-id="<?php echo $appointment['id']; ?>">
                        <option value="pending" <?php echo ($appointment['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="accepted" <?php echo ($appointment['status'] == 'accepted') ? 'selected' : ''; ?>>Accepted</option>
                        <option value="rejected" <?php echo ($appointment['status'] == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                    </select>
                </td>
                <td>
                    <button class="btn-update" onclick="updateStatus(<?php echo $appointment['id']; ?>, this)">Update</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<script>
function updateStatus(appointmentId, buttonElement) {
    let status = document.querySelector(`.status-select[data-id='${appointmentId}']`).value;

    // Change button style to show the update is happening
    buttonElement.classList.add('btn-updated');
    buttonElement.innerText = 'Updating...';  // Change text to "Updating..." during the request

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Update successful, change button style and text
            buttonElement.classList.add('btn-updated');
            buttonElement.innerText = 'Updated';  // Optionally change button text to "Updated"
            
            alert("Status Updated Successfully!");
        }
    };

    xhr.send("id=" + appointmentId + "&status=" + status);
}
</script>

<?php
// Handle AJAX status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['status'])) {
    $appointmentId = $_POST['id'];
    $status = $_POST['status'];

    // Update status in the database
    $stmt = $pdo->prepare("UPDATE appointments SET status = :status WHERE id = :id AND doctor = :doctor_id");
    $stmt->execute(['status' => $status, 'id' => $appointmentId, 'doctor_id' => $doctorId]);

    exit("Success");
}
?>
</body>
</html>
