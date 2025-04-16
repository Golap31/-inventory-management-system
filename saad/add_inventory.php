<?php
$conn = new mysqli("localhost", "root", "", "inventory_system");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produce = $_POST['produce_name'];
    $qty = $_POST['quantity'];
    $date = $_POST['harvest_date'];
    $loc = $_POST['storage_location'];

    $sql = "INSERT INTO inventory (produce_name, quantity, harvest_date, storage_location)
            VALUES ('$produce', '$qty', '$date', '$loc')";
    $conn->query($sql);
    header("Location: dashboard.php");
}
?>
