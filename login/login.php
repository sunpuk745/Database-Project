<?php 

session_start();

	include("connection.php");
	include("function.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];

		if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
		{

			//read from database
			$query = "select * from users where user_name = '$user_name' limit 1";
			$result = mysqli_query($con, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{

					$user_data = mysqli_fetch_assoc($result);
					
					if($user_data['password'] === $password)
					{

						$_SESSION['user_id'] = $user_data['user_id'];
						
						if($user_name == 'organizer')
						{
							header("Location: organizer.php");
							die;
						}
						else if($user_name == 'competitor')
						{
							header("Location: competitor.php");
							die;
						}
						else
						{
							header("Location: spectator.php");
							die;
						}
					}
				}
			}
			echo "<script>alert('Incorrect username or password!');</script>";
		}else
		{
			echo "<script>alert('Please enter valid information!');</script>";;
		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body style="background-color:RebeccaPurple">

	<style type="text/css">
	#title {
		margin-top: 15px;
		margin-bottom: 30px;
		text-align: center;
		font-size: 30px;
		font-family:Sans-Serif;
		letter-spacing: 2px;
		font-weight: bold;
		color: black;

	}
	
	#text{
		height: 25px;
		border-radius: 5px;
		padding: 4px;
		border: solid thin #aaa;
		width: 95%;
	}

	#button{
		margin: auto;
		padding: 10px;
		width: 80px;
		color: black;
		background-color: #FFD524;
		border: solid 1px black;
		border-radius: 10px;
	}
	#button:hover {
		background-color: #ECB602;
	}

	#box{
		background-color: white;
		margin: auto;
		height: 500px;
		width: 300px;
		padding: 20px;
		margin-top: 80px;
		border-radius: 20px;
		box-shadow: 15px 15px 1px #4B0082;
	}
	#center {
		display: block;
		margin-left: auto;
		margin-right: auto;
	}

	</style>

	
	<div id="box">
		<img src='sportsday.png' width='200' id='center' vspace='30'>
		<form method="post">
			<div id="title">Login</div>
			<input id="text" type="text" name="user_name" placeholder="Username" onfocus="this.placeholder=''" onblur="this.placeholder='Enter your username'"><br><br>
			<input id="text" type="password" name="password" placeholder="Password" onfocus="this.placeholder=''" onblur="this.placeholder='Enter your password'"><br><br><br>
			<input id="button" type="submit" value="Login"><br><br>
		</form>
	</div>
</body>
</html>