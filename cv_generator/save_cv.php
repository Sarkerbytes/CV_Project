<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$job_title = $_POST['job_title'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$address = $_POST['address'];
$skills = $_POST['skills'];
$languages = $_POST['languages'];
$hobbies = $_POST['hobbies'];
$profile_summary = $_POST['profile_summary'];
$work_experience = $_POST['work_experience'];
$education = $_POST['education'];

// Handle file upload (new photo or keep old)
$photoName = '';

if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
    $photoName = uniqid() . "_" . $_FILES['photo']['name'];
    $photoTmp = $_FILES['photo']['tmp_name'];
    $photoPath = "uploads/" . $photoName;
    move_uploaded_file($photoTmp, $photoPath);
} elseif (isset($_POST['old_photo'])) {
    $photoName = $_POST['old_photo'];
}

// Determine if update or insert
if (isset($_POST['update']) && $_POST['update'] === 'true') {
    $id = $_POST['id'];

    $stmt = $conn->prepare("UPDATE cv_data SET 
        name=?, job_title=?, phone=?, email=?, address=?, skills=?, 
        languages=?, hobbies=?, profile_summary=?, work_experience=?, 
        education=?, photo=? 
        WHERE id=?");

    $stmt->bind_param("ssssssssssssi", 
        $name, $job_title, $phone, $email, $address, $skills, $languages, 
        $hobbies, $profile_summary, $work_experience, $education, $photoName, $id);

    if ($stmt->execute()) {
        header("Location: view_cv.php?id=$id");
        exit();
    } else {
        echo "Error updating CV: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Insert new record
    $stmt = $conn->prepare("INSERT INTO cv_data 
        (name, job_title, phone, email, address, skills, languages, hobbies, profile_summary, work_experience, education, photo) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssssss", 
        $name, $job_title, $phone, $email, $address, $skills, $languages, $hobbies, 
        $profile_summary, $work_experience, $education, $photoName);

    if ($stmt->execute()) {
        $last_id = $stmt->insert_id;
        header("Location: view_cv.php?id=$last_id");
        exit();
    } else {
        echo "Error saving CV: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
