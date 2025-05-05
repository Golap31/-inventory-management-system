<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales Distribution Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">📦 Sales Distribution Records</h2>

    <form method="GET" class="mb-4 row g-3">
        <div class="col-auto">
            <input type="text" name="search" class="form-control" placeholder="Search by Buyer or Market" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">🔍 Search</button>
            <a href="distribution_view.php" class="btn btn-secondary">🔄 Reset</a>
        </div>
    </form>

    <a href="distribution_edit.php" class="btn btn-success mb-3">➕ Add New Sale</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Sales ID</th>
                <th>Shipment ID</th>
                <th>Buyer Name</th>
                <th>Quantity</th>
                <th>Date</th>
                <th>Price/Unit</th>
                <th>Market Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $search = $_GET['search'] ?? '';
        $search_sql = $conn->real_escape_string($search);

        $sql = "SELECT * FROM SALES_DISTRIBUTION";
        if (!empty($search)) {
            $sql .= " WHERE Buyer_Name LIKE '%$search_sql%' OR MarketLocation LIKE '%$search_sql%'";
        }

        $result = $conn->query($sql);
        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
        ?>
            <tr>
                <td><?= $row['Sales_ID'] ?></td>
                <td><?= $row['Shipment_ID'] ?></td>
                <td><?= $row['Buyer_Name'] ?></td>
                <td><?= $row['Quantity_Sold'] ?></td>
                <td><?= $row['SaleDate'] ?></td>
                <td><?= $row['SalePricePerUnit'] ?></td>
                <td><?= $row['MarketLocation'] ?></td>
                <td>
                    <a href="distribution_edit.php?id=<?= $row['Sales_ID'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="distribution_delete.php?id=<?= $row['Sales_ID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this sale?')">Delete</a>
                </td>
            </tr>
        <?php
            endwhile;
        else:
        ?>
            <tr>
                <td colspan="8" class="text-center text-danger">No records found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
