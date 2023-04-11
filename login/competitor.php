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

$player_filter = isset($_GET['player_filter']) ? $_GET['player_filter'] : '';
$date_filter = isset($_GET['date_filter']) ? $_GET['date_filter'] : '';

      
// fetch football schedules
$sql_football = "SELECT matches.match_id, matches.date, matches.time, team1.team_name AS team1_name, team2.team_name AS team2_name, matches.result,
                    GROUP_CONCAT(DISTINCT player1.player_name SEPARATOR ', ') AS team1_players,
                    GROUP_CONCAT(DISTINCT player2.player_name SEPARATOR ', ') AS team2_players
                    FROM matches
                    INNER JOIN teams AS team1 ON matches.team_1 = team1.team_id
                    INNER JOIN teams AS team2 ON matches.team_2 = team2.team_id
                    INNER JOIN players AS player1 ON matches.team_1 = player1.team_id
                    INNER JOIN players AS player2 ON matches.team_2 = player2.team_id";
                    if (isset($_GET['player_filter'])) {
                        $sql_football .= " WHERE player1.player_name LIKE '%$player_filter%' OR player2.player_name LIKE '%$player_filter%'";
                    }
                    if (isset($_GET['date_filter'])) {
                        $sql_football .= "  WHERE matches.date = '$date_filter'";
                    }

    $sql_football .= " GROUP BY matches.match_id
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
                    INNER JOIN players AS player2 ON matches.team_2 = player2.team_id";
                    if (isset($_GET['player_filter'])) {
                        $sql_volleyball .= " WHERE player1.player_name LIKE '%$player_filter%' OR player2.player_name LIKE '%$player_filter%'";
                    }
                    if (isset($_GET['date_filter'])) {
                        $sql_volleyball .= "  WHERE matches.date = '$date_filter'";
                    }

    $sql_volleyball .= " GROUP BY matches.match_id
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
                    INNER JOIN players AS player2 ON matches.team_2 = player2.team_id";
                    if (isset($_GET['player_filter'])) {
                        $sql_basketball .= " WHERE player1.player_name LIKE '%$player_filter%' OR player2.player_name LIKE '%$player_filter%'";
                    }
                    if (isset($_GET['date_filter'])) {
                        $sql_basketball .= "  WHERE matches.date = '$date_filter'";
                    }

                        $sql_basketball .= " GROUP BY matches.match_id
                                ORDER BY matches.date, matches.time;";
$result_basketball = mysqli_query($conn_basketball, $sql_basketball);


// Display the match schedule in a table format
echo "<style>
table {
    margin: auto;
    border-collapse: collapse;
    width: 80%;
    background-color: white;
  }
  th, td {
    padding: 18px;
    text-align: center;
    border-bottom: 1px solid #ddd;
    font-family:verdana;
  }
  th {
    background-color: black;
    color: white;
  }
  .players-button {
    background-color: #FFD524;
    border: none;
    color: black;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    font-weight: bold;
    border-radius: 5px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s ease;
  }
  .players-button:hover {
    background-color: #ECB602;
  }
  .players-button:focus {
    outline: none;
    box-shadow: 0px 0px 5px #4CAF50;
  }
  div {
    display: flex;
    justify-content: center;
    align-items: center;
    padding-top: 30px;
  }
  .center {
    display: block;
    margin-left: auto;
    margin-right: auto;
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
  .filter-form {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    margin: 20px 0;
  }
  .filter-form select {
    font-size: 16px;
    padding: 10px;
    border-radius: 5px;
    border: 2px solid #008CBA;
    }
  .filter-form label {
    font-size: 18px;
    margin-right: 10px;
  }
  .filter-form input[type=text] {
    font-size: 16px;
    padding: 10px;
    border-radius: 5px;
    border: 2px solid #008CBA;
  }
  .filter-form input[type=date] {
    padding: 10px;
    border: 2px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
  }
  .filter-form button[type=submit] {
    background-color: #3498db;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
  } 
  .filter-form button[type=submit]:hover {
    background-color: #2980b9;
  }
  .filter-form input[type=date]:focus {
    outline: none;
    border-color: #2980b9;
  }
</style>";
// display the schedules
echo "<img src='sportsday.png' width='500' class='center' vspace='30'>";
echo "<h1 style='text-align: center; color:white; font-size:50px; font-family:verdana; text-shadow: 4px 4px black;'>Competitor Schedule</h1>";

echo "<form method='get' class='filter-form' style='text-align: center;'>
        <label for='player_filter' style='color: white';>กรองโดยชื่อนักกีฬา :</label>
        <input type='text' id='player_filter' name='player_filter' value='$player_filter' placeholder='กรอกชื่อนักกีฬา'>
        <button type='submit' style='margin-left: 10px; background-color: #FFD524; color: black;'>กรอง</button>
      </form>";

echo "<form method='get' class='filter-form' style='text-align: center;'>
        <label for='player_filter' style='color: white';>กรองโดยชื่อนักกีฬา:</label>
        <select id='player_filter' name='player_filter'>
            <option value=''>--ทุกนักกีฬา--</option>";
            $sql_players = "SELECT DISTINCT player_name FROM (
                                SELECT player_name FROM football_tournament.players
                                UNION
                                SELECT player_name FROM volleyball_tournament.players
                                UNION
                                SELECT player_name FROM basketball_tournament.players
                            ) AS all_players ORDER BY player_name;";
            $result_players = mysqli_query($conn_football, $sql_players);
            while ($row_players = mysqli_fetch_assoc($result_players)) {
                $player_name = $row_players['player_name'];
                $selected = ($player_filter == $player_name) ? 'selected' : '';
                echo "<option value=\"$player_name\" $selected>$player_name</option>";
            }
