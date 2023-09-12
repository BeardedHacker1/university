<?php 
require 'db_connect.php';

$selectedTimeSlot = $_POST['timeslot'];

// Typecast the selected value to an integer
$selectedTimeSlot = (int)$selectedTimeSlot;

$userEmail = $_SESSION['user'];

// Checking if the time slot has already been added by the user
$stmt = $db->prepare("SELECT COUNT(*) FROM volunteer_time_slot WHERE time_id = ?");
$stmt->execute([$selectedTimeSlot]);
$existingTimeSlotCount = $stmt->fetchColumn();

if ($existingTimeSlotCount > 0)
{
    // The selected time slot already exists for the user
    echo '<p>Time slot already added, please choose a different time slot. Back to the time slot <a href="manage_time_slots_form.php">page.</a></p>';
}
// If not proceed to add time slot
else
{
    $stmt = $db->prepare("INSERT INTO volunteer_time_slot (volunteer_email, time_id) VALUES (?, ?)");
    $result = $stmt->execute([$userEmail, $selectedTimeSlot]);

    if ($result) 
    {
        echo '<p>Time slot added!</p>';
        echo '<p>Back to the time slot <a href="manage_time_slots_form.php">page.</a></p>';
    }
    else 
    {
        echo '<p>Adding timeslot was unsuccessful, back to the time slot <a href="manage_time_slots_form.php">page.</a></p>';
    }
}
?>