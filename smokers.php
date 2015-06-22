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
   <?php 

if(isset($_GET['ashtray'])){
    
    //<span><a href=\"index.php?ashtray&week\">Week</a></span> 
    
    ?>
    <header>
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
    $sql = "SELECT * FROM log ORDER BY year DESC, month DESC, day DESC";
	$result = mysqli_query($connection, $sql);

        foreach ($result as $row) {
            echo "<div class=\"container\">";
            echo "<h3>" . $row["weekday"] . " " . $row["month"] . " " . get_suffix($row["day"]) .  ", " . $row["year"] . "</h3>";
            echo "<span class=\"half\"><h4>Rosemary</h4> <h1>" . $row["rosemary"] . "</h1></span>";
            echo "<span class=\"half\"><h4>Isobel</h4> <h1>" . $row["isobel"] . "</h1></span>";
            echo "</div>";
        }//END FOREACH
        echo " </div>"; // end #page
        
        
        
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
	$sql = "SELECT * FROM log ORDER BY year DESC, month DESC, day DESC";
	$result = mysqli_query($connection, $sql);

        foreach ($result as $row) {
            echo "<div class=\"container\">";
            echo "<h3>" . $row["weekday"] . " " . $row["month"] . " " . get_suffix($row["day"]) .  ", " . $row["year"] . "</h3>";
            echo "<span class=\"half\"><h4>Rosemary</h4> <h1>" . $row["rosemary"] . "</h1></span>";
            echo "<span class=\"half\"><h4>Isobel</h4> <h1>" . $row["isobel"] . "</h1></span>";
            echo "</div>";
        }//END FOREACH
        echo " </div>"; // end #page
    }//END GET VIEW TYPE

    
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
    $smoker=$_POST['smoker'];
    if($smoker==="rosemary"){
        $rosemary=1;
        $isobel=0;
    }else{
        $isobel=1;
        $rosemary=0;
    }
    
    //SEE IF LOG EXISTS FOR TODAY
    $today_query  = "SELECT * FROM log WHERE year={$year} AND month='{$month}' AND day={$day}"; 
    $today_found = mysqli_query($connection, $today_query);
    if($today_found){ 
        $current_log=mysqli_fetch_assoc($today_found);
            $total_rosemary=$current_log['rosemary']+$rosemary;
            $total_isobel=$current_log['isobel']+$isobel;
        
        
        $today_rows= mysqli_num_rows($today_found);
        if ($today_rows>=1){
            //UPDATE TODAY 
            $query  = "UPDATE log SET rosemary={$total_rosemary}, isobel={$total_isobel} WHERE day={$day} AND month='{$month}' AND year={$year} LIMIT 1";
            $cigarette_added = mysqli_query($connection, $query);


            if ($cigarette_added) { 
                // Success
                $_SESSION["message"] = ucfirst($smoker)." had a cigarette!"; 
                redirect_to("index.php");
            } else {
                // Failure
                $_SESSION["message"] = "New Cigarette Not Added!";
                redirect_to("index.php");
            }//END UPDATE TODAYS LOG
        }else {

            //ADD ONE INSERT QUERY: NOT A ROW FOR TODAY
            $query  = "INSERT INTO log (";
            $query .= " day, month, year, weekday, rosemary, isobel ";
            $query .= ") VALUES (";
            $query .= " {$day}, '{$month}', {$year}, '{$weekday}', {$rosemary}, {$isobel}";
            $query .= ") ";
            $cigarette_added = mysqli_query($connection, $query);


            if ($cigarette_added) { 
                // Success
                $_SESSION["message"] = "First Cigarette Counted Today! Thanks, ".ucfirst($smoker); 
                redirect_to("index.php");
            } else {
                // Failure
                $_SESSION["message"] = "New Cigarette Not Added!";
                redirect_to("index.php");
            }//END UPDATE TODAYS LOG

        }//END INSERT OR UPDATE
         

        } else {

            //ADD ONE INSERT QUERY: NOT A ROW FOR TODAY
            $query  = "INSERT INTO log (";
            $query .= " day, month, year, weekday, rosemary, isobel ";
            $query .= ") VALUES (";
            $query .= " {$day}, '{$month}', {$year}, '{$weekday}', {$rosemary}, {$isobel}";
            $query .= ") ";
            $cigarette_added = mysqli_query($connection, $query);


            if ($cigarette_added) { 
                // Success
                $_SESSION["message"] = "First Cigarette Counted Today! Rosemary: ".$rosemary." Isobel: ".$isobel; 
                redirect_to("index.php");
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
    <h1>Break The Camel's Back</h1>
    </header> 
    <div id="page">
    <div id="add_cig">
    <form method="POST" action="index.php?add" >
        <label><input type="hidden" name="smoker" value="<?php echo $_SESSION['user_id']; ?>"> <?php echo $_SESSION['username']; ?></label><br/> 
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