<?php
$conn = new mysqli("localhost", "root", "", "inventory_system");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produce = $_POST['produce_name'];
    $qty = $_POST['quantity'];
    $reason = $_POST['reason'];
    $stage = $_POST['loss_stage'];

    $sql = "INSERT INTO losses (produce_name, quantity, reason, loss_stage)
            VALUES ('$produce', '$qty', '$reason', '$stage')";
    $conn->query($sql);
    header("Location: dashboard.php");
}
?>
