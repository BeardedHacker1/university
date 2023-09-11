<?php
require 'db_connect.php';

// Is user is not logged in redirect to login page
if (!isset($_SESSION['uname']))
{
  header('Location: login.php');
}

// This code checks if the $_POST variable (which contains form data submitted using the POST method)
// contains a key of 'submit' (the name of the submit button), and if so it prints the form data.
if (isset($_POST['submit']))
{

  $errors = [];
  // Tests if the title was left empty or if only contains whitespace
  if ($_POST['title'] == '' || trim($_POST['title']) == '')
  {
    $errors[] = 'Please enter a title.';
  }

  // Tests if the content was left empty or if only contains whitespace
  if ($_POST['content'] == '' || trim($_POST['content']) == '')
  {
    $errors[] = 'Please enter some content.';
  }

  // Tests if a forum was selected
  if (!isset($_POST['forum_id'])) 
  {
    $errors[] = 'Please select a forum.';
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
    $stmt = $db->prepare("INSERT INTO thread (username, forum_id, title, content) VALUES (?, ?, ?, ?)");
    $result = $stmt->execute( [$_SESSION['uname'], $_POST['forum_id'], $_POST['title'], $_POST['content']] );

    if ($result)
    {
      echo '<p>Thread posted!</p>';
      echo '<a href="view_thread.php?id='.$db->lastInsertId().'">View thread</a></p>';
    }
    else
    {
      echo 'Something went wrong.';
    }
    
  }
}
else
{ // Show message if the form has not been submitted
  echo 'Please submit the <a href="new_thread_form.php">form</a>.';
}