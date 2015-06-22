<?php ob_start();

function redirect_to($new_location) {
    header("Location: " . $new_location);
	  exit; }


function get_suffix($day) {
	$suffixes = array('th','st','nd','rd','th','th','th','th','th','th');
	if (($day % 100) >= 11 && ($day % 100) <= 13)
	   $ordinal = $day . 'th';
	else
	   $ordinal = $day . $suffixes[$day % 10];
	return $ordinal;
} //end get_suffix

function attempt_login($username, $password) {
	//find user, then password
	$user = find_user_by_username($username);
	if ($user) {
		//found admin, check password
		if (password_verify($password, $user["password"])) {
			//password matches
			return $user;
		} else {
			//password doesn't match
			echo "bad password<br>";
			return false;
		}
	} else {
		//not found
		return false;
	}
} //end attempt_login

function find_user_by_username($username) {
	$safe_username = mysqli_real_escape_string($connection, $username);

	$sql = "SELECT * ";
	$sql .= "FROM users ";
	$sql .= "WHERE username = '{$safe_username}' ";
	$sql .= "LIMIT 1";

	$user_set = mysqli_query($connection, $sql);
	if ($user = mysqli_fetch_assoc($user_set)) {
		return $user;
	} else {
		return null;
	}
} //end find_user_by_username

?>