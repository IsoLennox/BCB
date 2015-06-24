<?php include('inc/header.php'); ?>
 <?php
    
    if (isset($_POST['submit'])) {
        
    $user_query  = "SELECT * FROM users WHERE id={$_SESSION['user_id']}";  
    $user_result = mysqli_query($connection, $user_query);
    $num_rows=mysqli_num_rows($user_result);
    if($num_rows >= 1){
        $user_data=mysqli_fetch_assoc($user_result); 
        $stored_pass=$user_data['password'];
 
    } 
        
    $old_pass = mysql_prep($_POST["old_pass"]);
        
        
    if (password_verify($old_pass, $stored_pass)){
		
            //old password matched current password
            $hashed_password = password_hash($_POST["new_pass"], PASSWORD_DEFAULT);
            $first_password = $_POST["new_pass"];
            $confirmed_password = $_POST["confirm_pass"];
  
   if(!empty($first_password) && !empty($confirmed_password)){
            if($first_password===$confirmed_password){
                //new passwords match
                //perform update with $hashed_pass
                
    $update_pass  = "UPDATE users SET ";
    $update_pass .= "password = '{$hashed_password}' ";
    $update_pass .= "WHERE id = {$_SESSION['user_id']} ";
    $result = mysqli_query($connection, $update_pass);
    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
        
        //CHANGE USERNAME
        
                      
    $update_username  = "UPDATE users SET ";
    $update_username .= "username = '{$_POST['username']}' ";
    $update_username .= "WHERE id = {$_SESSION['user_id']} ";
    $usernameresult = mysqli_query($connection, $update_username);
    if ($usernameresult && mysqli_affected_rows($connection) == 1) {
      // Success
            $_SESSION["message"] = "Username and Password Updated! ";
            $_SESSION['username']=$_POST['username'];
                redirect_to("profile.php");
    } else {
      // Failure
                $_SESSION["message"] = "Password Changed. Username Not Updated";
                redirect_to("profile.php");
    }//END UPDATE ACCOUNT
        
        
                
    } else {
      // Failure
                $_SESSION["message"] = "Password Update Failed!";
                redirect_to("profile.php");
    }//END UPDATE ACCOUNT
                


            }else{
                $_SESSION["message"] = "Passwords Do Not Match!";
                redirect_to("profile.php");
            }//end update new password
        
    }else{
       $_SESSION["message"] = "Passwords Cannot be blank!";
                      redirect_to("profile.php");
 
        }  
            }else{
                $_SESSION["message"] = "Old Password Incorrect";
                      redirect_to("profile.php");
            }//end if old password is correct current password
    }//end submit new password

?>
   <header>
      <a class="logout" href="logout.php">Logout</a>
    <h1> <?php echo $_SESSION['username']; ?></h1>
    </header> 
    <div id="page" class="container login">
    
         <?php echo message(); ?>
    <div id="add_cig" >
    <h3>Reset Username and Password</h3>
    <form method="POST" action="profile.php" >
       <input type="text" name="username" value="<?php echo $_SESSION['username']; ?>" placeholder="NEW USERNAME">
        <input type="password" name="old_pass" placeholder="OLD PASSWORD">
        <input type="password" name="new_pass" placeholder="NEW PASSWORD">
        <input type="password" name="confirm_pass" placeholder="CONFIRM NEW PASSWORD">
        <input type="submit" name="submit" value="Save">
    </form>
     <br/>
    <br/>
    <br/>
    <a id="smoke_script" href="index.php">Cancel</a>
    
    </div>
    </div>
 
   
  
    
</body>
</html>