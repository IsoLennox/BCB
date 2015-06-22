<?php
	require_once("inc/session.php");
	require_once("inc/functions.php");

	// unset($_SESSION["logged_in"]);
	unset($_SESSION["user_id"]);
	unset($_SESSION["username"]);

	redirect_to("login.php");
?>