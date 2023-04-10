<?php
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
</style>";
// display the schedules
echo "<h1 style='text-align: center;'>All Sports Schedule</h1>";

echo "<form method='get' style='text-align: center;'>
        <label for='player_filter'>กรองโดยชื่อนักกีฬา :</label>
        <input type='text' id='player_filter' name='player_filter' value='$player_filter' placeholder='กรอกชื่อนักกีฬา'>
        <button type='submit'>กรอง</button>
      </form>";

echo "<form method='get' style='text-align: center;'>
        <label for='player_filter'>กรองโดยชื่อนักกีฬา:</label>
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
        <button type='submit'>กรอง</button>
        </form>";

echo "<form method='get' style='text-align: center;'>
        <label for='date_filter'>วันที่:</label>
        <input type='date' id='date_filter' name='date_filter' value='$date_filter'>
        <button type='submit'>กรอง</button>
      </form>";

// display football schedules
echo "<h2 style='text-align: center;'>Football Schedule</h2>";
echo "<table>";
echo "<tr><th>Match ID</th><th>Date</th><th>Time</th><th>Team 1</th><th>Players</th><th>Team 2</th><th>Players</th><th>Result</th></tr>";

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
    echo "</tr>";
}

echo "</table>";

// display volleyball schedules
echo "<h2 style='text-align: center;'>Volleyball Schedule</h2>";
echo "<table>";
echo "<tr><th>Match ID</th><th>Date</th><th>Time</th><th>Team 1</th><th>Players</th><th>Team 2</th><th>Players</th><th>Result</th></tr>";

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
    echo "</tr>";
}

echo "</table>";

// display basketball schedules
echo "<h2 style='text-align: center;'>Basketball Schedule</h2>";
echo "<table>";
echo "<tr><th>Match ID</th><th>Date</th><th>Time</th><th>Team 1</th><th>Players</th><th>Team 2</th><th>Players</th><th>Result</th></tr>";

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
    echo "</tr>";
}

echo "</table>";

?>
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

</script>