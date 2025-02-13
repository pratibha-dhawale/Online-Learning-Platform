<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Question Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin-top: 10px;
    }
    .container {
      max-width: 470px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-color: #f9f9f9;
    }
    .form-group {
      margin-bottom: 15px;
    }
    .form-group label {
      display: block;
      font-weight: bold;
    }
    .form-group input[type="text"] {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 3px;
      box-sizing: border-box;
    }
    .btn-container {
      text-align: center;
      margin-top: 20px;
    }
    .btn-container button {
      padding: 10px 20px;
      margin: 0 10px;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }
    .btn-clear {
      background-color: #ff6347; /* Red */
      color: white;
    }
    .btn-save {
      background-color: #4caf50; /* Green */
      color: white;
    }
  </style>
</head>
<body>

<div class="container">
    <h2>Edit Question</h2>
  <form id="questionForm" action="EditQuestionD.php" method="POST">
    <div class="form-group">
    <label for="question_id">Question ID:</label>
    <input type="text" id="question_id" name="question_id" required>
    </div>
    <div class="form-group">
      <label for="question">Question:</label>
      <input type="text" id="question" name="question" required>
    </div>
    <div class="form-group">
      <label for="optionA">Option A:</label>
      <input type="text" id="optionA" name="optionA" required>
    </div>
    <div class="form-group">
      <label for="optionB">Option B:</label>
      <input type="text" id="optionB" name="optionB" required>
    </div>
    <div class="form-group">
      <label for="optionC">Option C:</label>
      <input type="text" id="optionC" name="optionC" required>
    </div>
    <div class="form-group">
      <label for="optionD">Option D:</label>
      <input type="text" id="optionD" name="optionD" required>
    </div>
    <div class="form-group">
      <label for="correctAnswer">Correct Answer:</label>
      <input type="text" id="correctAnswer" name="correctAnswer" required>
    </div>
    

    <div class="form-group">
        <select id="selectTestType" name="selectTestType" required>
            <option value="">Select Test Type</option>
            <?php
            // Connect to the database
            $hostname = "localhost";
            $username = "root";
            $password = "";
            $database = "onlineaptitudetest";
    
            $conn = mysqli_connect($hostname, $username, $password, $database);
            if (!$conn) {
                echo "Connection Failed";
            }
    
            // Fetch data from the addtest table
            $sql = "SELECT tname FROM addtest";
            $result = mysqli_query($conn, $sql);
    
            // Generate options for each test type
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['tname'] . "'>" . $row['tname'] . "</option>";
            }
    
            // Close the database connection
            mysqli_close($conn);
            ?>
        </select>
    </div>
    <div class="btn-container">
      <button type="button" class="btn-clear" onclick="clearForm()">Clear</button>
      <button type="submit" class="btn-save">Save</button>
    </div>
  </form>
</div>

<script>
  function clearForm() {
    document.getElementById("questionForm").reset();
  }
</script>

</body>
</html>
