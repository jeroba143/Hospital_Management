<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_management"; // Update to match your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize an error message
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']); // Phone number used as password

    // Query to fetch doctor details
    $sql = "SELECT id, name, phone FROM doctors WHERE email = ? AND phone = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Doctor found, login successful
        $doctor = $result->fetch_assoc();
        $_SESSION['doctor_id'] = $doctor['id'];
        $_SESSION['doctor_name'] = $doctor['name'];

        header("Location: doctors_dashboard.php"); // Redirect to doctor's dashboard
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>🚀 Doctor Login - Hospital Management</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: url("img6.jpg") no-repeat center center fixed;
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
	  height: 370px;
      background: url("img7.jpg") no-repeat center center;
      background-size: cover;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
      background: rgba(0, 0, 0, 0.3); 
      backdrop-filter: blur(2px);
      color: white;
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
      color: lightblue;
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
    <h2>Doctor Login</h2>
    
    <?php if (!empty($error)) { echo "<p style='color:red; text-align:center; font-weight:bold;'>$error</p>"; } ?>

    <form action="" method="POST">
      <label for="email">Email Address:</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" required>
	  <br>
	  <br>

      <label for="password">Phone Number:</label>
      <input type="password" id="password" name="password" placeholder="Enter your phone number" required>
	  <br>
	  <br>
      <div class="btn-container">
        <button type="submit" class="submit">Login</button>
        <button type="reset" class="cancel">Cancel</button>
      </div>
    </form>

  </div>

</body>
</html>