echo "</select>
<button type='submit' style='margin-left: 10px; background-color: #FFD524; color: black;'>กรอง</button>
        </form>";

echo "<form method='get' class='filter-form' style='text-align: center;'>
        <label for='date_filter' style='color: white';>วันที่:</label>
        <input type='date' id='date_filter' name='date_filter' value='$date_filter'>
        <button type='submit' style='margin-left: 10px; background-color: #FFD524; color: black;'>กรอง</button>
      </form>";

// display football schedules
echo "<h2 style='text-align: center; color:white; font-size:25px; font-family:verdana; text-shadow: 4px 4px black;'>Football Schedule</h2>";
echo "<table>";
echo "<tr><th>Match ID</th><th>Date</th><th>Time</th><th>Team 1</th><th>Players</th><th>Team 2</th><th>Players</th><th>Result</th></tr>";

while ($row = mysqli_fetch_assoc($result_football)) {
    echo "<tr>";
    echo "<td>" . $row['match_id'] . "</td>";
    echo "<td>" . date("d F Y", strtotime($row['date'])) . "</td>";
    echo "<td>" . date("H:i", strtotime($row['time'])) . "</td>";
    echo "<td>" . $row['team1_name'] . "</td>";
    echo "<td><button class='players-button' onclick=\"showTeamPlayers('" . $row['team1_players'] . "')\">View</button></td>";
    echo "<td>" . $row['team2_name'] . "</td>";
    echo "<td><button class='players-button' onclick=\"showTeamPlayers('" . $row['team2_players'] . "')\">View</button></td>";
    echo "<td>" . $row['result'] . "</td>";
    echo "</tr>";
}

echo "</table>";

// display volleyball schedules
echo "<h2 style='text-align: center; color:white; font-size:25px; font-family:verdana; text-shadow: 4px 4px black;'>Volleyball Schedule</h2>";
echo "<table>";
echo "<tr><th>Match ID</th><th>Date</th><th>Time</th><th>Team 1</th><th>Players</th><th>Team 2</th><th>Players</th><th>Result</th></tr>";

while ($row = mysqli_fetch_assoc($result_volleyball)) {
    echo "<tr>";
    echo "<td>" . $row['match_id'] . "</td>";
    echo "<td>" . date("d F Y", strtotime($row['date'])) . "</td>";
    echo "<td>" . date("H:i", strtotime($row['time'])) . "</td>";
    echo "<td>" . $row['team1_name'] . "</td>";
    echo "<td><button class='players-button' onclick=\"showTeamPlayers('" . $row['team1_players'] . "')\">View</button></td>";
    echo "<td>" . $row['team2_name'] . "</td>";
    echo "<td><button class='players-button' onclick=\"showTeamPlayers('" . $row['team2_players'] . "')\">View</button></td>";
    echo "<td>" . $row['result'] . "</td>";
    echo "</tr>";
}

echo "</table>";

