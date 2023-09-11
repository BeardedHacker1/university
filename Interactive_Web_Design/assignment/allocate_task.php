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
  
  if (!isset($_GET['id']) || !ctype_digit($_GET['id']))
  { // If there is no "id" URL data or it isn't a number
    echo 'Invalid ID.';
    exit;
  }

  // Select details of specified thread
  // Since the user could tamper with the URL data, a prepared statement is used
  $stmt = $db->prepare("SELECT t.task_name, vts.details
                        FROM volunteer_time_slot vts
                        LEFT JOIN task t ON vts.task_id = t.task_id
                        WHERE vts.vol_time_slot_id = ?");
  $stmt->execute( [$_GET['id']] );
  $task = $stmt->fetch();
  
  if (!$task)
  { // If no data
    echo 'Invalid ID.';
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
  <style>
    .custom-textarea {
        width: 300px; /* Adjust the width as needed */
        height: 150px; /* Adjust the height as needed */
    }
    fieldset {
      border: 2px solid black;
      padding: 8px;
      width: 20%;
      height: 100%;
    }
  </style>
  <body>
  <h1>Allocate Task</h1>
  <fieldset>
  <form name="allocate_form" method="post" action="allocate_task_processing.php">
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    <br><span>Select a task: </span></span><select name="task_id">
    <option value="" disabled>Select a task</option>
    <?php  
        // Select details of all tasks
        $result = $db->query("SELECT * FROM task ORDER BY task_id");
            
        // Loop through each forum to generate an option of the drop-down list
        foreach($result as $row)
        {
          $selected = ($row['task_id'] == $task['task_id']) ? 'selected' : '';
          echo '<option value="' . $row['task_id'] . '" ' . $selected . '>' . $row['task_name'] . '</option>';
        }
    ?>
    </select><br>
    <br><label><span>Details: </span><br><textarea name="details" class="custom-textarea"><?= $task['details'] ?></textarea></label><br>
    <br><input type="submit" name="allocate" value="Allocate Task" /></br>
  </form>
  <form name="clear_form" method="post" action="clear_task.php">
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    <br><input type="submit" name="clear" value="Clear Task & Details" /></br>
  </form>
  <form name="back_form" method="get" action="manage_volunteer_timeslot.php">
    <br><input type="submit" name="back" value="Back" /></br>
  </form>
  <form name="logout_form" method="post" action="logout.php">
    <br><input type="submit" name="logout" value="Logout" /></br>
  </form>
  </fieldset>
  </form>
  </body>
</html>