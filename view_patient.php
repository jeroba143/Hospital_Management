<?php
// Database connection
$servername = "localhost";  // Your database server
$username = "root";         // Your database username
$password = "";             // Your database password
$dbname = "hospital_management";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch patients data from the database
$sql = "SELECT patient_id, first_name, second_name, dob, gender, phone, address FROM patient";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients List</title>
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
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            margin: auto;
        }

        h1 {
            text-align: center;
            color: red;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Patients List</h1>

    <?php
    if ($result->num_rows > 0) {
        // Output data of each row
        echo "<table>";
        echo "<tr><th>ID</th><th>First Name</th><th>Second Name</th><th>Date of Birth</th><th>Gender</th><th>Phone</th><th>Address</th></tr>";
        
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["patient_id"] . "</td><td>" . $row["first_name"] . "</td><td>" . 
                 ($row["second_name"] ? $row["second_name"] : "N/A") . "</td><td>" . $row["dob"] . "</td><td>" . 
                 $row["gender"] . "</td><td>" . $row["phone"] . "</td><td>" . $row["address"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No patients found.";
    }
    ?>

</div>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>
