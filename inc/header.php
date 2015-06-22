<?php require_once("inc/session.php"); 
require_once("inc/functions.php"); 
include('inc/db_connection.php'); 
confirm_logged_in();
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BCB</title>
    <link rel="stylesheet" href="css/style.css">
    <link href='http://fonts.googleapis.com/css?family=Special+Elite|Carme|Flavors' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!--
    
    font-family: 'Special Elite', cursive;
    font-family: 'Carme', sans-serif;
    font-family: 'Flavors', cursive;
    
    -->
</head>
<body>
   <?php echo message(); ?> 