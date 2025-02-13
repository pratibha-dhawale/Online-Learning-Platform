<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Prepare and bind parameters
    $sql = "UPDATE addquestion SET question=?, optiona=?, optionb=?, optionc=?, optiond=?, correct_ans=?, testtype=? WHERE qid=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssi", $question, $optionA, $optionB, $optionC, $optionD, $correctAnswer, $TestType, $question_id);

    // Set parameters and execute
    $question_id = $_POST["question_id"];
    $question = $_POST["question"];
    $optionA = $_POST["optionA"];
    $optionB = $_POST["optionB"];
    $optionC = $_POST["optionC"];
    $optionD = $_POST["optionD"];
    $correctAnswer = $_POST["correctAnswer"];
    $TestType = $_POST["selectTestType"];

    if (mysqli_stmt_execute($stmt)) {
        echo "Question updated successfully";
        // Redirect to dashboard after 1 second
        header("refresh:1; url=AdminDashboard.php"); 
    } else {
        echo "Error updating question: " . mysqli_error($conn);
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
