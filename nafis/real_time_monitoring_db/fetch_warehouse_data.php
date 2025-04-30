<?php
include 'db/db_connect.php';

// Query to fetch warehouse data
$query = "SELECT * FROM warehouse";
$result = mysqli_query($conn, $query);

// Loop through the results and generate table rows
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>" . htmlspecialchars($row['sensor_id']) . "</td>
        <td>" . htmlspecialchars($row['name']) . "</td>
        <td>" . htmlspecialchars($row['location']) . "</td>
        <td>" . htmlspecialchars($row['address']) . "</td>
        <td>" . htmlspecialchars($row['capacity']) . "</td>
        <td>" . htmlspecialchars($row['temperature']) . "</td>
        <td>" . htmlspecialchars($row['humidity']) . "</td>
        <td>" . htmlspecialchars($row['last_updated']) . "</td>
    </tr>";
}
?>
