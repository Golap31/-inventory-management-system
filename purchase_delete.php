<?php
include 'db.php';

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM Purchase_T WHERE Purchase_ID = ?");
    $stmt->bind_param("s", $_GET['id']);
    $stmt->execute();
}

header("Location: purchase_view.php");
?>
