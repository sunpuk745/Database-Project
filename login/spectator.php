<?php

session_start();

    include("connection.php");
    include("function.php");

    $user_data = check_login($con);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    die;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Select Sport</title>
	<style>
		#box {
			position: absolute;
			width: 350px;
			top: 10%;
			left: 50%;
			transform: translateX(-50%);
			text-align: center;
			padding: 30px;
			border: 1px solid #ccc;
			border-radius: 5px;
			box-shadow: 15px 15px 1px #4B0082;
			background-color: #f9f9f9;

		}
		#button {
			font-size: 18px;
			font-family:verdana;
			width: 300px;
			padding: 15px 32px;
			border-radius: 5px;
			background-color: #FFD524;
			color: black;
			border: solid 2px black;
			cursor: pointer;
			margin-bottom: 10px;
		}
		#button:hover {
			background-color: #ECB602;
		}
		#logout-button {
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
		#logout-button:hover {
			background-color: darkred;
		}
		
		#logout-button:focus {
			outline: none;
			box-shadow: none;
		}
		#center {
			display: block;
			margin-left: auto;
			margin-right: auto;
		}
	</style>
</head>
	<form action="logout.php" method="post">
		<button id="logout-button" type="submit" name="logout">Logout</button>
	</form>

<body style="background-color:RebeccaPurple">
	<div id="box">
		
		<form method="post">
			<img src='sportsday.png' width='200' id='center' vspace='0'>
			<div style="font-size: 38px;margin-bottom: 10px;color: black; font-weight: bold; font-family:verdana; text-shadow: 2px 2px lightgrey;">Spectator</div>
			<div style="font-size: 20px;margin-bottom: 20px;color: black;; font-family:verdana;">Select Sport</div>

			<input id="button" type="submit" name="all" value="All Sports"><br>
			<input id="button" type="submit" name="football" value="Football"><br>
			<input id="button" type="submit" name="volleyball" value="Volleyball"><br>
			<input id="button" type="submit" name="basketball" value="Basketball"><br>
		</form>

		<?php
			if(isset($_POST['football'])) {
				header("Location: football_schedule.php");
				die;
			}
			else if(isset($_POST['volleyball'])) {
				header("Location: volleyball_schedule.php");
				die;
			}
			else if(isset($_POST['basketball'])) {
				header("Location: basketball_schedule.php");
				die;
			}
			else if(isset($_POST['all'])) {
				header("Location: all_schedule.php");
				die;
			}
		?>
		
	</div>

</body>
</html>
