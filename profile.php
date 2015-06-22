<?php require_once("inc/session.php"); 
require_once("inc/functions.php"); 
include('inc/db_connection.php'); 
?>
<?php $_SESSION['username']="Isobel"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BCB</title>
    <link rel="stylesheet" href="css/style.css">
    <link href='http://fonts.googleapis.com/css?family=Special+Elite|Carme|Flavors' rel='stylesheet' type='text/css'>
    <!--
    
    font-family: 'Special Elite', cursive;
    font-family: 'Carme', sans-serif;
    font-family: 'Flavors', cursive;
    
    -->
</head>
<body>
   <?php echo message(); ?> 
 
   <header>
  
    <h1> <?php echo $_SESSION['username']; ?></h1>
    </header> 
    <div id="page" class="container login">
    <div id="add_cig" >
    <h3>Reset Username and Password</h3>
    <form method="POST" action="#" >
       <input type="text" name="username" value="<?php echo $_SESSION['username']; ?>" placeholder="NEW USERNAME">
        <input type="password" name="old_pass" placeholder="OLD PASSWORD">
        <input type="password" name="new_pass" placeholder="NEW PASSWORD">
        <input type="password" name="confirm_pass" placeholder="CONFIRM NEW PASSWORD">
        <input type="submit" name="add" value="Save">
    </form>
     <br/>
    <br/>
    <br/>
    <a id="smoke_script" href="index.php">Cancel</a>
    
    </div>
    </div>
 
   
  
    
</body>
</html>