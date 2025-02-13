<?php
session_start(); // Start the session

// Connect to your MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "onlineaptitudetest";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$correctAnswers = 0;
$wrongAnswers = 0;

if (isset($_SESSION['user_answers'])) {
    foreach ($_SESSION['user_answers'] as $question_id => $user_answer) {
        // Retrieve the correct answer from the database
        $sql = "SELECT correct_ans FROM quantitativeque WHERE qid = $question_id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $correct_answer = $row['correct_ans'];

            // Compare the user's answer with the correct answer
            if ($user_answer === $correct_answer) {
                // If the answers match, increment correct answer count
                $correctAnswers++;
            } else {
                // If the answers don't match, increment wrong answer count
                $wrongAnswers++;
            }
        }
    }
}

// Display the count of correct and wrong answers
echo "Correct Answers: $correctAnswers<br>";
echo "Wrong Answers: $wrongAnswers";

mysqli_close($conn);
?>
