<?php
require 'db_connect.php';

if (isset($_POST['register']))
{ // Validate and process the form

  // This array will be used to store validation error messages
  // When an error is detected, the relevant message is added to the array
  $errors = [];
  
  // The following "if" statements validate the form data
  // By using separate "if" statements, we always check all of the fields,
  // rather than stopping after finding a single error
  
  // Confirms if a email was entered
  if ($_POST['email'] == '')
  {
    $errors[] = 'Please provide an email.';
  }

  // Confirms if a password was entered
  if ($_POST['pword'] == '')
  {
    $errors[] = 'Please enter a password.';
  }
   
  // Confirms password is greater than 5 characters
  if (strlen($_POST['pword']) < 5)
  {
    $errors[] = 'Password must be at least 5 characters long.';
  }

  // Confirms if password confirmation was entered
  if ($_POST['conf_pword'] == '')
  {
    $errors[] = 'Please confirm your password.';
  }
  
  // Confirms if pword and pword_conf values match
  if ($_POST['pword'] != $_POST['conf_pword'])
  {
    $errors[] = 'Passwords do not match.';
  }

  // Confirms if first name was entered
  if ($_POST['fname'] == '')
  {
    $errors[] = 'Please enter your first name.';
  }

  // Confirms if last name was entered
  if ($_POST['lname'] == '')
  {
    $errors[] = 'Please enter your last name.';
  }

  // Confirms if a phone number was entered
  if ($_POST['pnum'] == '')
  {
    $errors[] = 'Please enter a phone number.';
  }
  
  // // Confirms postcode is not made up of digits or not 4 digit number
  if (!ctype_digit($_POST['pcode']) || strlen($_POST['pcode']) != 4) 
  {
    $errors[] = 'Postcode must be a 4 digit number.';
  }

  // If the error message array contains any items, it evaluates to True
  if ($errors)
  { // Display all error messages and link back to form
    foreach ($errors as $error)
    {
      echo '<p>'.$error.'</p>';
    }
   
    echo '<a href="javascript: window.history.back()">Return to registration form</a>';
  }
  else
  { // Validation successful insert details
    $stmt = $db->prepare("INSERT INTO volunteer (email, password, first_name, last_name, phone_number, postcode) VALUES (?, ?, ?, ?, ?, ?)");
    $result = $stmt->execute( [$_POST['email'], $_POST['pword'], $_POST['fname'], $_POST['lname'], $_POST['pnum'], $_POST['pcode']] );
  
    if ($result)
    {
      echo '<p>Registration complete!</p>';
      echo '<p><a href="login_form.php">Login</a></p>';
    }
    else if ($stmt->errorCode() == '23000')
    {
      echo '<p>User "' . $_POST['email'] . '" already exists.</p>';
      echo '<a href="javascript: history.back()">Return to form</a>';
    }
    else
    {
      echo 'Something went wrong.';
    }
  }
}
else
{ // Show message if the form has not been submitted
  echo 'Please submit the registration <a href="registration_form.php">form</a>.';
}
?>