<?php
session_start();

// Check if the doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php"); // Redirect to login if not authenticated
    exit();
}

$doctor_name = $_SESSION['doctor_name']; // Get doctor name from session
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
            background: url("img11.jpg") no-repeat center center fixed; 
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
            width: 450px; /* Increased width for horizontal buttons */
            height: 250px; /* Adjusted height for additional content */
            background: rgba(255, 255, 255, 0.3); 
            padding: 50px; 
            border-radius: 10px; 
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2); 
            backdrop-filter: blur(15px);
            background: rgba(0, 0, 0, 0.3); 
            text-align: center;
			transform: translateX(-100px);
			
        }

        h2 { 
            text-align: center; 
            color: yellow; 
        }

        p { 
            font-size: 18px; 
            color: white; 
        }

        .btn-container { 
            display: flex; 
            flex-direction: row; /* Changed to horizontal layout */
            justify-content: space-between; /* Added spacing between buttons */
            align-items: center;
            gap: 15px; /* Added spacing between buttons */
        }

        .btn { 
            width: 100px; /* Reduced width to fit horizontally */
            padding: 12px; 
            margin: 5px 0;  
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            font-weight: bold; 
            text-align: center;
            text-decoration: none;
            display: block;
        }

        .btn-green { 
            background-color: green; 
            color: white; 
        }

        .btn-green:hover { 
            background-color: darkgreen; 
        }

        .btn-blue { 
            background-color: blue; 
            color: white; 
        }

        .btn-blue:hover { 
            background-color: darkblue; 
        }

        .btn-red { 
            background-color: red; 
            color: white; 
        }

        .btn-red:hover { 
            background-color: darkred; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, Dr. <?= htmlspecialchars($doctor_name); ?>!</h2>
        <p>You have successfully logged in.</p>
        <br><br><br>
        <div class="btn-container">
            <a href="view_appointments.php" class="btn btn-green">View Appointments</a>
            <a href="view_patient.php" class="btn btn-blue">Manage Patients</a>
            <a href="profile.php" class="btn btn-green">Profile Settings</a>
            <a href="firstpage.html" class="btn btn-red">Logout</a>
        </div>
    </div>
</body>
</html>
