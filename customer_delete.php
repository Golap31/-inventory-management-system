<?php include 'db.php';

if (isset($_GET['name'])) {
    $stmt = $conn->prepare("DELETE FROM Customer_T WHERE Customer_Name = ?");
    $stmt->bind_param("s", $_GET['name']);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: customer_view.php");
exit;
