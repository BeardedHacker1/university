<?php
require 'db_connect.php';

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

if (!isset($_GET['id']) || !ctype_digit($_GET['id']))
    { // If there is no "id" URL data or it isn't a number
        echo 'Invalid task ID.';
        exit;
    }

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Edit Task Page</title>
    <meta name="author" content="Joshua Dankers" />
    <meta name="description" content="CyberCon Login Form" />
    <link rel="stylesheet" type="text/css" href="manage_time_slots_stylesheet.css" /> 
  </head>
  <script>
    
    function validate_task_name() {
      //form reference variable
      var form = document.edit_task;
        
        //check if add_task field is populated
      if (form.new_name.value == '') {
        alert("You must enter a new task name.");
        return false;
      }
    }

  </script>
  <style>
        fieldset {
          border: 2px solid black;
          padding: 8px;
          width: 20%;
          height: 20%;
        }
        table {
          border-collapse: collapse;
          width: 50%;
        }
        th, td {
          border: 2px solid black;
          padding: 8px;
          text-align: left;
        }
  </style>
  <body>
    <h1>Edit Task</h1>
    <fieldset>
    <form name="edit_task" method="post" action="edit_task_processing.php" onsubmit="return validate_task_name()">
        <?php

        $stmt = $db->prepare("SELECT task_name FROM task WHERE task_id = ?");
        $result = $stmt->execute([$_GET['id']]);

        if ($result) {
            $result_data = $stmt->fetch();
            echo "You are editing the task " . $result_data["task_name"] . ".";
            echo '<p>New name: <input type="text" name="new_name" autofocus>';
            echo '<input type="hidden" name="id" value="'.$_GET['id'].'">';
            echo '<input type="submit" value="Edit"></p>';
        }
        else {
            echo "something went wrong";
        }

        ?>
    </form>
    <form name="back_form" method="get" action="task_management.php">
        <br><input type="submit" name="back" value="Back" /></br>
    </form>
    </fieldset>
  </body>
</html>