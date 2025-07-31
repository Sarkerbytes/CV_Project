<?php
require_once('tcpdf/tcpdf.php');

// Database Connection
$conn = new mysqli("localhost", "root", "", "cv_database");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$id = $_GET['id'];
$sql = "SELECT * FROM cv_data WHERE id=$id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
} else {
  die("CV not found.");
}
$conn->close();

// Create PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('CV of '.$row['name']);
$pdf->AddPage('P','A4');

$html = '
<table border="0" cellpadding="6">
  <tr>
    <td width="30%" bgcolor="#2c3e50" color="#fff">
      <img src="uploads/'.$row['photo'].'" width="150" height="150"><br><br>
      <h2 style="color:#fff;">'.$row['name'].'</h2>
      <strong style="color:#fff;">'.$row['job_title'].'</strong><br><br>
      <strong style="color:#fff;">Phone:</strong> '.$row['phone'].'<br>
      <strong style="color:#fff;">Email:</strong> '.$row['email'].'<br>
      <strong style="color:#fff;">Address:</strong> '.$row['address'].'<br><br>
      <h3 style="color:#fff;">Skills</h3>
      <ul>';
        foreach (explode(",",$row['skills']) as $skill) {
          $html .= '<li>'.$skill.'</li>';
        }
$html .= '</ul>
      <h3 style="color:#fff;">Languages</h3>
      <ul>';
        foreach (explode(",",$row['languages']) as $lang) {
          $html .= '<li>'.$lang.'</li>';
        }
$html .= '</ul>
      <h3 style="color:#fff;">Hobbies</h3>
      <ul>';
        foreach (explode(",",$row['hobbies']) as $hobby) {
          $html .= '<li>'.$hobby.'</li>';
        }
$html .= '</ul>
    </td>

    <td width="70%">
      <h2>Profile Summary</h2>
      <p>'.$row['profile_summary'].'</p>

      <h2>Work Experience</h2>
      <p>'.$row['work_experience'].'</p>

      <h2>Education</h2>
      <p>'.$row['education'].'</p>
    </td>
  </tr>
</table>
';

$pdf->writeHTML($html);
$pdf->Output('CV_'.$row['name'].'.pdf', 'I');
?>
