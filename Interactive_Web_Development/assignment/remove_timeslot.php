<?php
    require 'db_connect.php';

    // Check if the volunteer is logged in
    if (!isset($_SESSION['user']))
    {
       header('Location: login_form.php');
    }

    // Check if the user is an organiser
    if ($_SESSION['level'] !== 'volunteer') 
    {
        echo 'Unauthorised action.';
        exit;
    }

    if (!isset($_GET['id']) || !ctype_digit($_GET['id']))
    { // If there is no "id" URL data or it isn't a number
        echo 'Invalid timeslot ID.';
        exit;
    }

    // Delete specified timeslot
    $stmt = $db->prepare("DELETE FROM volunteer_time_slot WHERE vol_time_slot_id = ?");
    $result = $stmt->execute( [$_GET['id']] );
    
    if ($result)
    { // DELETE was successful 
        header('Location: manage_time_slots_form.php');
    }
    else
    {
        echo 'Invalid timeslot ID.';
        exit;  
    }

?>