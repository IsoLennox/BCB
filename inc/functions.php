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
?>