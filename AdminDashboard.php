<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="AdminDashboard.css">
  <!-- Include Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    /* Hide all sections except home */
    .section {
      display: none;
    }
    .section.active {
      display: block;
    }
    /* Center the Add Video Section */
    #addVideo {
      display: flex;
      flex-direction: column; 
      justify-content: center;
      align-items: center;
      height: 80vh;
      background-color: #f4f4f4;
    }
    #addVideo h2 {
      margin-bottom: 15px; 
      color: #333;
      font-size: 24px; 
      text-align: center; 
      font-weight: bold; 
    }
    #AddVideoForm {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
      width: 360px;
      text-align: left; 
      margin-left:450px;
    }
    #AddVideoForm label {
      display: block;
      font-weight: bold;
      margin: 10px 0 5px;
    }
    #AddVideoForm input[type="text"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
      outline: none;
      transition: border 0.3s ease-in-out;
    }
    #AddVideoForm input[type="text"]:focus {
      border-color: #007bff;
    }
    #AddVideoForm input[type="submit"], 
    #AddVideoForm .btn-clear {
      width: 48%;
      padding: 10px;
      margin: 5px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease-in-out;
    }
    #AddVideoForm input[type="submit"] {
      background-color: #28a745;
      color: white;
    }
    #AddVideoForm input[type="submit"]:hover {
      background-color: #218838;
    }
    #AddVideoForm .btn-clear {
      background-color: #dc3545;
      color: white;
    }
    #AddVideoForm .btn-clear:hover {
      background-color: #c82333;
    }
  </style>
</head>
<body>

<ul class="menu">
  <li><a href="#" onclick="toggleSection('home')">Home</a></li>
  <li><a href="#" onclick="toggleSection('addTest')">Add Test</a></li>
  <li><a href="#" onclick="toggleSection('setTest')">Set Test</a></li>
  <li><a href="#" onclick="toggleSection('addVideo')">Add Video</a></li>
  <li><a href="index.html">Logout</a></li>
</ul>

<div id="home" class="section active">
  <img src="Home1.jpg" alt="Home Image" style="width: 100%; height: 515px;">
</div>

<!-- Set Test Section -->
<div id="setTest" class="section">
  <div class="row">
    <div><b>Add Questions</b></div>
    <div class="buttons">
      <button class="add" onclick="AddQuestion()"><i class="fas fa-plus"></i></button>
    </div>
  </div>
  <div class="row">
    <div><b>Edit Questions</b></div>
    <div class="buttons">
      <button class="edit" onclick="EditQuestion()"><i class="fas fa-edit"></i></button>
    </div>
  </div>
  <div class="row">
    <div><b>Delete Questions</b></div>
    <div class="buttons">
      <button class="delete" onclick="DeleteQuestion()"><i class="fas fa-trash-alt"></i></button>
    </div>
  </div>
</div>

<div id="addTest" class="section">
  <h2>Add Test</h2>
  <form id="AddTestForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Test Name: <input type="text" name="testname">
    <input type="submit" value="Save">
    <button type="button" class="btn-clear" onclick="clearForm()">Clear</button>
  </form>
  <!-- Display added tests -->
  <?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "onlineaptitudetest";

    $conn = mysqli_connect($hostname, $username, $password, $database);
    if (!$conn) {
        echo "Connection Failed";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $tname = $_POST['testname'];
        $sql = "INSERT INTO addtest(tname) VALUES ('$tname')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Test added successfully');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Fetch added tests
    $sql = "SELECT tname FROM addtest";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<h3>Added Tests:</h3>";
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li>" . $row['tname'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No tests added yet.</p>";
    }

    mysqli_close($conn);
  ?>
</div>

<!-- Add Video Section -->
<div id="addVideo" class="section">
  <h2>Add Video</h2>
  <form id="AddVideoForm" method="post" action="addvideo.php">
    <label for="topic_name">Topic Name:</label>
    <input type="text" name="topic_name" required><br>

    <label for="video_url">Video URL:</label>
    <input type="text" name="video_url" required><br>

    <input type="submit" value="Save">
    <button type="button" class="btn-clear" onclick="clearVideoForm()">Clear</button>
  </form>
</div>

<!-- Logout Section -->
<div id="logout" class="section"></div>

<script>
  function toggleSection(id) {
    // Hide all sections first
    var sections = document.querySelectorAll('.section');
    sections.forEach(function(sec) {
      sec.style.display = "none";
    });

    // Show the selected section
    var section = document.getElementById(id);
    if (section) {
      section.style.display = "block";
    }
  }

  function AddQuestion() {
    window.location.href = "AddNewQuestion.php"; 
  }
  
  function DeleteQuestion() {
    window.location.href = "DeleteQuestion.html"; 
  }

  function EditQuestion() {
    window.location.href = "EditQuestion.php"; 
  }

  function clearForm() {
    document.getElementById("AddTestForm").reset();
  }

  function clearVideoForm() {
    document.getElementById("AddVideoForm").reset();
  }
</script>

</body>
</html>
