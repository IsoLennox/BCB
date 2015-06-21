<?php require_once("inc/session.php"); 
require_once("inc/functions.php"); 
include('inc/db_connection.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BCB</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <?php echo message(); ?> 
   <?php 

if(isset($_GET['ashtray'])){
    
    ?>
    <h1>Ashtray</h1>
    <a href="index.php">&laquo; Smoke One</a>
    <br/>
    <a href="index.php?ashtray">Day</a>
    <a href="index.php?ashtray&week">Week</a>
    <a href="index.php?ashtray&month">Month</a>
    <?php


//ASHTRAY
    
    if(isset($_GET['week'])){
    
//WEEK VIEW 
echo "<h2>Week View</h2>";
        
    }elseif(isset($_GET['month'])){
    
    //MONTH VIEW
echo "<h2>Month View</h2>";
    
    
    }else{
    echo "<h2>Day View</h2>";
//DAY VIEW
	$sql = "SELECT * FROM log ORDER BY year, month, day DESC";
	$result = mysqli_query($connection, $sql);

        foreach ($result as $row) {
            echo "<div>";
            echo "<h3>" . $row["weekday"] . " " . $row["month"] . " " . get_suffix($row["day"]) . "</h3>";
            echo "<h4>Rosemary: " . $row["rosemary"] . "</h4>";
            echo "<h4>Isobel: " . $row["isobel"] . "</h4>";
            echo "</div>";
        }//END FOREACH
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
    <h1>Break The Camel's Back</h1>
    <div id="add_cig">
    <form method="POST" action="index.php?add" >
        <label><input type="radio" name="smoker" value="isobel"> Isobel</label><br/>
        <label><input type="radio" name="smoker" value="rosemary"> Rosemary</label><br/>
        <input type="submit" name="add" value="Smoke A Cigarette">
    </form>
    <br/>
    <br/>
    <br/>
    <a id="view_ashtray" href="index.php?ashtray">View Ashtray</a>
    </div>
    
    <?php
    

}

?>
    
</body>
</html>