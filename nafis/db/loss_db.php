<?php
require_once('dbconnection.php');

// Function to insert loss data
function insertLoss($product_name, $loss_type, $stage, $loss_date, $lost_amount, $unit) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO loss (product_name, loss_type, stage, loss_date, lost_amount, unit) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssds", $product_name, $loss_type, $stage, $loss_date, $lost_amount, $unit);
    return $stmt->execute();
}

// Function to get losses based on a date range
function getLossesByDate($start_date, $end_date) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM loss WHERE loss_date BETWEEN ? AND ?");
    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();
    return $stmt->get_result();
}
?>
