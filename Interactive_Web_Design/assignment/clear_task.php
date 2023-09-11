<?php

require 'db_connect.php';

//If no user is logged in redirect to login page
if (!isset($_SESSION['user']))
{
  header('Location: login_form.php');
}

// Check if the user is an organiser
if ($_SESSION['level'] !== 'organiser') 
{
    echo 'Unauthorised action.';
    exit;
}

if (isset($_POST['clear'])) 
{
    // Delete task and task details from the volunteer_time_slot table
    $stmt = $db->prepare("UPDATE volunteer_time_slot SET task_id = NULL, details = NULL WHERE vol_time_slot_id = ?");
    $result = $stmt->execute([$_POST['id']]);

    if ($result) 
    {
        header('Location: manage_volunteer_timeslot.php');
    } 
    else 
    {
        echo 'Error updating the task.';
    }
}

?>