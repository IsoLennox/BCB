<?php

define("DB_SERVER","localhost");
define("DB_USER","root");
define("DB_PASS","street88car");
define("DB_NAME","bcb");

$connection= mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

//test iff connection occured
if(mysqli_connect_error()){
    die("Database connection failed: ".mysqli_connect_error()." (".mysqli_errno() .")"
       );
}else{ //echo "connected!";
     } //end test connection

//END CREATE CONNECTION
?>