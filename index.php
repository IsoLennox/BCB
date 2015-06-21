<?php

define("DB_SERVER","localhost");
define("DB_USER","root");
define("DB_PASS","******");
define("DB_NAME","DB");

$connection= mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

//test iff connection occured
if(mysqli_connect_error()){
    die("Database connection failed: ".mysqli_connect_error()." (".mysqli_errno() .")"
       );
}else{ //echo "connected!";
     } //end test connection

//END CREATE CONNECTION
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BCB</title>
</head>
<body>
   <?php


if(isset($_GET['ashtray'])){


//ASHTRAY


//DAY VIEW


//WEEK VIEW 


//MONTH VIEW
    
}elseif(isset($_POST['add'])){

    //ADD ONE INSERT QUERY


}else{

//ADD ONE
    
    

}

?>
    
</body>
</html>