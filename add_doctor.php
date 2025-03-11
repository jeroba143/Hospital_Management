<?php
include 'db.php'; // Include database connection

session_start(); // Start session to store user data
$successMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $specialization = $_POST['specialization'];
    $experience = $_POST['experience'];

    // Prepare and bind the SQL query
    $stmt = $conn->prepare("INSERT INTO doctors (name, email, phone, specialization, experience) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $name, $email, $phone, $specialization, $experience);

    // Execute the query
    if ($stmt->execute()) {
        $successMessage = "New doctor registered successfully!";
    } else {
        $successMessage = "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register New Doctor</title>
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background: url("img5.jpg") no-repeat center center fixed; 
            background-size: cover;
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0;
            position: relative;
        }

        /* Background blur effect */
        body::before {
            content: ""; 
            position: absolute; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            background: rgba(0, 0, 0, 0.3); /* Dark overlay */
            backdrop-filter: blur(2px); /* Blur effect */
            z-index: -1;
        }

        .container { 
            width: 400px; 
            background: rgba(255, 255, 255, 0.3); /* Semi-transparent background */
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2); 
            backdrop-filter: blur(15px); /* Additional blur on form */
            background: rgba(0, 0, 0, 0.3); 
            backdrop-filter: blur(2px);
        }

        h2 { 
            text-align: center; 
            color: yellow; 
        }

        label { 
            font-weight: bold; 
            display: block; 
            margin-top: 10px; 
            color: black;
        }

        input, select { 
            width: 100%; 
            padding: 8px; 
            margin: 5px 0; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
        }

        .btn-container { 
            display: flex; 
            justify-content: space-between; 
        }

        button { 
            width: 48%; 
            padding: 10px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            font-weight: bold; 
        }

        .submit { 
            background-color: green; 
            color: white; 
        }

        .submit:hover { 
            background-color: darkgreen; 
        }

        .cancel { 
            background-color: red; 
            color: white; 
        }

        .cancel:hover { 
            background-color: darkred; 
        }

        .account-info { 
            text-align: center; 
            font-size: 16px; 
            margin-top: 10px; 
            color: black; 
        }

        .account-info a { 
            color: blue; 
            text-decoration: none; 
            font-weight: bold; 
        }

        .account-info a:hover { 
            text-decoration: underline; 
        }

        #confirmationMessage {
            text-align: center;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 5px;
            margin-top: 20px;
            color: #4CAF50;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Register New Doctor</h2>
        <form method="POST">
            <label>Full Name:</label>
            <input type="text" name="name" placeholder="Enter full name" required>

            <label>Email:</label>
            <input type="email" name="email" placeholder="Enter doctor email" required>

            <label>Phone Number:</label>
            <input type="text" name="phone" placeholder="Enter phone number" required>

            <label>Specialization:</label>
            <select name="specialization" required>
                <option value="" disabled selected>Select Specialization</option>
                <option value="Cardiologist">Cardiologist</option>
                <option value="Dermatologist">Dermatologist</option>
                <option value="Neurologist">Neurologist</option>
                <option value="Orthopedic">Orthopedic</option>
                <option value="Pediatrician">Pediatrician</option>
            </select>

            <label>Experience (Years):</label>
            <input type="number" name="experience" placeholder="Enter years of experience" required>
			<br>
			<br>
            <div class="btn-container">
                <button type="submit" class="submit">Register Doctor</button>
                <button type="reset" class="cancel">Reset Fields</button>
            </div>
        </form>
			<br>
			<br>
        <?php if ($successMessage): ?>
            <div id="confirmationMessage">
                <h2><?php echo $successMessage; ?></h2>
            </div>
        <?php endif; ?>

        <a href="admin_dashboards.html"><button>Back to Admin Dashboard</button></a>
    </div>
</body>
</html>
