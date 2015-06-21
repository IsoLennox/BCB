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


//ASHTRAY


//DAY VIEW


//WEEK VIEW 


//MONTH VIEW
    
}elseif(isset($_POST['add'])){
   
    
    $day=date('d');
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
    <div id="add_cig">
    <form method="POST" action="index.php?add" >
        <input type="radio" name="smoker" value="isobel"> Isobel<br/>
        <input type="radio" name="smoker" value="rosemary"> Rosemary<br/>
        <input type="submit" name="add" value="Smoke A Cigarette">
    </form>
    </div>
    <a id="view_ashtray" href="index.php?ashtray">View Ashtray</a>
    <?php
    

}

?>
    
</body>
</html>