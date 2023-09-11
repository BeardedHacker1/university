<?php
require 'db_connect.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Task Management page</title>
    <meta name="author" content="Joshua Dankers" />
    <meta name="description" content="CyberCon Login Form" />
    <link rel="stylesheet" type="text/css" href="manage_time_slots_stylesheet.css" />
    <script>
    
    function validate_add_task() {
        
      //form reference variable
      var form = document.add_task;
        
      //check if add_task field is populated
      if (form.task.value == '') {
        alert("Please enter a task.");
        return false;
      }
    }
    
    </script>
    <style>
        fieldset {
          border: 2px solid black;
          padding: 8px;
          width: 25%;
          height: 100%;
        }
        table {
          border-collapse: collapse;
          width: 100%;
        }
        th, td {
          border: 2px solid black;
          padding: 8px;
          text-align: left;
        }
    </style>
  </head>
  <body>
    <h1>Task Management</h1>
    <fieldset>
      <h3>Delete or Edit Tasks:</h3>
      <form name="task_manage" method="get" action="task_management.php">
        <table>
        <?php

        $result = $db->QUERY("SELECT * FROM task ORDER BY task_name");
      
      
        // Fetch all of the results as an array   ****check if correct variable??
        $result_data = $result->fetchAll();
        
        // Display results or a "no results" message as appropriate
        if (count($result_data) > 0)
        {
          echo '<tr><th>Task Name</th><th>Edit</th><th>Delete</th></tr>'; 
          // Loop through results to display links to data
          foreach($result_data as $row)
          {
            echo '<tr>';
            echo '<td>'.$row['task_name'] . '</td>';  
            echo '<td><a href="edit_task.php?id='.$row['task_id'].'">Edit</a></td>';
            echo '<td><a href="delete_task.php?id='.$row['task_id'].'">Delete</a></td>';
            echo '</tr>';
          }
        }
        else
        {
          echo '<p>No tasks allocated.</p>';
        }
        ?>
        </table>
      </form>
      <h3>Add Task:</h3> 
      <form name="add_task" method="post" action="add_task.php" onsubmit="return validate_add_task()">
        <input type="text" id="add" name="task"> <input type="submit" name="add" value="Add"></br>
      </form>
      <form name="back_form" method="get" action="manage_volunteer_timeslot.php">
        <br><input type="submit" name="back" value="Back" /></br>
      </form>
      <form name="logout_form" method="post" action="logout.php">
        <br><input type="submit" name="logout" value="Logout" /></br>
      </form>
    </fieldset>      
  </body>
</html>