<?php include('inc/header.php'); ?>
 
   <header>
    <a class="username" href="profile.php"><?php echo $_SESSION['username']; ?></a>
    <a class="logout" href="logout.php">Logout</a>
    <h1 id="ashtray">Smokers</h1>
    <a href="index.php">&laquo; Smoke One</a>
   <div id="days">
        <span><a href="index.php?ashtray">Day</a></span> 
        <span><a href="index.php?ashtray&month">Month</a></span>
        <span id="current"><a href="smokers.php">Smokers</a></span>
    </div> 
<!--    -->
    </header> 
    <div id="page" class="container login">
        
        <?php
if(isset($_GET['add'])){
    $user_id=$_GET['add'];
    
            $this_user = "SELECT * FROM friends WHERE user_id={$_SESSION['user_id']} AND friend_id={$user_id}";
            $this_user_result = mysqli_query($connection, $this_user);
            if($this_user_result){
                $rows=mysqli_num_rows($this_user_result);
                if($rows >=1){
                    echo "Already a friend";
                }else{
                    $query  = "INSERT INTO friends (";
                    $query .= " user_id, friend_id ";
                    $query .= ") VALUES (";
                    $query .= " {$_SESSION['user_id']}, {$user_id}";
                    $query .= ") ";
                    $cigarette_added = mysqli_query($connection, $query);


                    if ($cigarette_added) { 
                        // Success
//                        $_SESSION["message"] = "Smoker Added!"; 
                        redirect_to("smokers.php");
                    } else {
                        // Failure
                        $_SESSION["message"] = "This smoker could not join you";
                        redirect_to("smokers.php");
                    }//END UPDATE TODAYS LOG
                }
            }else{
                echo "This person is not your friend";
            }
}//END ADD


if(isset($_GET['remove'])){
    $user_id=$_GET['remove'];
    
            $this_user = "DELETE FROM friends WHERE user_id={$_SESSION['user_id']} AND friend_id={$user_id} LIMIT 1";
            $this_user_result = mysqli_query($connection, $this_user);
            if($this_user_result){
//                $_SESSION["message"] = "Smoker Removed"; 
                redirect_to("smokers.php");

            }else{
//                $_SESSION["message"] = "Can't remove this smoker"; 
                redirect_to("smokers.php");
            }

}//END REMOVE
 
    $sql = "SELECT * FROM friends WHERE user_id={$_SESSION['user_id']}";
	$result = mysqli_query($connection, $sql);
    if($result){
        $rows=mysqli_num_rows($result);
        if($rows>=1){
        echo "<div class=\"container\">";
        foreach ($result as $row) {
            $user=find_user_by_user_id($row['friend_id']);
            echo "<label class=\"smokers\">".$user['username']."</label><a href=\"smokers.php?remove=".$user['id']."\"><i class=\"fa fa-times red\"></i></a><br/>";
        }//END FOREACH
        echo "</div>";
        }else{
            echo "<h4>You smoke alone.</h4";
        }
    }else{
        echo "<h4>You smoke alone.</h4";
    }
   
 
?>
   <br/>
   <hr/>
   <br/>
    <h2>Add A Smoker</h2>
     <form action="smokers.php" method="POST">
<!--            <input onkeyup="findFriend(); return false;" name="username" id="username" type="text" placeholder="SEARCH USERS"> -->
            <input name="username" id="username" type="text" placeholder="SEARCH USERS"> 
            <input type="submit" name="find" value="Find Smoker">
        </form> 
        <br>
        <br>
        <br>
<!--      <div id="eavailability"></div>-->
      
      <?php
        if(isset($_POST['find'])){
            
            $username = $_POST['username'];
  
        //Checks if the username is available or not
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($connection, $query);
        //Prints the result
        if (mysqli_num_rows($result)<1) {
            echo "<span class='green'>No Users With That Username</span>";
           
        }else{
            $user=mysqli_fetch_assoc($result); 
            $this_user = "SELECT * FROM friends WHERE user_id={$_SESSION['user_id']} AND friend_id={$user['id']}";
            $this_user_result = mysqli_query($connection, $this_user);
            if($this_user_result){
                $rows=mysqli_num_rows($this_user_result);
                if($rows >=1){
                    $add="";
                }else{
                $add="<a href=\"smokers.php?add=".$user['id']."\"><i class=\"fa fa-user-plus\"></i></a>";
                }
            }else{
                $add="<a href=\"smokers.php?add=".$user['id']."\"><i class=\"fa fa-user-plus\"></i></a>";
            }
        
        
             echo "<label class=\"smokers\">".$username."</label>".$add."<br/>";
           
        }
            
            
        
        
        }
        ?>
    </div>
    <script>
         
//        function findFriend(){
//               $(document).ready(function () {
//            $("#username").keyup(function () {
//              var username = $(this).val();
//                $.ajax({
//                  url: "validation.php?username="+username
//                }).done(function( data ) {
//                  $("#eavailability").html(data);
//                });   
//
//            });
//          });
//
//        }         
    </script>
 
  
    
</body>
</html>