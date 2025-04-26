<?php
// loss_backend.php

$servername = "localhost";  // usually localhost
$username = "root";          // your MySQL username
$password = "";              // your MySQL password
$dbname = "inventorymanagementsystem"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Receive posted data
$produceName = $_POST['produceName'];
$lostQuantity = $_POST['lostQuantity'];
$reason = $_POST['reason'];
$stage = $_POST['stage'];
$lossDate = $_POST['lossDate'];

// Insert into table
$sql = "INSERT INTO loss_records (produce_name, lost_quantity, reason, stage, loss_date) 
        VALUES ('$produceName', '$lostQuantity', '$reason', '$stage', '$lossDate')";

if ($conn->query($sql) === TRUE) {
    echo "Loss record added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
