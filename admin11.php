<?php
include 'db.php'; // Include database connection

session_start(); // Start session to store user data

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $firstName = $_POST['first_name'];
    $phone = $_POST['phone'];

    // SQL query to check if the admin details exist in the database
    $sql = "SELECT * FROM admins WHERE first_name = ? AND phone = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $firstName, $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the admin exists
    if ($result->num_rows > 0) {
        // Admin found, redirect to the admin dashboard (or another page)
        header("Location: admin_dashboards.html");
        exit();
    } else {
        // Admin not found, show an error message
        $error = "Invalid login credentials. Please try again.";
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
    <title>🚀 Admin Login - Hospital Management</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url("img8.jpg") no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Background blur effect */
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
            width: 350px;
            height: 360px;
            background: url("img7.jpg") no-repeat center center;
            background-size: cover;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            background: rgba(0, 0, 0, 0.3); 
            backdrop-filter: blur(2px);
            color: white;
            transform: translateX(-300px); /* Moves the container 10px to the left */
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

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Admin Login</h2>
        <form method="POST">
            <label>First Name:</label>
            <input type="text" name="first_name" required>
            <label>Phone Number:</label>
            <input type="tel" name="phone" required>
			<br>
			<br>	
            <div class="btn-container">
                <button type="submit" class="submit">Login</button>
                <button type="reset" class="cancel">Cancel</button>
            </div>
        </form>

        <?php if (isset($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>
    </div>

</body>
</html>
