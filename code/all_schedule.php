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
// connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "football_tournament";

// Create connection
$conn_football = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn_football) {
    die("Connection failed: " . mysqli_connect_error());
}


$date_filter = isset($_GET['date_filter']) ? $_GET['date_filter'] : '';
$result_football = fetchCompetitorMatches('football', $date_filter);
$result_volleyball = fetchCompetitorMatches('volleyball', $date_filter);
$result_basketball = fetchCompetitorMatches('basketball', $date_filter);

// display the schedules
echo "<img src='sportsday.png' width='500' class='center' vspace='30'>";
echo "<h1 style='text-align: center; color:white; font-size:50px; font-family:verdana; text-shadow: 4px 4px black;'>All Sports Schedule</h1>";
echo "<form method='get' class='filter-form' style='text-align: center;'>
        <label for='date_filter' style='color: white';>วันที่:</label>
        <input type='date' id='date_filter' name='date_filter' value='$date_filter'>
        <button type='submit'>กรอง</button>
      </form>";

// display football schedules
displayMatches($result_football, "Football Schedule");

// display volleyball schedules
displayMatches($result_volleyball, "Volleyball Schedule");

// display basketball schedules
displayMatches($result_basketball, "Basketball Schedule");

?>

<form action="logout.php" method="post">
    <button class="logout-button" type="submit" name="logout">Logout</button>
  </form>
<body style="background-color:RebeccaPurple">
</body>