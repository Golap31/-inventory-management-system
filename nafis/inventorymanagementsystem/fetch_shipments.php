<?php
include 'db/db_connect.php';

// Query to fetch all shipment data
$query = "SELECT * FROM shipments";
$result = mysqli_query($conn, $query);

// Loop through the results and generate table rows
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>" . htmlspecialchars($row['id']) . "</td>
        <td>" . htmlspecialchars($row['product_name']) . "</td>
        <td>" . htmlspecialchars($row['quantity']) . "</td>
        <td>" . htmlspecialchars($row['transport_mode']) . "</td>
        <td>" . htmlspecialchars($row['departure_date']) . "</td>
        <td>" . htmlspecialchars($row['arrival_date']) . "</td>
        <td>" . htmlspecialchars($row['loading_loss']) . "</td>
        <td>" . htmlspecialchars($row['unloading_loss']) . "</td>
        <td>
            <a href='edit_shipment.php?id=" . $row['id'] . "'>Edit</a> | 
            <a href='delete_shipment.php?id=" . $row['id'] . "'>Delete</a>
        </td>
    </tr>";
}

mysqli_close($conn);
?>
