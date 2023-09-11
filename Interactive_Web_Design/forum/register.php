<?php
require 'db_connect.php';

// Is user is logged in redirect to list_threads
if (isset($_SESSION['uname']))
{
  header('Location: list_threads.php');
}
// This code checks if the $_POST variable (which contains form data submitted using the POST method)
// contains a key of 'submit' (the name of the submit button), and if so it prints the form data.
if (isset($_POST['submit']))
{ // Validate and process the form

  // This array will be used to store validation error messages
  // When an error is detected, the relevant message is added to the array
  $errors = [];
  
  // The following "if" statements validate the form data
  // By using separate "if" statements, we always check all of the fields,
  // rather than stopping after finding a single error
  
  // Tests if the username is between 6 and 20 characters long and is alphanumeric
  if (strlen($_POST['uname']) < 6 || strlen($_POST['uname']) > 20 || !ctype_alnum($_POST['uname']))
  {
    $errors[] = 'Username must be between 6 and 20 characters and only contain letters and numbers.';
  }

  // Tests if the password is greater than 8 characters
  if (strlen($_POST['pword']) < 8)
  {
    $errors[] = 'Password must be greater than 8 characters.';
  }

  // Tests if the password and password confirmation fields do not match
  if ($_POST['pword'] != $_POST['confirmpword'])
  {
    $errors[] = 'Password does not match confirmation.';
  }

  // Tests if the dob field is empty
  if ($_POST['dob'] == '')
  {
    $errors[] = 'You must enter your date of birth.';
  }

  // Tests if dob is valid and also greater than 14 years ago
  //if (strtotime($_POST['dob']) == false || strtotime($_POST['dob']) <= strtotime('-14 years'))
  //{
    //$errors[] = 'Please enter a valid date of birth.';
  //}

  // Tests if the "I agree" checkbox is unchecked (and hence not available)
  if (!isset($_POST['agree'])) 
  {
    $errors[] = 'You must agree to the terms and conditions.';
  }

  // If the error message array contains any items, it evaluates to True
  if ($errors)
  { // Display all error messages and link back to form
    foreach ($errors as $error)
    {
      echo '<p>'.$error.'</p>';
    }
   
    echo '<a href="javascript: window.history.back()">Return to form</a>';
  }
  else
  { // Validation successful (code to process the data would go here)
    $stmt = $db->prepare("INSERT INTO user (username, password, real_name, dob) VALUES (?, ?, ?, ?)");
    $result = $stmt->execute( [$_POST['uname'], $_POST['pword'], $_POST['name'], $_POST['dob']] );

    if ($result)
    {
      echo '<p>Registration complete!</p>';
      echo '<p><a href="login.php">Login</a></p>';
    }
    else if ($stmt->errorCode() == '23000')
    {
      echo '<p>Username of "' . $_POST['uname'] . '" already exists.</p>';
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
  echo 'Please submit the <a href="form_validation_PHP.php">form</a>.';
}
?>