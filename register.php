<?php require_once("inc/session.php");
require_once("inc/functions.php");
require_once ("inc/validation_functions.php");
include('inc/db_connection.php');
 

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  //validation
  $username = mysql_prep($_POST["username"]);
  $password = mysql_prep($_POST["password"]);
  $confirm_password = mysql_prep($_POST["confirm_password"]);

  $required_fields = ["username", "password", "confirm_password"];
  validate_presences($required_fields);

  validate_confirm_password($password, $confirm_password);

  if (empty($errors)) {
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
  } else {
    $_SESSION["errors"] = $errors;
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
   <?php 
      $errors = errors();
      echo form_errors($errors);
     ?>
      <form action="#" method="POST">
       <!-- <p> -->
       <input type="text" name="username" id="username" placeholder="USERNAME">

       <span id="username_result"></span>
       <!-- </p> -->
       <input type="password" name="password" id="password" placeholder="PASSWORD">
       <input type="password" id="confirm_password" name="confirm_password" placeholder="CONFIRM PASSWORD">
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
                dataType: "text"}).done(function(available) {
                  if (available == "valid") {
                    $("#username_result").html("<span class=\"available\">Available!</span>");
                  } else {
                    $("#username_result").html("<span class=\"taken\">Already a smoker</span>");
                  } //end else
              }); //end .done()
            } //end else
          }); //end keyup
       }); //end document ready
       </script>
   </form>
   
      <a id="smoke_script" href="login.php">Cancel</a>
    </div>
</body>
</html>