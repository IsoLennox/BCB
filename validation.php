<?php require_once("inc/db_connection.php"); 
 
if(isset($_GET['username'])){
    
    //Gets username value from the URL
$username = $_GET['username'];
  
        //Checks if the username is available or not
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($connection, $query);
        //Prints the result
        if (mysqli_num_rows($result)<1) {
            echo "<span class='green'>No Users With That Username</span>";
            $submit = " <input type=\"submit\" name=\"submit\" value=\"Continue\" />";
            return $submit;
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
            $submit = "Please Enter Valid username";
           return $submit;
        }
     
}//end validate username

if(isset($_GET['new_username'])) {
    $new_username = $_GET['new_username'];
    $sql = "SELECT * FROM users WHERE username='{$new_username}'";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result)<1) {
        echo "valid";
        return;
    } else {
        echo "taken";
        return;
    }
}


if(isset($_GET['forgotemail'])){
    
        //Gets email value from the URL
        $email = $_GET['forgotemail'];
        //Checks if the email is available or not
        $query = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($connection, $query);
        //Prints the result
        if (mysqli_num_rows($result)<1) { 
            echo "<span class='red'><strong>Email '".$email."' Is Not Connected An Account!<strong></span>";
        } else{
            echo "<span class='green'>There you are!</span>";
        }
}//end validate email
?> 