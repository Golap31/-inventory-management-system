<?php
include('../db.php'); // Include your database connection

// Check if 'id' is set in the query string
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare delete query
    $sql = "DELETE FROM warehouse WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // Execute and redirect
    if ($stmt->execute()) {
        header("Location: warehouse.php?status=deleted");
        exit();
    } else {
        header("Location: warehouse.php?status=error");
        exit();
    }

    $stmt->close();
} else {
    // If ID is invalid or missing
    header("Location: warehouse.php?status=invalid");
    exit();
}

$conn->close();
?>