// display basketball schedules
echo "<h2 style='text-align: center; color:white; font-size:25px; font-family:verdana; text-shadow: 4px 4px black;'>Basketball Schedule</h2>";
echo "<table>";
echo "<tr><th>Match ID</th><th>Date</th><th>Time</th><th>Team 1</th><th>Players</th><th>Team 2</th><th>Players</th><th>Result</th></tr>";

while ($row = mysqli_fetch_assoc($result_basketball)) {
    echo "<tr>";
    echo "<td>" . $row['match_id'] . "</td>";
    echo "<td>" . date("d F Y", strtotime($row['date'])) . "</td>";
    echo "<td>" . date("H:i", strtotime($row['time'])) . "</td>";
    echo "<td>" . $row['team1_name'] . "</td>";
    echo "<td><button class='players-button' onclick=\"showTeamPlayers('" . $row['team1_players'] . "')\">View</button></td>";
    echo "<td>" . $row['team2_name'] . "</td>";
    echo "<td><button class='players-button' onclick=\"showTeamPlayers('" . $row['team2_players'] . "')\">View</button></td>";
    echo "<td>" . $row['result'] . "</td>";
    echo "</tr>";
}

echo "</table>";

?>

<form action="logout.php" method="post">
    <button class="logout-button" type="submit" name="logout">Logout</button>
  </form>

<body style="background-color:RebeccaPurple">
    <script>
        function showTeamPlayers(players) {
      var playersArray = players.split(', ');
      
      var dialog = document.createElement('div');
      dialog.style.width = '600px';
      dialog.style.height = 'auto';
      dialog.style.backgroundColor = '#FFD524';
      dialog.style.border = '1px solid #ccc';
      dialog.style.borderRadius = '5px';
      dialog.style.padding = '20px';
      dialog.style.position = 'fixed';
      dialog.style.top = '50%';
      dialog.style.left = '50%';
      dialog.style.transform = 'translate(-50%, -50%)';
      dialog.style.zIndex = '9999';
      
      var table = document.createElement('table');
      table.style.width = '100%';
      table.style.borderCollapse = 'collapse';
      
      var headerRow = document.createElement('tr');
      var headerCell1 = document.createElement('th');
      headerCell1.innerHTML = 'No.';
      var headerCell2 = document.createElement('th');
      headerCell2.innerHTML = 'Player Name';
      headerRow.appendChild(headerCell1);
      headerRow.appendChild(headerCell2);
      table.appendChild(headerRow);
      
      for (var i = 0; i < playersArray.length; i++) {
        var row = document.createElement('tr');
        
        var cell1 = document.createElement('td');
        cell1.innerHTML = i+1;
        row.appendChild(cell1);
        
        var cell2 = document.createElement('td');
        cell2.innerHTML = playersArray[i];
        row.appendChild(cell2);
        
        table.appendChild(row);
      }
      
      dialog.appendChild(table);
      
      var closeButton = document.createElement('button');
      closeButton.innerHTML = 'Close';
      closeButton.style.backgroundColor = '#FF5733';
      closeButton.style.border = 'none';
      closeButton.style.color = '#fff';
      closeButton.style.padding = '8px 16px';
      closeButton.style.textAlign = 'center';
      closeButton.style.textDecoration = 'none';
      closeButton.style.fontSize = '14px';
      closeButton.style.marginTop = '20px';
      closeButton.style.cursor = 'pointer';
      closeButton.style.borderRadius = '5px';
      
      closeButton.addEventListener('mouseover', function() {
          closeButton.style.backgroundColor = '#f44336';
      });
      
      closeButton.addEventListener('mouseout', function() {
          closeButton.style.backgroundColor = '#FF5733';
      });
          
      closeButton.onclick = function() {
        document.body.removeChild(dialog);
      }
      
      var closeButtonContainer = document.createElement('div');
      closeButtonContainer.style.width = '100%';
      closeButtonContainer.style.position = 'fixed';
      closeButtonContainer.style.bottom = '-40px';
      closeButtonContainer.style.left = '0';
      closeButtonContainer.style.right = '0';
      closeButtonContainer.style.textAlign = 'center';
      
      closeButtonContainer.appendChild(closeButton);
      dialog.appendChild(closeButtonContainer);
      
      document.body.appendChild(dialog);
      }

    </script>
</body>