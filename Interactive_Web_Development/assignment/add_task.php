<?php

require 'db_connect.php';

if (isset($_POST['add']))
{ // Add task 
    $stmt = $db->prepare("INSERT INTO task (task_name) VALUES (?)");
    $result = $stmt->execute( [$_POST['task']] );

    if ($result)
    {
      echo '<p>Task Added!</p>';
      echo '<a href="task_management.php">Back to tasks.</a></p>';
    }
    else
    {
      echo 'Something went wrong.';
    } 
}