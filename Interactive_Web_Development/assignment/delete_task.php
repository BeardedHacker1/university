<?php
    require 'db_connect.php';

    // Check if the organiser is logged in
    // if (!isset($_SESSION['username']))
    // {
        // header('Location: login.php');
    //}

    if (!isset($_GET['id']) || !ctype_digit($_GET['id']))
    { // If there is no "id" URL data or it isn't a number
        echo 'Invalid task ID.';
        exit;
    }

    // Delete specified task
    $stmt = $db->prepare("DELETE FROM task WHERE task_id = ?");
    $result = $stmt->execute( [$_GET['id']] );
    
    if ($result)
    { // DELETE was successful 
        echo '<p>Task deleted!<br />';
        echo '<p>Back to manage task <a href="task_management.php">page.</a></p>';
    }
    else
    {
        echo 'Invalid task ID.';
        exit;  
    }

?>