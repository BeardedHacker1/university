<?php
  require 'db_connect.php';

  // Is user is logged in redirect to login page
  if (!isset($_SESSION['uname']))
  {
    header('Location: login.php');
  }
  
  if (!isset($_GET['id']) || !ctype_digit($_GET['id']))
  { // If there is no "id" URL data or it isn't a number
    echo 'Invalid thread ID.';
    exit;
  }

  // Delete specified thread
  if ($_SESSION['level'] == 'admin')
  { // Delete specified thread if current user is an admin
    $stmt = $db->prepare("DELETE FROM thread WHERE thread_id = ?");
    $result = $stmt->execute( [$_GET['id']] );
  }
  else 
  { // Delete specified thread if current user is the author 
    $stmt = $db->prepare("DELETE FROM thread WHERE username = ? AND thread_id = ?");
    $result = $stmt->execute( [$_SESSION['uname'], $_GET['id']] );
  }
  
  if ($result)
  { // DELETE was successful 
    echo '<p>Thread deleted!<br />';
    echo '<a href="list_threads.php">List threads</a></p>';
  }
  else
  {
    echo 'Invalid thread ID.';
    exit;  
  }
?>