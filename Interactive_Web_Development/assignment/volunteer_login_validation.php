<?php

require 'db_connect.php';

//if volunteer submit button has been pressed
if (isset($_POST['submit_vol']))
{   // Try selecting users details
    $stmt = $db->prepare("SELECT * FROM volunteer WHERE email = ? AND password = ?");
    $stmt->execute( [$_POST['email'], $_POST['pword']] );
    $user = $stmt->fetch();

    if ($user)
    {   // Set session variables and redirect to manage time slots page
        $_SESSION['user'] = $user['email'];
        $_SESSION['name'] = $user['first_name'];
        $_SESSION['level'] = "volunteer";
        header('Location: manage_time_slots_form.php');
        exit;
    }
    else // If no matching user was found...
    {
        echo 'Invalid login attempt, try again.';
    }
}
?>