<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">👥 Customer List</h2>
    <a href="customer_edit.php" class="btn btn-primary mb-3">➕ Add New Customer</a>

    <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>City</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM Customer_T";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?= htmlspecialchars($row['Customer_Name']) ?></td>
                <td><?= htmlspecialchars($row['Customer_Phone']) ?></td>
                <td><?= htmlspecialchars($row['Customer_Email']) ?></td>
                <td><?= htmlspecialchars($row['Customer_City']) ?></td>
                <td>
                    <a href="customer_edit.php?name=<?= urlencode($row['Customer_Name']) ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="customer_delete.php?name=<?= urlencode($row['Customer_Name']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php $conn->close(); ?>
