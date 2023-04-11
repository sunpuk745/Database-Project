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

echo "<img src='sportsday.png' width='500' class='center' vspace='30'>";
echo "<h1 style='text-align: center; color:white; font-size:50px; font-family:verdana; text-shadow: 4px 4px black;'>Competitor Schedule</h1>";

echo "<div class='box_filter'>
      <form method='get' class='filter-form' style='text-align: center;'>
        <label for='player_filter' style='color: black';>กรองโดยชื่อนักกีฬา :</label>
        <input type='text' id='player_filter' name='player_filter' value='$player_filter' placeholder='กรอกชื่อนักกีฬา'>
        <button type='submit'>กรอง</button>
      </form>";

echo "<form method='get' class='filter-form' style='text-align: center;'>
        <label for='player_filter' style='color: black';>กรองโดยเลือกนักกีฬา:</label>
        <select id='player_filter' name='player_filter'>
            <option value=''>-- นักกีฬาทุกคน --</option>";
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

echo "<form method='get' class='filter-form' style='text-align: center;'>
        <label for='date_filter' style='color: black';>วันที่:</label>
        <input type='date' id='date_filter' name='date_filter' value='$date_filter'>
        <button type='submit'>กรอง</button>
      </form>
      </div>";

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