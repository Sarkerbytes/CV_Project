<?php
$updateMode = false;
$data = [];

// If this form is opened in update mode
if (isset($_GET['update']) && $_GET['update'] === 'true' && isset($_GET['id'])) {
    $updateMode = true;
    $user_id = $_GET['id'];

   $conn = new mysqli('localhost', 'root', '', 'cv_database');

    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $sql = "SELECT * FROM cv_data WHERE id = $user_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Create Your CV</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <form action="save_cv.php" method="POST" enctype="multipart/form-data" class="cv-form">
    <h2><?php echo $updateMode ? 'Update Your CV' : 'Create Your CV'; ?></h2>

    <?php if ($updateMode): ?>
      <input type="hidden" name="update" value="true">
      <input type="hidden" name="id" value="<?php echo $user_id; ?>">
      <input type="hidden" name="old_photo" value="<?php echo $data['photo']; ?>">
    <?php endif; ?>

    <label>Profile Photo:</label>
    <input type="file" name="photo" <?php echo $updateMode ? '' : 'required'; ?>><br>
    <?php if ($updateMode && !empty($data['photo'])): ?>
      <img src="uploads/<?php echo $data['photo']; ?>" alt="Current Photo" style="height: 100px;"><br>
    <?php endif; ?>

    <label>Name:</label>
    <input type="text" name="name" value="<?php echo $data['name'] ?? ''; ?>" required><br>

    <label>Job Title:</label>
    <input type="text" name="job_title" value="<?php echo $data['job_title'] ?? ''; ?>" required><br>

    <label>Phone:</label>
    <input type="text" name="phone" value="<?php echo $data['phone'] ?? ''; ?>" required><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo $data['email'] ?? ''; ?>" required><br>

    <label>Address:</label>
    <input type="text" name="address" value="<?php echo $data['address'] ?? ''; ?>" required><br>

    <label>Skills (comma-separated):</label>
    <input type="text" name="skills" value="<?php echo $data['skills'] ?? ''; ?>" required><br>

    <label>Languages (comma-separated):</label>
    <input type="text" name="languages" value="<?php echo $data['languages'] ?? ''; ?>" required><br>

    <label>Hobbies (comma-separated):</label>
    <input type="text" name="hobbies" value="<?php echo $data['hobbies'] ?? ''; ?>" required><br>

    <label>Profile Summary:</label>
    <textarea name="profile_summary" required><?php echo $data['profile_summary'] ?? ''; ?></textarea><br>

    <label>Work Experience:</label>
    <textarea name="work_experience" required><?php echo $data['work_experience'] ?? ''; ?></textarea><br>

    <label>Education:</label>
    <textarea name="education" required><?php echo $data['education'] ?? ''; ?></textarea><br>

    <input type="submit" value="<?php echo $updateMode ? 'Update CV' : 'Generate CV'; ?>">
  </form>
</body>
</html>
