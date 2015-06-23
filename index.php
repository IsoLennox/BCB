<?php include('inc/header.php');

if(isset($_GET['ashtray'])){
    
    //<span><a href=\"index.php?ashtray&week\">Week</a></span> 
    
    ?>
    <header>
    <a class="left username" href="profile.php"><?php echo $_SESSION['username']; ?></a>
    <a class="logout" href="logout.php">Logout</a>
    <h1 id="ashtray">The Ashtray</h1>
    <a href="index.php">&laquo; Smoke One</a>
 

    <?php


//ASHTRAY
    
    if(isset($_GET['week'])){
    
//WEEK VIEW 
echo "<div id=\"days\">
        <span><a href=\"index.php?ashtray\">Day</a></span> 
        <span><a href=\"index.php?ashtray&month\">Month</a></span>
        <span><a href=\"smokers.php\">Smokers</a></span>
    </div>
    </header>
    <div id=\"page\">";
        	 echo "NOT WORKING";

    }elseif(isset($_GET['month'])){
    
    //MONTH VIEW
echo "<div id=\"days\">
        <span><a href=\"index.php?ashtray\">Day</a></span>
        <span id=\"current\"><a href=\"index.php?ashtray&month\">Month</a></span>
        <span><a href=\"smokers.php\">Smokers</a></span>
    </div> </header><div id=\"page\">"; 
    $sql = "SELECT * FROM log GROUP BY year, month ORDER BY year DESC, month DESC, day DESC";
	$result = mysqli_query($connection, $sql);
 
        
        foreach ($result as $row) { 
            
            //seelct all where month and year == this , count++
    $total_sql = "SELECT * FROM log WHERE month='{$row['month']}' and year={$row['year']}";
	$total_result = mysqli_query($connection, $total_sql);
            $rosemary_total=0;
            $isobel_total=0;
            foreach($total_result as $this_row){
            $rosemary_total=$rosemary_total+$this_row['rosemary'];
            $isobel_total=$isobel_total+$this_row['isobel'];
            }
           
            echo "<div class=\"container\">";
            echo "<h3>" . $row["month"] .  " " . $row["year"] . "</h3>";
            echo "<span class=\"half\"><h4>Rosemary</h4> <h1>" . $rosemary_total . "</h1></span>";
            echo "<span class=\"half\"><h4>Isobel</h4> <h1>" . $isobel_total . "</h1></span>";
            echo "</div>";  
        }//END FOREACH
        echo " </div>"; // end #page
        
        
        
    
    }else{
    echo "<div id=\"days\">
        <span id=\"current\"><a href=\"index.php?ashtray\">Day</a></span> 
        <span><a href=\"index.php?ashtray&month\">Month</a></span>
        <span><a href=\"smokers.php\">Smokers</a></span>
    </div> </header><div id=\"page\">";
//DAY VIEW
    $sql = "SELECT * FROM log GROUP BY year, month, day ORDER BY year DESC, month DESC, day DESC";
	$result = mysqli_query($connection, $sql);
    $today_rows=mysqli_num_rows($result);
        if($today_rows>=1){
            foreach ($result as $row) {
                echo "<div class=\"container\">";
                echo "<h3>" . $row["weekday"] . " " . $row["month"] . " " . get_suffix($row["day"]) .  ", " . $row["year"] . "</h3>";
 
                 
                $today_sql = "SELECT * FROM log WHERE day={$row["day"]} AND year={$row["year"]} AND month='{$row["month"]}' ";
                $today_result = mysqli_query($connection, $today_sql); 
                if($today_result){ 
                    foreach($today_result as $today){
                        //SEE IF FRIEND BEFORE SHOWING COUNT
                        $friend_sql = "SELECT * FROM friends WHERE user_id={$_SESSION['user_id']} AND friend_id={$today['user_id']}";
                        $friend_result = mysqli_query($connection, $friend_sql); 
                        if($friend_result){
                            $friend_rows=mysqli_num_rows($friend_result);
                            if($friend_rows>=1){
                            $this_friend=find_user_by_user_id($today['user_id']); 
                                echo "<span class=\"half\"><h4>".$this_friend[username]."</h4> <h1>" . $today['total'] . "</h1></span>";
                            }//end if friend show
                        }
                        
                        if($today['user_id']==$_SESSION['user_id']){
                            echo "<span class=\"orange half\"><h4>".$_SESSION['username']."</h4> <h1>" . $today['total'] . "</h1></span>";
                        }
 
                }//end if anyone smoked today 



                echo "</div>"; //END CONTAINER
            }//END GET EACH USER
        
        }//END FOREACH FROM LOG     
    }//END GET EVERY DAY
         echo " </div>"; // end #page
    
    }//END ASHTRAY SUBPAGES
    
}elseif(isset($_POST['add'])){
    
 
    date_default_timezone_set("US/Hawaii");
 
   
    
    $day=date('d');
    $hour=date('G');
    if($hour>=22){
        $day=$day-1;
    }
    $month=date('F');
    $year=date('Y');
    $weekday=date('l'); 
    $total=0;
    
    //SEE IF LOG EXISTS FOR TODAY
    $today_query  = "SELECT * FROM log WHERE user_id={$_SESSION['user_id']} AND year={$year} AND month='{$month}' AND day={$day}"; 
    $today_found = mysqli_query($connection, $today_query);
    if($today_found){ 
        $current_log=mysqli_fetch_assoc($today_found);
        $total=$current_log['total']+1;
        $today_rows= mysqli_num_rows($today_found);
        if ($today_rows>=1){
            //UPDATE TODAY 
            $query  = "UPDATE log SET total={$total} WHERE user_id={$_SESSION['user_id']} AND day={$day} AND month='{$month}' AND year={$year} LIMIT 1";
            $cigarette_added = mysqli_query($connection, $query);


            if ($cigarette_added) { 
                // Success
                $_SESSION["message"] = "You had a cigarette!"; 
                redirect_to("index.php?ashtray");
            } else {
                // Failure
                $_SESSION["message"] = "New Cigarette Not Added!";
                redirect_to("index.php");
            }//END UPDATE TODAYS LOG
        }else {
            $total=1;
            //ADD ONE INSERT QUERY: NOT A ROW FOR TODAY
            $query  = "INSERT INTO log (";
            $query .= " day, month, year, weekday, user_id, total ";
            $query .= ") VALUES (";
            $query .= " {$day}, '{$month}', {$year}, '{$weekday}', {$_SESSION['user_id']}, {$total}";
            $query .= ") ";
            $cigarette_added = mysqli_query($connection, $query);


            if ($cigarette_added) { 
                // Success
                $_SESSION["message"] = "First Cigarette Counted Today!"; 
                redirect_to("index.php?ashtray");
            } else {
                // Failure
                $_SESSION["message"] = "New Cigarette Not Added!";
                redirect_to("index.php");
            }//END UPDATE TODAYS LOG

        }//END INSERT OR UPDATE
         

        } else {

            $total=1; 
            $query  = "INSERT INTO log (";
            $query .= " day, month, year, weekday, user_id, total ";
            $query .= ") VALUES (";
            $query .= " {$day}, '{$month}', {$year}, '{$weekday}', {$_SESSION['user_id']}, {$total}";
            $query .= ") ";
            $cigarette_added = mysqli_query($connection, $query);


            if ($cigarette_added) { 
                // Success
                $_SESSION["message"] = "First Cigarette Counted Today!"; 
                redirect_to("index.php?ashtray");
            } else {
                // Failure
                $_SESSION["message"] = "New Cigarette Not Added!";
                redirect_to("index.php");
            }//END UPDATE TODAYS LOG

        }//END INSERT OR UPDATE
 



}else{ 

//ADD ONE
    ?>
   <header>
    <a class="left username" href="profile.php"><?php echo $_SESSION['username']; ?></a>
    <a class="logout" href="logout.php">Logout</a>
    <h1 id="ashtray">Break The Camel's Back</h1>
    </header> 
    <div id="page">
    <div id="add_cig">
    <form method="POST" action="index.php?add" >
        <label> <?php echo $_SESSION['username']; ?></label><br/> 
        <input type="submit" name="add" value="Smoke A Cigarette">
    </form>
    <br/>
    <br/>
    <br/>
    <a id="view_ashtray" href="index.php?ashtray">View Ashtray</a>
    </div>
    </div>
    
    <?php
    

}

?>
   
  
    
</body>
</html>