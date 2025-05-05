<?php
include 'db.php';

$purchaseID = $_GET['id'] ?? '';
$edit = false;
$Toal_Amount = $Paid_Amount = $Due_Amount = $Product_Purchased = '';

if ($purchaseID) {
    $edit = true;
    $stmt = $conn->prepare("SELECT * FROM Purchase_T WHERE Purchase_ID = ?");
    $stmt->bind_param("s", $purchaseID);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result) {
        $Toal_Amount = $result['Toal_Amount'];
        $Paid_Amount = $result['Paid_Amount'];
        $Due_Amount = $result['Due_Amount'];
        $Product_Purchased = $result['Product_Purchased'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['Purchase_ID'];
    $total = $_POST['Toal_Amount'];
    $paid = $_POST['Paid_Amount'];
    $due = $_POST['Due_Amount'];
    $product = $_POST['Product_Purchased'];

    if ($_POST['edit_mode'] == '1') {
        $stmt = $conn->prepare("UPDATE Purchase_T SET Toal_Amount=?, Paid_Amount=?, Due_Amount=?, Product_Purchased=? WHERE Purchase_ID=?");
        $stmt->bind_param("iiiis", $total, $paid, $due, $product, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO Purchase_T (Purchase_ID, Toal_Amount, Paid_Amount, Due_Amount, Product_Purchased) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siiii", $id, $total, $paid, $due, $product);
    }

    $stmt->execute();
    header("Location: purchase_view.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $edit ? 'Edit Purchase' : 'Add Purchase' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2 class="mb-4"><?= $edit ? 'Edit Purchase' : 'Add Purchase' ?></h2>
    <form method="POST" class="border p-4 shadow-sm rounded">
        <input type="hidden" name="edit_mode" value="<?= $edit ? '1' : '0' ?>">

        <div class="mb-3">
            <label for="Purchase_ID" class="form-label">Purchase ID</label>
            <input type="text" class="form-control" id="Purchase_ID" name="Purchase_ID" value="<?= $purchaseID ?>" <?= $edit ? 'readonly' : '' ?> required>
        </div>

        <div class="mb-3">
            <label for="Toal_Amount" class="form-label">Total Amount</label>
            <input type="number" class="form-control" id="Toal_Amount" name="Toal_Amount" value="<?= $Toal_Amount ?>" required>
        </div>

        <div class="mb-3">
            <label for="Paid_Amount" class="form-label">Paid Amount</label>
            <input type="number" class="form-control" id="Paid_Amount" name="Paid_Amount" value="<?= $Paid_Amount ?>" required>
        </div>

        <div class="mb-3">
            <label for="Due_Amount" class="form-label">Due Amount</label>
            <input type="number" class="form-control" id="Due_Amount" name="Due_Amount" value="<?= $Due_Amount ?>" required>
        </div>

        <div class="mb-3">
            <label for="Product_Purchased" class="form-label">Product Purchased</label>
            <input type="number" class="form-control" id="Product_Purchased" name="Product_Purchased" value="<?= $Product_Purchased ?>" required>
        </div>

        <button type="submit" class="btn btn-primary"><?= $edit ? 'Update' : 'Submit' ?></button>
        <a href="purchase_view.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
