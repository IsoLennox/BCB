<?php require_once("inc/session.php");
require_once("inc/functions.php");
include('inc/db_connection.php');
 

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  echo "posted";
  $username = $_POST["username"];
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

  $sql = "INSERT INTO users (username, password) VALUES ('{$username}', '{$password}')";

  $result = mysqli_query($connection, $sql);

  if ($result) {
    //success
    $_SESSION["message"] = "Smoker created";
    redirect_to("login.php");
  } else {
    //failure
    $_SESSION["message"] = "Smoker creation failed";
    redirect_to("register.php");
  }
}


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BCB New User</title>
    <link rel="stylesheet" href="css/style.css">
    <link href='http://fonts.googleapis.com/css?family=Special+Elite|Carme|Flavors' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
  <div id="page" class="container login">
   <h1><label for="New Smoker">New Smoker</label></h1>
   <?php echo message(); ?>
      <form action="#" method="POST">
       <!-- <p> -->
       <input type="text" name="username" id="username" placeholder="USERNAME">

       <span id="username_result"></span>
       <!-- </p> -->
       <input type="password" name="password" placeholder="PASSWORD">
       <input type="password" name="confirmpassword" placeholder="CONFIRM PASSWORD">
       <input type="submit" id="submit" name="login" value="Smoke">
       <script>
         $(document).ready(function() {
          $("#username").keyup(function(e) {
            var username = $(this).val();
            if (username == "") {
              $("#username_result").html("");
            } else {
              $.ajax({
                url: "validation.php?new_username="+username,
                dataType: "text"}).done(function(valid) {
                  if (valid == "valid") {
                    $("#username_result").html("<span class=\"available\">Available!</span>");
                    $("input[type=submit]").attr("disabled", false);
                  } else {
                    $("#username_result").html("<span class=\"taken\">Already a smoker</span>");
                    $("input[type=submit]").attr("disabled", true);
                  }
              });
            }
          });
       });
       </script>
   </form>
   
      <a id="smoke_script" href="login.php">Cancel</a>
    </div>
</body>
</html>