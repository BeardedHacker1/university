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

if (isset($_POST['allocate']))
{
    // Update the volunteer_time_slot table
    $stmt = $db->prepare("UPDATE volunteer_time_slot SET task_id = ?, details = ? WHERE vol_time_slot_id = ?");
    $result = $stmt->execute([$_POST['task_id'], $_POST['details'], $_POST['id']]);

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
