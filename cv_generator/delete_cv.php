<?php
if (!isset($_GET['id'])) {
    die("No CV ID provided.");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_database";

// Connect
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

// Optionally delete the photo from uploads
$sql = "SELECT photo FROM cv_data WHERE id=$id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $photoPath = 'uploads/' . $row['photo'];
    if (file_exists($photoPath)) {
        unlink($photoPath);
    }
}

// Delete from database
$sql = "DELETE FROM cv_data WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    header("Location: form.php");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
