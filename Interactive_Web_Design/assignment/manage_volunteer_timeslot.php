<?php
require 'db_connect.php';

// Is organiser is not logged in redirect to login page
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

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Volunteer Timeslot Management page</title>
    <meta name="author" content="Joshua Dankers" />
    <meta name="description" content="CyberCon Login Form" />
    <link rel="stylesheet" type="text/css" href="manage_time_slots_stylesheet.css" /> 
  </head>
  <body>
    <h1>Current Volunteer Timeslots</h1>
    <fieldset>
        <h3>These are the current allocated timeslots and tasks allocated to volunteers:</h3>
        <form name="task_manage" method="post" action="manage_volunteer_timeslot.php">
          <table>
            <?php
                $result = $db->QUERY("SELECT vts.vol_time_slot_id, ts.time_slot_name, CONCAT(v.first_name, ' ', v.last_name) AS volunteer_name, t.task_name, vts.details
                                      FROM volunteer_time_slot vts
                                      JOIN volunteer v ON vts.volunteer_email = v.email
                                      JOIN time_slots ts ON vts.time_id = ts.time_slot_id
                                      LEFT JOIN task t ON vts.task_id = t.task_id
                                      ORDER BY vts.vol_time_slot_id");

                // Fetch all of the results as an array
                $result_data = $result->fetchAll();

                // Display results or a "no results" message as appropriate
                if (count($result_data) > 0)
                {
                  echo '<tr><th>Timeslot</th><th>Volunteer Name</th><th>Allocated Task</th><th>Details</th><th>Edit</th></tr>'; 
                  // Loop through results to display links to data
                  foreach($result_data as $row)
                    {
                        echo '<tr>';
                        echo '<td>'.$row['time_slot_name'] . '</td>';  
                        echo '<td>'.$row['volunteer_name'] . '</td>';
                        echo '<td>'.($row['task_name'] ?? 'No task allocated') . '</td>';
                        echo '<td>'.$row['details'] . '</td>';
                        echo '<td><a href="allocate_task.php?id='.$row['vol_time_slot_id'].'">Edit</a></td>';
                        echo '</tr>';
                    }
                }
                else
                {
                  echo '<p>No volunteer timeslots.</p>';
                }
            ?>
          </table>
        </form>
        <form name="manage_task_form" method="get" action="task_management.php">
            <br><input type="submit" name="manage_task" value="Manage Tasks" /></br>
        </form>
        <form name="logout_form" method="post" action="logout.php">
            <br><input type="submit" name="logout" value="Logout" /></br>
        </form>
    </fieldset>
  </body>
</html>