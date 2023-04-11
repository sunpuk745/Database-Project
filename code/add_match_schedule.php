<?php
// connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = $_POST['database_name'];

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// get form data
$match_date = $_POST['match_date'];
$match_time = $_POST['match_time'];
$team1 = $_POST['team1'];
$team2 = $_POST['team2'];

// add new match schedule to database
$sql = "INSERT INTO matches (date, time, team_1, team_2) VALUES ('$match_date', '$match_time', '$team1', '$team2')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('New match schedule added successfully!'); window.location.href='organizer.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
