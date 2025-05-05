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

    <!-- Search Form -->
    <!-- Search Form -->
<form method="GET" class="mb-4 d-flex">
    <input type="text" name="search" class="form-control me-2" placeholder="Search by warehouse name..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
    <button type="submit" class="btn btn-secondary me-2">🔍 Search</button>
    <a href="warehouse_list.php" class="btn btn-outline-secondary">🔄 Reset</a>
</form>


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
            // Handle search input
            $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
            $sql = "SELECT * FROM warehouse_t";
            if (!empty($search)) {
                $sql .= " WHERE `Warehouse Name` LIKE '%$search%'";
            }

            $result = $conn->query($sql);
            if ($result->num_rows > 0):
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
            <?php
                endwhile;
            else:
            ?>
            <tr><td colspan="5" class="text-center">No warehouses found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php $conn->close(); ?>
