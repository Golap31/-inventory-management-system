<?php
$host = 'localhost';      // Database host
$user = 'root';           // Database username
$password = '';           // Database password
$dbname = 'real_time_monitoring_db'; // Your existing database name

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
