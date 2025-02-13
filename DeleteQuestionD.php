<?php
// Database connection parameters
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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get question ID from the form
    $question_id = $_POST["question_id"];
    
    // Prepare a DELETE statement
    $sql = "DELETE FROM addquestion WHERE qid = ?";

    // Prepare and bind parameters
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $question_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "Question deleted successfully.";
        header("refresh:1; url=AdminDashboard.php"); 
    } else {
        echo "Error deleting question: " . mysqli_error($conn);
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// Close connection
mysqli_close($conn);
?>
