<?php
include 'db/db_connect.php';

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $shipment_id = $_GET['id'];

    // Prepare the DELETE query
    $sql = "DELETE FROM shipments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $shipment_id); // Bind the shipment_id as an integer

    // Execute the query
    if ($stmt->execute()) {
        // ✅ Redirect back to the correct shipment management page
        header("Location: shipment.php"); // Change to match your actual page name
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
