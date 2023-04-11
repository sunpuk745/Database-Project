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
      
// fetch football schedules
$result_football = fetch_tournament_schedules("football_tournament", $servername, $username, $password);

// fetch volleyball schedules
$result_volleyball = fetch_tournament_schedules("volleyball_tournament", $servername, $username, $password);

// fetch basketball schedules
$result_basketball = fetch_tournament_schedules("basketball_tournament", $servername, $username, $password);

// display the schedules
echo "<img src='sportsday.png' width='500' class='center' vspace='30'>";
echo "<h1 style='text-align: center; color:white; font-size:50px; font-family:verdana; text-shadow: 4px 4px black;'>Organizer Page</h1>";

// display football schedules
$football_schedule = $result_football;
$football_database_name = "football_tournament";
createOrganizerGameSchedule("Football Schedule", $football_schedule, $football_database_name);

// display volleyball schedules
$volleyball_schedule = $result_volleyball;
$volleyball_database_name = "volleyball_tournament";
createOrganizerGameSchedule("Volleyball Schedule", $volleyball_schedule, $volleyball_database_name);

// display basketball schedules
$basketball_schedule = $result_basketball;
$basketball_database_name = "basketball_tournament";
createOrganizerGameSchedule("Basketball Schedule", $basketball_schedule, $basketball_database_name);
?>

<div class="form-popup-overlay" id="result-popup-overlay"></div>
<div class="form-popup" id="resultForm">
  <form method="post" action="update_match_result.php" class="form-container">
    <h1>Update Match Result</h1>
    <input type="hidden" name="database_name" value="">
    <label for="match_id"><b>Match ID</b></label>
    <input type="text" placeholder="Enter Match ID" name="match_id" readonly required>
    <label for="team1_score"><b>Team 1 Score</b></label>
    <input type="text" placeholder="Enter Team 1 Score" name="team1_score" required>
    <label for="team2_score"><b>Team 2 Score</b></label>
    <input type="text" placeholder="Enter Team 2 Score" name="team2_score" required>
    <button type="submit" class="btn">Update Match Result</button>
    <button type="button" class="btn cancel" onclick="closeResultForm()" style="float: right;">Close</button>
  </form>
</div>


<div class="form-popup-overlay" id="form-popup-overlay"></div>
<div class="form-popup" id="myForm">
  <form method="post" action="add_match_schedule.php" class="form-container">
    <h1>Add New Match Schedule</h1>
    <input type="hidden" name="database_name" value="">
    <label for="match_date"><b>Match Date</b></label>
    <input type="date" placeholder="Enter Match Date" name="match_date" required>

    <label for="match_time"><b>Match Time</b></label>
    <input type="time" placeholder="Enter Match Time" name="match_time" required>

    <label for="team1"><b>Team 1</b></label>
    <select name="team1" required>
      <option value="" disabled selected>Select a color</option>
      <option value="1">Red</option>
      <option value="2">Blue</option>
      <option value="3">Yellow</option>
      <option value="3">Green</option>
    </select>

    <label for="team2"><b>Team 2</b></label>
    <select name="team2" required>
      <option value="" disabled selected>Select a color</option>
      <option value="1">Red</option>
      <option value="2">Blue</option>
      <option value="3">Yellow</option>
      <option value="4">Green</option>
    </select>

    <button type="submit" class="btn">Add Match Schedule</button>
    <button type="button" class="btn cancel" onclick="closeForm()" style="float: right;">Close</button>
  </form>
</div>

  <form action="logout.php" method="post">
    <button class="logout-button" type="submit" name="logout">Logout</button>
  </form>

<body style="background-color:RebeccaPurple">
</body>