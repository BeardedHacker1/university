<?php

require 'db_connect.php';

//if submit button has been pressed, then next action (to be completed - see below comment) 
if (isset($_POST['submit_org']))
{   // Try selecting users details
    $stmt = $db->prepare("SELECT * FROM organisers WHERE username = ? AND password = ?");
    $stmt->execute( [$_POST['uname'], $_POST['password']] );
    $user = $stmt->fetch();

    if ($user)
    {   // Set session variables and redirect to manage time slots page
        $_SESSION['user'] = $user['username'];
        $_SESSION['level'] = "organiser";
        header('Location: manage_volunteer_timeslot.php');
        exit;
    }
    else // If no matching user was found...
    {
        echo 'Invalid login attempt, try again.';
    }
}
?>