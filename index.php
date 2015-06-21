<?php include('inc/db_connection.php');
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
	$sql = "SELECT * FROM log ORDER BY day DESC";
	$result = mysqli_query($connection, $sql);

	foreach ($result as $row) {
		echo "<div>";
		echo "<h3>" . $row["weekday"] . " " . $row["month"] . " " . $row["day"] . "</h3>";
		echo "<h4>Rosemary: " . $row["rosemary"] . "</h4>";
		echo "<h4>Isobel: " . $row["isobel"] . "</h4>";
		echo "</div>";
	}


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