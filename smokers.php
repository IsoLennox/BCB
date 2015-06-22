<?php require_once("inc/session.php"); 
require_once("inc/functions.php"); 
include('inc/db_connection.php'); 
?>
<?php $_SESSION['username']="Isobel"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BCB Smokers</title>
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
    <a class="left username" href="profile.php"><?php echo $_SESSION['username']; ?></a>
    <h1 id="ashtray">Smokers</h1>
    <a class="orange" href="index.php">&laquo; Smoke One</a>
   <div id="days">
        <span><a href="index.php?ashtray">Day</a></span> 
        <span><a href="index.php?ashtray&month">Month</a></span>
        <span id="current"><a href="smokers.php">Smokers</a></span>
    </div> 
<!--    -->
    </header> 
    <div id="page">
         <?php

    $sql = "SELECT * FROM friends WHERE user_id={$_SESSION['user_id']}";
	$result = mysqli_query($connection, $sql);
    if($result){
        echo "<div class=\"container\">";
        foreach ($result as $row) {
            echo $row['friend_id']."<br/>";
        }//END FOREACH
        echo "</div>";
    }else{
        echo "<h4>You smoke alone.</h4";
    }
?>
    </div>
 
  
    
</body>
</html>