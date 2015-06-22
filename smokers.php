<?php include('inc/header.php'); ?>
 
   <header>
    <a class="username" href="profile.php"><?php echo $_SESSION['username']; ?></a>
    <a class="logout" href="logout.php">Logout</a>
    <h1 id="ashtray">Smokers</h1>
    <a class="orange" href="index.php">&laquo; Smoke One</a>
   <div id="days">
        <span><a href="index.php?ashtray">Day</a></span> 
        <span><a href="index.php?ashtray&month">Month</a></span>
        <span id="current"><a href="smokers.php">Smokers</a></span>
    </div> 
<!--    -->
    </header> 
    <div id="page" class="container login">

        
 <?php
    $sql = "SELECT * FROM friends WHERE user_id={$_SESSION['user_id']}";
	$result = mysqli_query($connection, $sql);
    if($result){
        $rows=mysqli_num_rows($result);
        if($rows>=1){
        echo "<div class=\"container\">";
        foreach ($result as $row) {
            $user=find_user_by_user_id($row['friend_id']);
            echo "<label class=\"smokers\">".$user['username']."</label><a href=\"#\"><i class=\"fa fa-times red\"></i></a><br/>";
        }//END FOREACH
        echo "</div>";
        }else{
            echo "<h4>You smoke alone.</h4";
        }
    }else{
        echo "<h4>You smoke alone.</h4";
    }
   
 
?>
   
   
    <h2>Add A Smoker</h2>
 
     <form action="#">
            <input type="text" placeholder="SEARCH USERS">
        </form>
        
<!--        <a id="cancel" href="smokers.php">cancel</a>-->
       
       <div id="results"></div>
    </div>
 
  
    
</body>
</html>