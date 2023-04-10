<?php

session_start();

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
$sql_football = "SELECT matches.match_id, matches.date, matches.time, team1.team_name AS team1_name, team2.team_name AS team2_name, matches.result,
                    GROUP_CONCAT(DISTINCT player1.player_name SEPARATOR ', ') AS team1_players,
                    GROUP_CONCAT(DISTINCT player2.player_name SEPARATOR ', ') AS team2_players
                    FROM matches
                    INNER JOIN teams AS team1 ON matches.team_1 = team1.team_id
                    INNER JOIN teams AS team2 ON matches.team_2 = team2.team_id
                    INNER JOIN players AS player1 ON matches.team_1 = player1.team_id
                    INNER JOIN players AS player2 ON matches.team_2 = player2.team_id
                    GROUP BY matches.match_id
                    ORDER BY matches.date, matches.time;";

$result_football = mysqli_query($conn_football, $sql_football);

// fetch volleyball schedules
$conn_volleyball = mysqli_connect($servername, $username, $password, "volleyball_tournament");

$sql_volleyball = "SELECT matches.match_id, matches.date, matches.time, team1.team_name AS team1_name, team2.team_name AS team2_name, matches.result,
                    GROUP_CONCAT(DISTINCT player1.player_name SEPARATOR ', ') AS team1_players,
                    GROUP_CONCAT(DISTINCT player2.player_name SEPARATOR ', ') AS team2_players
                    FROM matches
                    INNER JOIN teams AS team1 ON matches.team_1 = team1.team_id
                    INNER JOIN teams AS team2 ON matches.team_2 = team2.team_id
                    INNER JOIN players AS player1 ON matches.team_1 = player1.team_id
                    INNER JOIN players AS player2 ON matches.team_2 = player2.team_id
                    GROUP BY matches.match_id
                    ORDER BY matches.date, matches.time;";

$result_volleyball = mysqli_query($conn_volleyball, $sql_volleyball);

// fetch basketball schedules
$conn_basketball = mysqli_connect($servername, $username, $password, "basketball_tournament");

$sql_basketball = "SELECT matches.match_id, matches.date, matches.time, team1.team_name AS team1_name, team2.team_name AS team2_name, matches.result,
                    GROUP_CONCAT(DISTINCT player1.player_name SEPARATOR ', ') AS team1_players,
                    GROUP_CONCAT(DISTINCT player2.player_name SEPARATOR ', ') AS team2_players
                    FROM matches
                    INNER JOIN teams AS team1 ON matches.team_1 = team1.team_id
                    INNER JOIN teams AS team2 ON matches.team_2 = team2.team_id
                    INNER JOIN players AS player1 ON matches.team_1 = player1.team_id
                    INNER JOIN players AS player2 ON matches.team_2 = player2.team_id
                    GROUP BY matches.match_id
                    ORDER BY matches.date, matches.time;";

$result_basketball = mysqli_query($conn_basketball, $sql_basketball);


