<?php include 'db.php';

$id = $shipment = $buyer = $qty = $date = $price = $location = "";
$edit = false;

if (isset($_GET['id'])) {
    $edit = true;
    $stmt = $conn->prepare("SELECT * FROM SALES_DISTRIBUTION WHERE Sales_ID = ?");
    $stmt->bind_param("s", $_GET['id']);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows) {
        $row = $res->fetch_assoc();
        $id = $row['Sales_ID'];
        $shipment = $row['Shipment_ID'];
        $buyer = $row['Buyer_Name'];
        $qty = $row['Quantity_Sold'];
        $date = $row['SaleDate'];
        $price = $row['SalePricePerUnit'];
        $location = $row['MarketLocation'];
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $shipment = $_POST['shipment'];
    $buyer = $_POST['buyer'];
    $qty = $_POST['quantity'];
    $date = $_POST['date'];
    $price = $_POST['price'];
    $location = $_POST['location'];

    if (isset($_POST['original_id'])) {
        $original = $_POST['original_id'];
        $stmt = $conn->prepare("UPDATE SALES_DISTRIBUTION SET Sales_ID=?, Shipment_ID=?, Buyer_Name=?, Quantity_Sold=?, SaleDate=?, SalePricePerUnit=?, MarketLocation=? WHERE Sales_ID=?");
        $stmt->bind_param("ssssssss", $id, $shipment, $buyer, $qty, $date, $price, $location, $original);
    } else {
        $stmt = $conn->prepare("INSERT INTO SALES_DISTRIBUTION (Sales_ID, Shipment_ID, Buyer_Name, Quantity_Sold, SaleDate, SalePricePerUnit, MarketLocation) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $id, $shipment, $buyer, $qty, $date, $price, $location);
    }

    if ($stmt->execute()) {
        header("Location: distribution_view.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $edit ? "Edit Sale" : "Add Sale" ?> - Distribution</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2><?= $edit ? "✏️ Edit Sale Record" : "➕ Add Sale Record" ?></h2>
    <form method="post" class="mt-4">
        <div class="mb-3"><label>Sales ID</label><input type="text" name="id" class="form-control" required value="<?= htmlspecialchars($id) ?>"></div>
        <div class="mb-3"><label>Shipment ID</label><input type="text" name="shipment" class="form-control" required value="<?= htmlspecialchars($shipment) ?>"></div>
        <div class="mb-3"><label>Buyer Name</label><textarea name="buyer" class="form-control" required><?= htmlspecialchars($buyer) ?></textarea></div>
        <div class="mb-3"><label>Quantity Sold</label><input type="number" name="quantity" class="form-control" required value="<?= htmlspecialchars($qty) ?>"></div>
        <div class="mb-3"><label>Sale Date</label><input type="date" name="date" class="form-control" required value="<?= htmlspecialchars($date) ?>"></div>
        <div class="mb-3"><label>Sale Price/Unit</label><input type="number" name="price" class="form-control" required value="<?= htmlspecialchars($price) ?>"></div>
        <div class="mb-3"><label>Market Location</label><input type="text" name="location" class="form-control" required value="<?= htmlspecialchars($location) ?>"></div>

        <?php if ($edit): ?>
            <input type="hidden" name="original_id" value="<?= htmlspecialchars($id) ?>">
        <?php endif; ?>

        <button type="submit" class="btn btn-success"><?= $edit ? "Update" : "Add" ?> Sale</button>
        <a href="distribution_view.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
