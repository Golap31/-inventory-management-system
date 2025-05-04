<?php
include('../db.php');

// Check for status messages
$statusMessage = '';
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'success':
            $statusMessage = "Warehouse added successfully.";
            break;
        case 'updated':
            $statusMessage = "Warehouse updated successfully.";
            break;
        case 'deleted':
            $statusMessage = "Warehouse deleted successfully.";
            break;
        case 'error':
            $statusMessage = "An error occurred. Please try again.";
            break;
        case 'invalid':
            $statusMessage = "Invalid request.";
            break;
    }
}

// Fetch warehouse data
$sql = "SELECT id, name, location, address, capacity FROM warehouse";
$result = $conn->query($sql);

// Check if query was successful
if (!$result) {
    die("Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Warehouse Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #f4f4f4;
        }
        h2 {
            text-align: center;
        }
        .status {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            color: #fff;
            border-radius: 5px;
            width: 60%;
            margin-left: auto;
            margin-right: auto;
        }
        .success { background-color: #5cb85c; }
        .error { background-color: #d9534f; }
        .add-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #5bc0de;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #0275d8;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .actions a {
            padding: 6px 12px;
            text-decoration: none;
            margin: 0 5px;
            color: white;
            background-color: #5cb85c;
            border-radius: 4px;
        }
        .actions a.delete {
            background-color: #d9534f;
        }
    </style>
</head>
<body>

<h2>Warehouse Dashboard</h2>

<?php if ($statusMessage): ?>
    <div class="status <?= ($_GET['status'] == 'error' || $_GET['status'] == 'invalid') ? 'error' : 'success' ?>">
        <?= $statusMessage ?>
    </div>
<?php endif; ?>

<a href="add_form.php" class="add-btn">Add New Warehouse</a>

<table>
    <tr>
        <th>Name</th>
        <th>Location</th>
        <th>Address</th>
        <th>Capacity</th>
        <th>Actions</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['location']) ?></td>
            <td><?= htmlspecialchars($row['address']) ?></td>
            <td><?= htmlspecialchars($row['capacity']) ?></td>
            <td class="actions">
                <a href="edit_form.php?id=<?= $row['id'] ?>">Edit</a>
                <a href="delete_warehouse.php?id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Are you sure you want to delete this warehouse?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="5">No warehouses found.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>

<?php $conn->close(); ?>
