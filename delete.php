<?php include 'db.php';

if (isset($_GET['name'])) {
    $stmt = $conn->prepare("DELETE FROM warehouse_t WHERE `Warehouse Name` = ?");
    $stmt->bind_param("s", $_GET['name']);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: warehouse_view.php");
exit;
