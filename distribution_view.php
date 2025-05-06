<?php
include 'db.php';

$search = $_GET['search'] ?? '';
$search_sql = $conn->real_escape_string($search);

$sql = "SELECT * FROM Purchase_T";
if (!empty($search)) {
    $sql .= " WHERE Product_Purchased LIKE '%$search_sql%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Purchase Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 240px;
            background-color: #343a40;
            padding-top: 20px;
            color: white;
            height: 100vh;
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
            background: #f8f9fa;
        }
        .topbar {
            background-color: #ffffff;
            padding: 10px 20px;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-center mb-4">📊 Dashboard</h4>
    <a href="dashboard.php">🏠 Home</a>
    <a href="purchase_view.php" class="bg-secondary">🧾 Purchases</a>
    <a href="distribution_view.php">🚚 Distribution</a>
    <a href="customer_view.php">👥 Customers</a>
    <a href="product_view.php">📦 Products</a>
</div>

<!-- Main content -->
<div class="main-content">
    <!-- Topbar -->
    <div class="topbar d-flex justify-content-between align-items-center">
        <h4 class="mb-0">🧾 Purchase Records</h4>
        <div><strong>Date:</strong> <?= date("F j, Y") ?></div>
    </div>

    <!-- Search form -->
    <form method="GET" class="mb-4 row g-3">
        <div class="col-auto">
            <input type="text" name="search" class="form-control" placeholder="Search by Product Purchased" value="<?= htmlspecialchars($search) ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">🔍 Search</button>
            <a href="purchase_view.php" class="btn btn-secondary">🔄 Reset</a>
        </div>
    </form>

    <a href="purchase_edit.php" class="btn btn-success mb-3">➕ Add New Purchase</a>

    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
            <tr>
                <th>Purchase ID</th>
                <th>Total Amount</th>
                <th>Paid Amount</th>
                <th>Due Amount</th>
                <th>Product Purchased</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['Purchase_ID'] ?></td>
                        <td><?= $row['Toal_Amount'] ?></td>
                        <td><?= $row['Paid_Amount'] ?></td>
                        <td><?= $row['Due_Amount'] ?></td>
                        <td><?= $row['Product_Purchased'] ?></td>
                        <td>
                            <a href="purchase_edit.php?id=<?= $row['Purchase_ID'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="purchase_delete.php?id=<?= $row['Purchase_ID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this purchase?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-danger">No purchase records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
