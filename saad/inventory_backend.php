<?php
// inventory_backend.php

$servername = "localhost";  // usually localhost
$username = "root";          // your database username
$password = "";              // your database password
$dbname = "inventorymanagementsystem"; // your database name joti\inventorymanagementsystem.sql

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get posted data from AJAX or form
$produceName = $_POST['produceName'];
$quantity = $_POST['quantity'];
$harvestDate = $_POST['harvestDate'];
$storageLocation = $_POST['storageLocation'];

// Insert into table
$sql = "INSERT INTO inventory (produce_name, quantity, harvest_date, storage_location) 
        VALUES ('$produceName', '$quantity', '$harvestDate', '$storageLocation')";

if ($conn->query($sql) === TRUE) {
    echo "Inventory added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
