<?php include 'db.php';

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM SALES_DISTRIBUTION WHERE Sales_ID = ?");
    $stmt->bind_param("s", $_GET['id']);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: distribution_view.php");
exit;
