<?php

session_start();

    include "style.php";
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

$result = mysqli_query($conn_basketball, $sql);

if (!$result) {
  die("Error: " . $sql . "<br>" . mysqli_error($conn));
}

function getTeamColor($team_name) {
  switch ($team_name) {
    case "Red":
      return "Tomato";
    case "Blue":
      return "CornflowerBlue";
    case "Yellow":
      return "Gold";
    case "Green":
      return "MediumSeaGreen";
    default:
      return "white";
  }
}

echo "<table>";
echo "<img src='basketball.jpg' width='500' class='center' vspace='30'>";
echo "<h1 style='text-align: center; color:white; font-size:50px; font-family:verdana; text-shadow: 4px 4px black;'>Basketball Schedule</h1>";
echo "<tr><th>Match ID</th><th>Date</th><th>Time</th><th>Team 1</th><th>Players</th><th>Team 2</th><th>Players</th><th>Result</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr>";
  echo "<td>" . $row['match_id'] . "</td>";
  echo "<td>" . date("d F Y", strtotime($row['date'])) . "</td>";
  echo "<td>" . date("H:i", strtotime($row['time'])) . "</td>";
  echo "<td>" . " <span class='color-square' style='background-color:" . getTeamColor($row['team1_name']) . ";'></span></td>";
  echo "<td><button class='players-button' onclick=\"showTeamPlayers('" . $row['team1_players'] . "')\">View</button></td>";
  echo "<td>" . " <span class='color-square' style='background-color:" . getTeamColor($row['team2_name']) . ";'></span></td>";
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