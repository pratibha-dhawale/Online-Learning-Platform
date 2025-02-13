<?php
// Establish database connection (Replace with your database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "onlineaptitudetest";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$email = $_POST['email'];
$newPassword = $_POST['password'];
$confirmPassword = $_POST['confirmpass'];

// Check if new password matches confirm password
if ($newPassword !== $confirmPassword) {
  echo "New password and confirm password do not match!";
} else {
  // Update password and confirmpass columns in the student table
  $sql = "UPDATE student SET password = '$newPassword', confirmpass = '$confirmPassword' WHERE email = '$email'";

  if ($conn->query($sql) === TRUE) {
    echo "Password updated successfully";
    header("Location:UserLogin.html");
        exit();
  } else {
    echo "Error updating password: " . $conn->error;
  }
}

// Close database connection
$conn->close();
?>
