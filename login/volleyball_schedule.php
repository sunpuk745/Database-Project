<?php

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "volleyball_tournament";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Query the database for the match schedule with players
$sql = "SELECT matches.match_id, matches.date, matches.time, team1.team_name AS team1_name, team2.team_name AS team2_name, matches.result,
            GROUP_CONCAT(DISTINCT player1.player_name SEPARATOR ', ') AS team1_players,
            GROUP_CONCAT(DISTINCT player2.player_name SEPARATOR ', ') AS team2_players
            FROM matches
            INNER JOIN teams AS team1 ON matches.team_1 = team1.team_id
            INNER JOIN teams AS team2 ON matches.team_2 = team2.team_id
            INNER JOIN players AS player1 ON matches.team_1 = player1.team_id
            INNER JOIN players AS player2 ON matches.team_2 = player2.team_id
            GROUP BY matches.match_id
            ORDER BY matches.date, matches.time;
            ";

$result = mysqli_query($conn, $sql);

if (!$result) {
  die("Error: " . $sql . "<br>" . mysqli_error($conn));
}

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
</style>";

echo "<table>";
echo "<tr><th>Match ID</th><th>Date</th><th>Time</th><th>Team 1</th><th>Players</th><th>Team 2</th><th>Players</th><th>Result</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr>";
  echo "<td>" . $row['match_id'] . "</td>";
  echo "<td>" . $row['date'] . "</td>";
  echo "<td>" . $row['time'] . "</td>";
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