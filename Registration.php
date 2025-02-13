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

    // Fetch form data using $_POST
    $sname = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $confirmpass = $_POST['confpass'];
    $mobileno = $_POST['mno'];

    // Prepare SQL statement
    $sql = "INSERT INTO student (sname, email, password, confirmpass, mobileno) VALUES ('$sname', '$email', '$password', '$confirmpass', '$mobileno')";

    // Execute SQL statement
    if(mysqli_query($conn, $sql)){
        echo "Registration successful.";
        // You can redirect to the next page using header function after a short delay
        header("refresh:1; url=UserLogin.html"); // Change next_page.php to your actual next page
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
?>
