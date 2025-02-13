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
    $question= $_POST['question'];
    $optiona = $_POST['optionA'];
    $optionb = $_POST['optionB'];
    $optionc = $_POST['optionC'];
    $optiond = $_POST['optionD'];
    $correct = $_POST['correctAnswer'];
    $testtype=$_POST['selectTestType'];

    // Prepare SQL statement
    $sql = "INSERT INTO addquestion (question, optiona,optionb, optionc,optiond,correct_ans,testtype) VALUES ('$question', '$optiona', '$optionb', '$optionc', '$optiond','$correct','$testtype')";

    // Execute SQL statement
    if(mysqli_query($conn, $sql)){
        echo "Question Add successfully.";
        // You can redirect to the next page using header function after a short delay
        header("refresh:1; url=AdminDashboard.php"); 
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
?>
