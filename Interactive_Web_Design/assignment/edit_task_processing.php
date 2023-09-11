<?php 

require 'db_connect.php';

$newname = $_POST['new_name'];
$taskid = $_POST['id'];

$stmt = $db->prepare("UPDATE task
                     SET task_name = ?
                     WHERE task_id = ?");
$result = $stmt->execute( [$newname, $taskid] );

if ($result) {
    echo '<p>Task updated!</p>';
    echo '<p>Back to the manage task <a href="task_management.php">page.</a></p>';
}
else {
    echo '<p>Task update was unsuccessful, back to the manage task <a href="task_management.php">page.</a></p>';
}

?>


