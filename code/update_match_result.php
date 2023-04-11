<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = $_POST['database_name'];

  $conn = mysqli_connect($servername, $username, $password, $dbname);

  if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
  }

  $match_id = $_POST['match_id'];
  $team1_score = $_POST['team1_score'];
  $team2_score = $_POST['team2_score'];

  $sql = "UPDATE matches SET result='$team1_score - $team2_score' WHERE match_id=$match_id";

  if (mysqli_query($conn, $sql)) {
    // success message
    echo "<script>alert('Match result updated successfully!'); window.location.href='organizer.php';</script>";
  } else {
    // error message
    echo "<script>alert('Error updating match result: " . mysqli_error($conn) . "');</script>";
  }

  mysqli_close($conn);
?>
