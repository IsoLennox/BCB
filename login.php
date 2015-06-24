<?php require_once("inc/session.php");
require_once("inc/functions.php");
include('inc/db_connection.php');
?>

<?php

$username = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

	$username = $_POST["username"];
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
 <header>
      <h1 id="ashtray">Break The Camel's Back</h1>
 </header>
  <div id="page" class="container login">
  
   <h1><label for="Login">Login</label></h1>
   <?php echo message(); ?>
   <form class="login" action="#" method="POST">
       <input type="text" name="username" placeholder="USERNAME">
       <input type="password" name="password" placeholder="PASSWORD">
       <input type="submit" name="login" value="Smoke">
   </form>
     <br>
     <br>
     <br>
 <a id="smoke_script" href="register.php">New Smoker</a> 
     
    </div>
</body>
</html>