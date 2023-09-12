<?php 
require 'db_connect.php';

// If volunteer is not logged in redirect to login page
if (!isset($_SESSION['user']))
{
  header('Location: login_form.php');
}

// Check if the user is an volunteer
if ($_SESSION['level'] !== 'volunteer') 
{
    echo 'Unauthorised action.';
    exit;
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Manage Time Slots Form</title>
    <meta name="author" content="Joshua Dankers" />
    <meta name="description" content="CyberCon Manage Time Slots Form" />
    <link rel="stylesheet" type="text/css" href="manage_time_slots_stylesheet.css" />
  </head>
  <script>
    function confirmRemove(volTimeSlotId) {
        var confirmation = confirm("Are you sure you want to remove this timeslot?");
        if (confirmation) {
            // If the user confirms, you can redirect to the remove_timeslot.php with the ID
            window.location.href = 'remove_timeslot.php?id=' + volTimeSlotId;
        }
        // If the user cancels, nothing happens
    }
  </script>
  <body>
    <h1>Timeslots</h1>
    <fieldset>
      <h3>Hello <?php echo $_SESSION['name']; ?>, These Are Your Time Slots:</h3>
      <table>
      <?php
        $stmt = $db->prepare('SELECT ts.time_slot_name, t.task_name, vts.details, vts.vol_time_slot_id, vts.task_id
                              FROM volunteer_time_slot vts
                              JOIN time_slots ts ON vts.time_id = ts.time_slot_id
                              LEFT JOIN task t ON vts.task_id = t.task_id
                              WHERE vts.volunteer_email = ?');
        $stmt->execute( [$_SESSION['user']] );

        // Fetch all of the results as an array
        $result = $stmt->fetchAll();

        // Display results or a "no results" message as appropriate
        if (count($result) > 0)
        {
          echo '<tr><th>Timeslot</th><th>Allocated Task</th><th>Details</th><th>Remove</th></tr>'; 
          // Loop through results to display links to data
          foreach($result as $row)            
          {
            echo '<tr>';
            echo '<td>'.$row['time_slot_name'] . '</td>';  
            echo '<td>'.($row['task_name'] ?? 'No task allocated') . '</td>';
            echo '<td>'.$row['details'] . '</td>';
            echo '<td><a href="javascript:void(0);" onclick="confirmRemove('.$row['vol_time_slot_id'].')">Remove</a></td>';
            echo '</tr>';
          }
        }
        else
        {
          echo '<p>No allocated tasks.</p>';
        }
      ?>
      </table></br>
      <form name="manage_time_slots_form" method="post" action="add_timeslot_processing.php">
        <select name="timeslot">
          <option value="" selected disabled>Select a timeslot</option>
          <?php
            // Fetch time_slot_id and time_slot_name from the time_slots table ordered by time_slot_id
            $stmt = $db->prepare('SELECT time_slot_id, time_slot_name FROM time_slots ORDER BY time_slot_id');
            $stmt->execute();

            while ($row = $stmt->fetch())
            {
              $time_slot_id = $row['time_slot_id'];
              $time_slot_name = $row['time_slot_name'];
              echo "<option value=\"$time_slot_id\">$time_slot_name</option>";
            }
          ?>
        </select>
        <input type="submit" name="add_time_slot" value="Add" />
      </form>
      <br>
      <form name="logout_form" method="get" action="logout.php">
        <input type="submit" name="logout" value="Logout" />
      </form>
    </fieldset>
  </body>
</html>