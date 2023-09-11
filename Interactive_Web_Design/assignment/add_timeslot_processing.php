<?php 
require 'db_connect.php';

$selectedTimeSlot = $_POST['timeslot'];

// Typecast the selected value to an integer
$selectedTimeSlot = (int)$selectedTimeSlot;

//$userEmail = $_SESSION['email']
$userEmail = "joshdankers@gmail.com";

$stmt = $db->prepare("INSERT INTO volunteer_time_slot (volunteer_email, time_id) VALUES (?, ?)");
$result = $stmt->execute([$userEmail, $selectedTimeSlot]);

if ($result) {
    echo '<p>Time slot added!</p>';
    echo '<p>Back to the timeslots <a href="manage_time_slots_form.php">page.</a></p>';
}
else {
    echo '<p>Adding timeslot was unsuccessful, back to the manage task <a href="manage_time_slots_form.php">page.</a></p>';
}

?>