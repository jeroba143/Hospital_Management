<?php
session_start();
require 'db.php'; // Include your database connection

// Check if the doctor is logged in
if (!isset($_SESSION['first_name'])) {
    header("Location: login.php");
    exit();
}

$doctor_id = $_SESSION['first_name'];

// Fetch current doctor details from the database
$sql = "SELECT first_name, phone, password, created_at FROM admins WHERE first_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();

// Handle form submission for profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['first_name'];
    $email = $_POST['phone'];
    $phone = $_POST['password'];
    $specialization = $_POST['created_at'];
    

    // If password is not empty, update it
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $update_sql = "UPDATE admins SET first_name=?, phone=?, password=?, created_at=? WHERE first_name=?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sssssi", $name, $email, $phone, $specialization, $hashed_password, $doctor_id);
    } else {
        $update_sql = "UPDATE admins SET first_name=?, phone=?, password=?, created_at=? WHERE phone=?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ssssi", $name, $email, $phone, $specialization, $doctor_id);
    }

    if ($stmt->execute()) {
        $_SESSION['first_name'] = $name; // Update session with new name
        $message = "Profile updated successfully!";
    } else {
        $error = "Failed to update profile!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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
            color: black;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            width: 50%;
            margin: auto;
			
        }

        h1 {
            color: #007BFF;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
        }

        button {
            margin-top: 15px;
            padding: 10px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .message {
            margin-top: 10px;
            font-weight: bold;
            color: green;
        }

        .error {
            margin-top: 10px;
            font-weight: bold;
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Profile</h1>
    <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($doctor['first_name']) ?>" required>

        <label>Phone:</label>
        <input type="text" name="email" value="<?= htmlspecialchars($doctor['phone']) ?>" required>

        <label>Password:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($doctor['password']) ?>" required>

        <label>Created_at:</label>
        <input type="text" name="specialization" value="<?= htmlspecialchars($doctor['created_at']) ?>" required>

        

        <button type="submit">Update Profile</button>
    </form>
</div>

</body>
</html>

<?php
$conn->close();
?>
