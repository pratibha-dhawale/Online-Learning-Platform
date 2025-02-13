<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "onlineaptitudetest";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $topic_name = $_POST['topic_name'];
    $video_url = $_POST['video_url'];

    $sql = "INSERT INTO addvideo (topic_name, video_url) VALUES ('$topic_name', '$video_url')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Video added successfully'); window.location.href='AdminDashboard.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
