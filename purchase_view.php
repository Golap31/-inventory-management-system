<?php
include 'db.php';

$sql = "SELECT * FROM Purchase_T";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Purchases</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2 class="mb-4">Purchase Records</h2>
    <a href="purchase_edit.php" class="btn btn-success mb-3">Add New Purchase</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Total</th>
                <th>Paid</th>
                <th>Due</th>
                <th>Product Purchased</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['Purchase_ID'] ?></td>
                <td><?= $row['Toal_Amount'] ?></td>
                <td><?= $row['Paid_Amount'] ?></td>
                <td><?= $row['Due_Amount'] ?></td>
                <td><?= $row['Product_Purchased'] ?></td>
                <td>
                    <a href="purchase_edit.php?id=<?= $row['Purchase_ID'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="purchase_delete.php?id=<?= $row['Purchase_ID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
