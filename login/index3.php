<?php
session_start();

    include("connection.php");
    include("function.php");

    $user_data = check_login($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Sport Website</title>
</head>
<body>

    <a href="logout.php">Logout</a>
    <h1>This is index page</h1>
    
    <br>
    Hello, HELLO.
</body>
</html>