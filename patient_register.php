<?php
include 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $second_name = $_POST['second_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Check if user already exists
    $checkQuery = $conn->prepare("SELECT * FROM patient WHERE phone = ?");
    $checkQuery->bind_param("s", $phone);
    $checkQuery->execute();
    $result = $checkQuery->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Phone number already registered!'); window.location.href='patient_login.php';</script>";
    } else {
        // Insert new patient
        $stmt = $conn->prepare("INSERT INTO patient (first_name, second_name, dob, gender, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $first_name, $second_name, $dob, $gender, $phone, $address);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Please log in.'); window.location.href='patient_login.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration</title>
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
			transform: translateX(150px);
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

        input, textarea { 
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

        .login { 
            background-color: blue; 
            color: white; 
            text-decoration: none; 
            display: inline-block; 
            padding: 10px; 
            border-radius: 5px; 
            cursor: pointer; 
            font-weight: bold; 
        }

        .login:hover { 
            background-color: darkblue; 
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

        /* Styling for Gender field */
        .gender-label { 
            font-weight: bold; 
            margin-top: 20px; 
            display: block; 
            margin-bottom: 10px; 
            color: black;
        }

        .gender-options {
            display: flex; 
            justify-content: space-around; 
        }

        .gender-options label {
            display: flex;
            align-items: center;
            font-size: 16px;
            cursor: pointer;
            color: black;
        }

        .gender-options input[type="radio"] {
            margin-right: 8px;
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .gender-options input[type="radio"]:checked + span {
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Patient Registration</h2>
        <form method="POST">
            <label>First Name:</label>
            <input type="text" name="first_name" required>

            <label>Second Name:</label>
            <input type="text" name="second_name">

            <label>Date of Birth:</label>
            <input type="date" name="dob" required>

            <!-- Gender Field -->
            <div class="gender-label">Gender:</div>
            <div class="gender-options">
                <label>
                    <input type="radio" name="gender" value="Male" required>
                    <span>Male</span>
                </label>
                <label>
                    <input type="radio" name="gender" value="Female" required>
                    <span>Female</span>
                </label>
            </div>

            <label>Phone Number:</label>
            <input type="tel" name="phone" required>

            <label>Address:</label>
            <textarea name="address"></textarea>

            <div class="btn-container">
                <button type="submit" class="submit">Register</button>
                <button type="reset" class="cancel">Cancel</button>
            </div>
        </form>

        <div class="account-info">
            <p>Already have an account? <a href="patient_login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
