<?php
include 'db/db_connect.php';

$shipment_id = '';
$row = [
    'product_name' => '',
    'quantity' => '',
    'transport_mode' => '',
    'departure_date' => '',
    'arrival_date' => '',
    'loading_loss' => '',
    'unloading_loss' => ''
];

// GET existing shipment data
if (isset($_GET['id'])) {
    $shipment_id = $_GET['id'];

    $sql = "SELECT * FROM shipments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $shipment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Shipment not found.";
        exit();
    }

    $stmt->close();
}

// POST: update shipment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['shipment_id'])) {
    $shipment_id = $_POST['shipment_id'];
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $transport_mode = $_POST['transport_mode'];
    $departure_date = $_POST['departure_date'];
    $arrival_date = $_POST['arrival_date'];
    $loading_loss = $_POST['loading_loss'];
    $unloading_loss = $_POST['unloading_loss'];

    $sql = "UPDATE shipments 
            SET product_name = ?, quantity = ?, transport_mode = ?, departure_date = ?, arrival_date = ?, loading_loss = ?, unloading_loss = ?
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sissssii', $product_name, $quantity, $transport_mode, $departure_date, $arrival_date, $loading_loss, $unloading_loss, $shipment_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Shipment updated successfully!');
                window.location.href = 'shipment.php';
              </script>";
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Shipment</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="form-container">
        <h2>Edit Shipment</h2>
        <form method="POST">
            <input type="hidden" name="shipment_id" value="<?= htmlspecialchars($shipment_id) ?>">

            <label>Product Name:</label>
            <input type="text" name="product_name" value="<?= htmlspecialchars($row['product_name']) ?>" required>

            <label>Carrying Quantity:</label>
            <input type="number" name="quantity" value="<?= htmlspecialchars($row['quantity']) ?>" required>

            <label>Transport Mode:</label>
            <input type="text" name="transport_mode" value="<?= htmlspecialchars($row['transport_mode']) ?>" required>

            <label>Departure Date:</label>
            <input type="date" name="departure_date" value="<?= htmlspecialchars($row['departure_date']) ?>" required>

            <label>Arrival Date:</label>
            <input type="date" name="arrival_date" value="<?= htmlspecialchars($row['arrival_date']) ?>" required>

            <label>Loading Loss:</label>
            <input type="number" name="loading_loss" value="<?= htmlspecialchars($row['loading_loss']) ?>" required>

            <label>Unloading Loss:</label>
            <input type="number" name="unloading_loss" value="<?= htmlspecialchars($row['unloading_loss']) ?>" required>

            <button type="submit">Update Shipment</button>
            <a href="shipment.php"><button type="button">Cancel</button></a>
        </form>
    </div>
</body>
</html>
