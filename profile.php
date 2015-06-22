<?php include('inc/header.php'); ?>
 
   <header>
      <a class="logout" href="logout.php">Logout</a>
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