// Display the match schedule in a table format
echo "<style>
table {
    margin: auto;
    border-collapse: collapse;
    width: 80%;
  }
  th, td {
    padding: 8px;
    text-align: center;
    border-bottom: 1px solid #ddd;
  }
  th {
    background-color: #4CAF50;
    color: white;
  }
  .players-button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 8px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    margin: 4px 2px;
    cursor: pointer;
  }
  div {
    display: flex;
    justify-content: center;
    align-items: center;
    padding-top: 30px;
  }
  .form-button {
    display: block;
    margin: 0 auto;
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .form-button:hover {
    background-color: #3e8e41;
  }
  
  .form-popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1;
    display: none;
  }
  
  .form-popup {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fefefe;
    padding: 20px;
    border: 1px solid #888;
    z-index: 2;
    display: none;
  }
  
  .form-container {
    max-width: 400px;
  }
  
  .form-container input[type=date],
  .form-container input[type=time],
  .form-container input[type=text] {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }
  
  .form-container button[type=submit] {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .form-container button[type=submit]:hover {
    background-color: #3e8e41;
  }
  
  .form-container .btn.cancel {
    background-color: #f44336;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .form-container .btn.cancel:hover {
    background-color: #cc2e2e;
  }
  
  .form-container h1 {
    text-align: center;
  }
  select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }
  select:focus {
    outline: none;
    border-color: #2ecc71;
  }
  .result-button {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  .result-button:hover {
    background-color: #3e8e41;
  }
  .logout-button {
    background-color: red; 
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
  .logout-button:hover {
    background-color: darkred;
  }
  
  .logout-button:focus {
    outline: none;
    box-shadow: none;
  }
</style>";
// display the schedules
echo "<h1 style='text-align: center;'>All Sports Schedule</h1>";

// display football schedules
echo "<h2 style='text-align: center;'>Football Schedule</h2>";
echo "<table>";
echo "<tr><th>Match ID</th><th>Date</th><th>Time</th><th>Team 1</th><th>Players</th><th>Team 2</th><th>Players</th><th>Result</th><th>Change Result</th></tr>";

$database_name = "football_tournament";
while ($row = mysqli_fetch_assoc($result_football)) {
    echo "<tr>";
    echo "<td>" . $row['match_id'] . "</td>";
    echo "<td>" . date("d F Y", strtotime($row['date'])) . "</td>";
    echo "<td>" . date("H:i", strtotime($row['time'])) . "</td>";
    echo "<td>" . $row['team1_name'] . "</td>";
    echo "<td><button class='players-button' onclick=\"showTeamPlayers('" . $row['team1_players'] . "')\">View Players</button></td>";
    echo "<td>" . $row['team2_name'] . "</td>";
    echo "<td><button class='players-button' onclick=\"showTeamPlayers('" . $row['team2_players'] . "')\">View Players</button></td>";
    echo "<td>" . $row['result'] . "</td>";
    echo "<td><button class ='result-button' onclick=\"openResultForm('" . $row['match_id'] . "', '" . $database_name . "')\">Change Match Result</button></td>";
    echo "</tr>";
    }

echo "</table>";
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

<br></br>

<?php
$database_name = "football_tournament";

echo "<button class='form-button' onclick=\"openForm('" . $database_name . "')\">Add New Football Match Schedule</button>";
?>

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

<?php
// display volleyball schedules
echo "<h2 style='text-align: center;'>Volleyball Schedule</h2>";
echo "<table>";
echo "<tr><th>Match ID</th><th>Date</th><th>Time</th><th>Team 1</th><th>Players</th><th>Team 2</th><th>Players</th><th>Result</th><th>Change Result</th></tr>";

$database_name = "volleyball_tournament";
while ($row = mysqli_fetch_assoc($result_volleyball)) {
    echo "<tr>";
    echo "<td>" . $row['match_id'] . "</td>";
    echo "<td>" . date("d F Y", strtotime($row['date'])) . "</td>";
    echo "<td>" . date("H:i", strtotime($row['time'])) . "</td>";
    echo "<td>" . $row['team1_name'] . "</td>";
    echo "<td><button class='players-button' onclick=\"showTeamPlayers('" . $row['team1_players'] . "')\">View Players</button></td>";
    echo "<td>" . $row['team2_name'] . "</td>";
    echo "<td><button class='players-button' onclick=\"showTeamPlayers('" . $row['team2_players'] . "')\">View Players</button></td>";
    echo "<td>" . $row['result'] . "</td>";
    echo "<td><button class ='result-button' onclick=\"openResultForm('" . $row['match_id'] . "', '" . $database_name . "')\">Change Match Result</button></td>";
    echo "</tr>";
}

echo "</table>";
?>

<br></br>

<?php
$database_name = "volleyball_tournament";

echo "<button class='form-button' onclick=\"openForm('" . $database_name . "')\">Add New Volleyball Match Schedule</button>";
?>

<?php
// display basketball schedules
echo "<h2 style='text-align: center;'>Basketball Schedule</h2>";
echo "<table>";
echo "<tr><th>Match ID</th><th>Date</th><th>Time</th><th>Team 1</th><th>Players</th><th>Team 2</th><th>Players</th><th>Result</th><th>Change Result</th></tr>";

$database_name = "basketball_tournament";
while ($row = mysqli_fetch_assoc($result_basketball)) {
    echo "<tr>";
    echo "<td>" . $row['match_id'] . "</td>";
    echo "<td>" . date("d F Y", strtotime($row['date'])) . "</td>";
    echo "<td>" . date("H:i", strtotime($row['time'])) . "</td>";
    echo "<td>" . $row['team1_name'] . "</td>";
    echo "<td><button class='players-button' onclick=\"showTeamPlayers('" . $row['team1_players'] . "')\">View Players</button></td>";
    echo "<td>" . $row['team2_name'] . "</td>";
    echo "<td><button class='players-button' onclick=\"showTeamPlayers('" . $row['team2_players'] . "')\">View Players</button></td>";
    echo "<td>" . $row['result'] . "</td>";
    echo "<td><button class ='result-button' onclick=\"openResultForm('" . $row['match_id'] . "', '" . $database_name . "')\">Change Match Result</button></td>";
    echo "</tr>";
}

echo "</table>";
?>

<br></br>

<?php
$database_name = "basketball_tournament";

echo "<button class='form-button' onclick=\"openForm('" . $database_name . "')\">Add New Basketball Match Schedule</button>";
?>

  <form action="logout.php" method="post">
    <button class="logout-button" type="submit" name="logout">Logout</button>
  </form>


<script>
    function showTeamPlayers(players) {
    var playersArray = players.split(', ');
    var playerList = '';

    for (var i = 0; i < playersArray.length; i++) {
        playerList += (i+1) + '. ' + playersArray[i] + '\n';
    }

    var dialog = document.createElement('div');
    dialog.style.width = '300px';
    dialog.style.height = '300px';
    dialog.style.backgroundColor = '#fff';
    dialog.style.border = '1px solid #ccc';
    dialog.style.borderRadius = '5px';
    dialog.style.padding = '20px';
    dialog.style.position = 'fixed';
    dialog.style.top = '50%';
    dialog.style.left = '50%';
    dialog.style.transform = 'translate(-50%, -50%)';
    dialog.style.zIndex = '9999';
    
    var title = document.createElement('h3');
    title.innerHTML = 'Players';
    title.style.marginTop = '0';
    
    var list = document.createElement('textarea');
    list.innerHTML = playerList;
    list.style.width = '100%';
    list.style.height = '200px';
    list.style.resize = 'none';
    
    var closeButton = document.createElement('button');
    closeButton.innerHTML = 'Close';
    closeButton.style.backgroundColor = '#4CAF50';
    closeButton.style.border = 'none';
    closeButton.style.color = '#fff';
    closeButton.style.padding = '8px 16px';
    closeButton.style.textAlign = 'center';
    closeButton.style.textDecoration = 'none';
    closeButton.style.fontSize = '14px';
    closeButton.style.marginTop = '20px';
    closeButton.style.cursor = 'pointer';
    
    closeButton.onclick = function() {
        document.body.removeChild(dialog);
    }
    
    dialog.appendChild(title);
    dialog.appendChild(list);
    dialog.appendChild(closeButton);
    
    document.body.appendChild(dialog);
}



function openForm(databaseName) {

  var overlay = document.getElementById("form-popup-overlay");
  var form = document.getElementById("myForm");

  var dbNameInput = form.querySelector("input[name='database_name']");
  dbNameInput.value = databaseName;

  overlay.style.display = "block";
  form.style.display = "block";
}

// Function to close the form
function closeForm(databaseName) {

  var overlay = document.getElementById("form-popup-overlay");
  var form = document.getElementById("myForm");
    
  overlay.style.display = "none";
  form.style.display = "none";
}

function openResultForm(matchId, databaseName) {
  // Get the result form and overlay elements
  var resultForm = document.getElementById("resultForm");
  var resultOverlay = document.getElementById("result-popup-overlay");

  // Set the match ID input value
  var matchIdInput = resultForm.querySelector("input[name='match_id']");
  matchIdInput.value = matchId;

  // Set the database name input value
  var dbNameInput = resultForm.querySelector("input[name='database_name']");
  dbNameInput.value = databaseName;

  // Show the result form and overlay
  resultForm.style.display = "block";
  resultOverlay.style.display = "block";
}


function closeResultForm() {
  document.getElementById("resultForm").style.display = "none";
  document.getElementById("result-popup-overlay").style.display = "none";
}
</script>