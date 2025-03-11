<?php
// Database connection
$servername = "localhost"; // Change this if needed
$username = "root";
$password = "";
$database = "hospital_management";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch records from the appointments table
$sql = "SELECT * FROM appointments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Appointments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url("img13.jpg") no-repeat center center fixed; 
            text-align: center;
            margin: 20px;
        }

        h2 {
            color: red;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Appointments List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Email</th>
                <th>Doctor</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Created At</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr onclick="showDetails('<?php echo $row['patient_name']; ?>', '<?php echo $row['doctor']; ?>', '<?php echo $row['appointment_date']; ?>')">
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['patient_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['doctor']; ?></td>
                        <td><?php echo $row['appointment_date']; ?></td>
                        <td><?php echo $row['appointment_time']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8">No appointments found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        function showDetails(patient, doctor, date) {
            alert("Appointment Details:\nPatient: " + patient + "\nDoctor: " + doctor + "\nDate: " + date);
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
