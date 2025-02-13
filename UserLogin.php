<?php
$servername = "localhost"; 
$username = "root";     
$password = "";     
$dbname = "onlineaptitudetest";  

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM student WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // If user exists, redirect to the next page
        echo "Login Sucessfully!";
        header("Location:UserHome.html");
        exit();
    } else {
        // If user doesn't exist or credentials are incorrect, display an error message
        echo "Invalid email or password";
        header("refresh:1; url=UserLogin.html");
    }
}

$conn->close();
?>



