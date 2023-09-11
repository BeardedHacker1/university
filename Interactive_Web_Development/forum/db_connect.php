<?php
  // This file will be included at the start of all other files in the site
  // It includes code to connect to the database server, but could be expanded
  // to include other things that are needed across multiple files in the site!

  // Connect to database server
  session_start();
  try
  { 
    $db = new PDO('mysql:host=localhost;port=6033;dbname=iwd_forum', 'root', '');
  }
  catch (PDOException $e) 
  {
    echo 'Error connecting to database server:<br />';
    echo $e->getMessage();
    exit;
  } 
?>