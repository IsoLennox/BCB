<?php require_once("inc/session.php");
require_once("inc/functions.php");
require_once ("inc/validation_functions.php");
include('inc/db_connection.php');
 

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  //validation
  $username = mysql_prep($_POST["username"]);
  $email = mysql_prep($_POST["email"]);
  $password = mysql_prep($_POST["password"]);
  $confirm_password = mysql_prep($_POST["confirm_password"]);

  $required_fields = ["username", "email", "password", "confirm_password"];
  validate_presences($required_fields);

  validate_confirm_password($password, $confirm_password);

  if (empty($errors)) {
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password, email) VALUES ('{$username}', '{$password}', '{$email}')";

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

       <input type="text" maxlength="15" autocomplete="off" name="username" id="username" placeholder="USERNAME">

       <div id="username_result">
        <div class="need_username">Username required</div>
         <div class="available">Available!</div>
         <div class="taken">Already a smoker</div>
       </div>

      <input type="email" maxlength="40" autocomplete="off" name="email" id="email" placeholder="EMAIL">

       <input type="password" name="password" id="password" placeholder="PASSWORD">
       <input type="password" id="confirm_password" name="confirm_password" placeholder="CONFIRM PASSWORD">
       <input type="submit" id="submit" name="login" value="Smoke">
       <script>
         $(document).ready(function() {
          $("#username").keyup(function(e) {
            var username = $(this).val();

            $("#username_result").css("height","43px");

            if (username == "") {
              $(".available, .taken").fadeOut();
              $(".need_username").fadeIn();
            } else {
              $.ajax({
                url: "validation.php?new_username="+username,
                dataType: "text"}).done(function(available) {
                  if (available == "valid") {
                    $(".need_username, .taken").fadeOut();
                    $("div.available").fadeIn();
                  } else {
                    $(".available, .need_username").fadeOut();
                    $("div.taken").fadeIn();
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