<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "onlineaptitudetest";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all questions from the database
$sql = "SELECT * FROM addquestion WHERE testtype = 'Verbal Ability'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching questions: " . mysqli_error($conn));
}

$questions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $questions[] = $row;
}

$totalQuestions = count($questions);
if ($totalQuestions == 0) {
    die("No questions available.");
}

// Initialize or retrieve current question index and user answers from the form
$currentQuestionIndex = isset($_POST['current_question_index']) ? $_POST['current_question_index'] : 0;
$userAnswers = isset($_POST['user_answers']) ? json_decode($_POST['user_answers'], true) : [];
$startTime = isset($_POST['start_time']) ? $_POST['start_time'] : time();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['question_id'])) {
    // Save the submitted answer
    $question_id = $_POST['question_id'];
    $user_answer = $_POST['answer'];
    $userAnswers[$question_id] = $user_answer;

    // Move to the next question
    $currentQuestionIndex++;

    // Check if it's the last question, if yes, display the results
    if ($currentQuestionIndex >= $totalQuestions) {
        displayResult($questions, $userAnswers);
        mysqli_close($conn);
        exit;
    }
}

// Display the current question
$question = $questions[$currentQuestionIndex];
echo "<h2>Question : " . ($currentQuestionIndex + 1) . "</h2>";
echo "<h3>" . $question["question"] . "</h3>";
echo "<form id='questionForm' method='post' action=''>";
echo "<input type='hidden' name='current_question_index' value='" . $currentQuestionIndex . "'>";
echo "<input type='hidden' name='question_id' value='" . $question["qid"] . "'>";
echo "<input type='hidden' name='user_answers' value='" . htmlspecialchars(json_encode($userAnswers), ENT_QUOTES, 'UTF-8') . "'>";
echo "<input type='hidden' name='start_time' value='" . $startTime . "'>";
echo "<input type='radio' name='answer' value='Option A'" . (isset($userAnswers[$question["qid"]]) && $userAnswers[$question["qid"]] == 'Option A' ? ' checked' : '') . ">" . $question["optiona"] . "<br>";
echo "<input type='radio' name='answer' value='Option B'" . (isset($userAnswers[$question["qid"]]) && $userAnswers[$question["qid"]] == 'Option B' ? ' checked' : '') . ">" . $question["optionb"] . "<br>";
echo "<input type='radio' name='answer' value='Option C'" . (isset($userAnswers[$question["qid"]]) && $userAnswers[$question["qid"]] == 'Option C' ? ' checked' : '') . ">" . $question["optionc"] . "<br>";
echo "<input type='radio' name='answer' value='Option D'" . (isset($userAnswers[$question["qid"]]) && $userAnswers[$question["qid"]] == 'Option D' ? ' checked' : '') . ">" . $question["optiond"] . "<br>";

// Check if it's the last question to set button name
if ($currentQuestionIndex < $totalQuestions - 1) {
    echo "<button type='submit'>Next</button>";
} else {
    echo "<button type='submit'>Submit Test</button>";
}

echo "</form>";

// Script to display remaining time
$timeLimit = 60 * 20; // 20 minutes
$elapsedTime = time() - $startTime;
$remainingTime = $timeLimit - $elapsedTime;

echo "<div id='timer' class='timer'>Remaining Time: <span id='timeDisplay'>" . gmdate("i:s", $remainingTime) . "</span></div>";

if ($remainingTime <= 0) {
    // Time is up, submit the form
    displayResult($questions, $userAnswers);
    mysqli_close($conn);
    exit;
}

echo "<script>
    var timeLimit = $remainingTime;
    var timer = setInterval(function() {
        var minutes = Math.floor(timeLimit / 60);
        var seconds = timeLimit % 60;
        document.getElementById('timeDisplay').innerText = minutes + 'm ' + seconds + 's';
        timeLimit--;
        if (timeLimit < 0) {
            clearInterval(timer);
            document.getElementById('questionForm').submit();
        }
    }, 1000);
</script>";

function displayResult($questions, $userAnswers) {
    // Calculate results
    $correctAnswers = 0;
    $totalQuestions = count($questions);
    
    foreach ($questions as $question) {
        $question_id = $question['qid'];
        if (isset($userAnswers[$question_id]) && $question['correct_ans'] == $userAnswers[$question_id]) {
            $correctAnswers++;
        }
    }

    // Calculate total marks
    $totalMarks = $totalQuestions * 1; // Assuming each question carries equal marks
    $obtainedMarks = $correctAnswers * 1; // Assuming each correct answer carries 1 mark

    echo "<h1>Test Results</h1>";
    echo "<p><h3>Correct Answers: $correctAnswers</h3></p>";
    echo "<p><h3>Incorrect Answers: " . ($totalQuestions - $correctAnswers) . "</h3></p>";
    echo "<p><h3>Your Score: $obtainedMarks / $totalMarks</h3></p>";
}

mysqli_close($conn);
?>

<style>
.timer {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: red;
    border: 1px solid #ccc;
    padding: 10px 20px;
    border-radius: 5px;
}
</style>
