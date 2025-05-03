<?php
$host = "localhost";
$username = "root";
$password = ""; // Or your XAMPP MySQL password
$dbname = "inventorymanagementsystem"; // ✅ Use the correct DB name

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
