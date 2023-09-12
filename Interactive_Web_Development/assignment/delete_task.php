<?php
    require 'db_connect.php';

    // Check if the organiser is logged in
    if (!isset($_SESSION['user']))
    {
        header('Location: login.php');
    }

    if (!isset($_GET['id']) || !ctype_digit($_GET['id']))
    { // If there is no "id" URL data or it isn't a number
        echo 'Invalid task ID.';
        exit;
    }

    $taskId = $_GET['id'];

    $stmt = $db->prepare("SELECT COUNT(*) FROM volunteer_time_slot WHERE task_id = ?");
    $stmt->execute([$taskId]);
    $existingTaskCount = $stmt->fetchColumn();
    
    if ($existingTaskCount > 0)
    {
        // The selected task already assigned to a volunteer
        echo '<p>Task is currently assigned to a volunteer and can not be deleted. Back to the manage task <a href="task_management.php">page.</a></p>';
    }
    // If not proceed to remove task
    else
    {
        // Delete specified task
        $stmt = $db->prepare("DELETE FROM task WHERE task_id = ?");
        $result = $stmt->execute( [$taskId] );
        
        if ($result)
        { // DELETE was successful 
            echo '<p>Task deleted!<br />';
            echo '<p>Back to the manage task <a href="task_management.php">page.</a></p>';
        }
        else
        {
            echo 'Invalid task ID.';
            exit;  
        }
    }
?>