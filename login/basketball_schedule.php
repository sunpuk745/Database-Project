<?php

session_start();

    include("style.php");
    include("script.php");
    include("connection.php");
    include("function.php");

    $user_data = check_login($con);

    if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    die;
}
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "basketball_tournament";

$conn_basketball = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn_basketball) {
  die("Connection failed: " . mysqli_connect_error());
}

// fetch basketball schedules
$result = fetch_tournament_schedules("basketball_tournament", $servername, $username, $password);

if (!$result) {
  die("Error: " . $sql . "<br>" . mysqli_error($conn));
}

// Display basketball matches
echo "<img src='basketball.jpg' width='500' class='center' vspace='30'>";
displayMatches($result, "Basketball Schedule")

?>

<form action="logout.php" method="post">
    <button class="logout-button" type="submit" name="logout">Logout</button>
  </form>

<body style="background-color:RebeccaPurple">
</body>