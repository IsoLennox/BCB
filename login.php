<?php require_once("inc/session.php");
require_once("inc/functions.php");
include('inc/db_connection.php');
?>

<?php

$userName = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

	$userName = $_POST["username"];
	$password = $_POST["password"];

	$found_user = attempt_login($username, $password);

	if ($found_user) {
		//Success - set session variables
		$_SESSION["user_id"] = $found_user["id"];
		$_SESSION["username"] = $found_user["username"];
		redirect_to("index.php");
	} else {
		//failure - show error message
		$_SESSION["message"] = "Username or password not found.  No smokes for you!";
		redirect_to("login.php");
	}
}

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BCB Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link href='http://fonts.googleapis.com/css?family=Special+Elite|Carme|Flavors' rel='stylesheet' type='text/css'>
</head>
<body>
  <div id="page" class="container">
   <h1>Login</h1>
   <form action="#">
       <input type="text" name="username" placeholder="USERNAME">
       <input type="password" name="password" placeholder="PASSWORD">
       <input type="submit" name="login" value="Smoke">
   </form>
     
   <a id="smoke_script" href="register.php">New Smoker</a>
     
    </div>
</body>
</html>