<?php
include "db.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $sql = "DELETE FROM PURCHASE WHERE ID = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); // back to main
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid ID.";
}

$conn->close();
?>
