<?php
include 'db/db_connect.php';

// Update warehouse data with random values
$query = "UPDATE warehouse SET 
    temperature = ROUND(RAND() * 10 + 20, 1), 
    humidity = ROUND(RAND() * 20 + 50, 1),
    last_updated = NOW()";
mysqli_query($conn, $query);

echo "Sensor data updated!";
?>
