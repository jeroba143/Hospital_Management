<?php
include 'db.php'; // Include database connection

session_start(); // Start session to store user data

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("SELECT patient_id FROM patient WHERE first_name = ? AND phone = ?");
    $stmt->bind_param("ss", $first_name, $phone);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['first_name'] = $first_name; // Store name in session
        echo "<script>alert('Login successful!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Invalid credentials! Try again.'); window.location.href='patient_login.php';</script>";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Login</title>
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
			transform: translateX(250px);
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

        input { 
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Patient Login</h2>
        <form method="POST">
            <label>First Name:</label>
            <input type="text" name="first_name" required>

            <label>Phone Number:</label>
            <input type="tel" name="phone" required>

            <div class="btn-container">
                <button type="submit" class="submit">Login</button>
                <button type="reset" class="cancel">Cancel</button>
            </div>

            <div class="account-info">
                <p>Don't have an account? <a href="patient_register.php">Register here</a></p>
            </div>
        </form>
    </div>
</body>
</html>
