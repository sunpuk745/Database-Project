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
$dbname = "volleyball_tournament";

$conn_volleyball = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn_volleyball) {
  die("Connection failed: " . mysqli_connect_error());
}

// fetch volleyball schedules
$result = fetch_tournament_schedules("volleyball_tournament", $servername, $username, $password);

if (!$result) {
  die("Error: " . $sql . "<br>" . mysqli_error($conn));
}

// Display volleybal matches
echo "<img src='volleyball.jpg' width='500' class='center' vspace='30'>";
displayMatches($result, "Volleyball Schedule")

?>

<form action="logout.php" method="post">
    <button class="logout-button" type="submit" name="logout">Logout</button>
  </form>

<body style="background-color:RebeccaPurple">
</body>