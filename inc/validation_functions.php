<?php
$errors = array();

function fieldname_as_text($fieldname) {
  $fieldname = str_replace("_", " ", $fieldname);
  $fieldname = ucfirst($fieldname);
  return $fieldname;
}

// * presence
// use trim() so empty spaces don't count
// use === to avoid false positives
// empty() would consider "0" to be empty
function has_presence($value) {
  return isset($value) && $value !== "";
}

function validate_presences($required_fields) {
  global $errors;
  foreach($required_fields as $field) {
    $value = trim($_POST[$field]);
    if (!has_presence($value)) {
      $errors[$field] = fieldname_as_text($field) . " can't be blank";
    }
  }
}

function validate_confirm_password($password, $confirm_password) {
  global $errors;
  if (strcmp($password, $confirm_password) !== 0) {
    $errors["Confirm Password"] = "Passwords do not match";
  }
}


function validate_username_unique($new_username) {
    global $errors;
    global $connection;

    $check_username  = "SELECT * FROM users WHERE username = '{$new_username}'";
    $username_checked = mysqli_query($connection, $check_username);

    if (mysqli_num_rows($username_checked) != 0) {
      $errors["Username"] = "This username is taken";
    }
}


function validate_email_unique($new_email) {
  global $errors;
  global $connection;

  $check_username  = "SELECT * FROM users WHERE username = '{$new_username}'";
  $username_checked = mysqli_query($connection, $check_username);

  if (mysqli_num_rows($username_checked) != 0) {
    $errors["Username"] = "This username is taken";
  }
}



// * string length
// max length
function has_max_length($value, $max) {
  return strlen($value) <= $max;
}

function validate_max_lengths($fields_with_max_lengths) {
  global $errors;
  // Expects an assoc. array
  foreach($fields_with_max_lengths as $field => $max) {
    $value = trim($_POST[$field]);
    if (!has_max_length($value, $max)) {
      $errors[$field] = fieldname_as_text($field) . " is too long";
    }
  }
}

// * inclusion in a set
function has_inclusion_in($value, $set) {
  return in_array($value, $set);
}

?>