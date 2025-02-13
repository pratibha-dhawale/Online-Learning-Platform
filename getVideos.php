<?php
// Assuming you have a MySQL database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "onlineaptitudetest";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get videos
$sql = "SELECT topic_name, video_url FROM addvideo";
$result = $conn->query($sql);

$videos = array();
if ($result->num_rows > 0) {
    // Fetch all videos
    while($row = $result->fetch_assoc()) {
        // Convert normal YouTube URL or shortened URL to embed URL
        $embedUrl = $row['video_url'];

        // Check if it's a live YouTube video URL
        if (strpos($embedUrl, 'youtube.com/live/') !== false) {
            // Extract video ID from live URL
            $videoId = substr($embedUrl, strrpos($embedUrl, '/') + 1);
            $embedUrl = 'https://www.youtube.com/embed/' . $videoId . '?autohide=1&showinfo=0&autoplay=1';
        }
        // Check if it's a shortened YouTube URL (youtu.be)
        elseif (strpos($embedUrl, 'youtu.be/') !== false) {
            // Extract video ID from shortened URL
            $videoId = substr($embedUrl, strrpos($embedUrl, '/') + 1);
            $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
        }
        // Check if it's a normal YouTube URL (youtube.com/watch?v=VIDEO_ID)
        elseif (strpos($embedUrl, 'youtube.com/watch?v=') !== false) {
            $videoId = substr(parse_url($embedUrl, PHP_URL_QUERY), 2);
            $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
        }

        // Update the video URL with the embed format
        $row['video_url'] = $embedUrl;
        $videos[] = $row;
    }
} else {
    echo "0 results";
}

// Output as JSON
echo json_encode($videos);

// Close connection
$conn->close();
?>
