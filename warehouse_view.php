<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Warehouse List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">📦 Warehouse List</h2>
    <a href="edit.php" class="btn btn-primary mb-3">➕ Add New Warehouse</a>

    <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>Warehouse Name</th>
                <th>Location</th>
                <th>Address</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM warehouse_t";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?= htmlspecialchars($row['Warehouse Name']) ?></td>
                <td><?= htmlspecialchars($row['Location']) ?></td>
                <td><?= htmlspecialchars($row['Address']) ?></td>
                <td><?= htmlspecialchars($row['Capacity']) ?></td>
                <td>
                    <a href="edit.php?name=<?= urlencode($row['Warehouse Name']) ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete.php?name=<?= urlencode($row['Warehouse Name']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this warehouse?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php $conn->close(); ?>
