<?php
$conn = new mysqli("localhost", "root", "", "inventorymanagementsystem");

if (isset($_GET['delete_preventive'])) {
    $conn->query("DELETE FROM preventive_measures WHERE id = {$_GET['delete_preventive']}");
}
if (isset($_GET['delete_improvement'])) {
    $conn->query("DELETE FROM improvement_updates WHERE id = {$_GET['delete_improvement']}");
}

$edit_preventive = isset($_GET['edit_preventive']) ? $conn->query("SELECT * FROM preventive_measures WHERE id = {$_GET['edit_preventive']}")->fetch_assoc() : null;
$edit_improvement = isset($_GET['edit_improvement']) ? $conn->query("SELECT * FROM improvement_updates WHERE id = {$_GET['edit_improvement']}")->fetch_assoc() : null;

if (isset($_POST['update_preventive'])) {
    $conn->query("UPDATE preventive_measures SET product_id='{$_POST['product_id']}', batch_id='{$_POST['batch_id']}', farmer_name='{$_POST['farmer_name']}', farmer_id='{$_POST['farmer_id']}', reason='{$_POST['reason']}', suggestion='{$_POST['suggestion']}' WHERE id={$_POST['id']}");
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}
if (isset($_POST['update_improvement'])) {
    $conn->query("UPDATE improvement_updates SET product_id='{$_POST['product_id']}', batch_id='{$_POST['batch_id']}', farmer_name='{$_POST['farmer_name']}', farmer_id='{$_POST['farmer_id']}', update_status='{$_POST['update_status']}' WHERE id={$_POST['id']}");
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

if (isset($_POST['submit_preventive'])) {
    $conn->query("INSERT INTO preventive_measures (product_id, batch_id, farmer_name, farmer_id, reason, suggestion) VALUES ('{$_POST['product_id']}', '{$_POST['batch_id']}', '{$_POST['farmer_name']}', '{$_POST['farmer_id']}', '{$_POST['reason']}', '{$_POST['suggestion']}')");
}
if (isset($_POST['submit_improvement'])) {
    $conn->query("INSERT INTO improvement_updates (product_id, batch_id, farmer_name, farmer_id, update_status) VALUES ('{$_POST['product_id']}', '{$_POST['batch_id']}', '{$_POST['farmer_name']}', '{$_POST['farmer_id']}', '{$_POST['update_status']}')");
}

$search_preventive = $_GET['search_preventive'] ?? '';
$search_improvement = $_GET['search_improvement'] ?? '';

$preventive = $conn->query("SELECT * FROM preventive_measures WHERE farmer_name LIKE '%$search_preventive%' OR product_id LIKE '%$search_preventive%' ORDER BY id DESC");
$improvement = $conn->query("SELECT * FROM improvement_updates WHERE farmer_name LIKE '%$search_improvement%' OR product_id LIKE '%$search_improvement%' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHLI Dashboard</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background-image: url('Farm.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: white;
            margin-top: 40px;
            border-left: 5px solid #007bff;
            padding-left: 10px;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover { background-color: #0056b3; }
        .search-form {
            margin-bottom: 20px;
        }
        .search-form input {
            width: auto;
            display: inline-block;
            margin-right: 10px;
        }
        .btn-edit, .btn-delete {
            padding: 5px 10px;
            font-size: 13px;
            border-radius: 4px;
            color: white;
            margin-right: 5px;
        }
        .btn-edit { background-color: #28a745; }
        .btn-delete { background-color: #dc3545; }
        .btn-edit:hover { background-color: #218838; }
        .btn-delete:hover { background-color: #c82333; }
        table {
            width: 100%;
            background-color: #fff;
            border-collapse: collapse;
            margin-bottom: 40px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        table th, table td {
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            text-align: left;
        }
        table th {
            background-color: #007bff;
            color: white;
        }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: white;
            font-size: 16px;
        }
        @media (max-width: 768px) {
            table, form {
                font-size: 14px;
            }
            input, textarea {
                font-size: 13px;
            }
        }
    </style>
</head>
<body>

<h1>Preventive Measures</h1>
<form method="POST">
    <input type="hidden" name="id" value="<?= $edit_preventive['id'] ?? '' ?>">
    <input type="text" name="product_id" placeholder="Product ID" required value="<?= $edit_preventive['product_id'] ?? '' ?>">
    <input type="text" name="batch_id" placeholder="Batch ID" required value="<?= $edit_preventive['batch_id'] ?? '' ?>">
    <input type="text" name="farmer_name" placeholder="Farmer Name" required value="<?= $edit_preventive['farmer_name'] ?? '' ?>">
    <input type="text" name="farmer_id" placeholder="Farmer ID" required value="<?= $edit_preventive['farmer_id'] ?? '' ?>">
    <textarea name="reason" placeholder="Reason" required><?= $edit_preventive['reason'] ?? '' ?></textarea>
    <textarea name="suggestion" placeholder="Suggestion" required><?= $edit_preventive['suggestion'] ?? '' ?></textarea>
    <button name="<?= isset($edit_preventive) ? 'update_preventive' : 'submit_preventive' ?>">
        <?= isset($edit_preventive) ? 'Update Record' : 'Add Preventive Measure' ?>
    </button>
</form>

<form class="search-form" method="GET">
    <input type="text" name="search_preventive" placeholder="Search Preventive..." value="<?= htmlspecialchars($search_preventive) ?>">
    <button type="submit">Search</button>
</form>

<table>
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Batch ID</th>
            <th>Farmer Name</th>
            <th>Farmer ID</th>
            <th>Reason</th>
            <th>Suggestion</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $preventive->fetch_assoc()): ?>
            <tr>
                <td><?= $row['product_id'] ?></td>
                <td><?= $row['batch_id'] ?></td>
                <td><?= $row['farmer_name'] ?></td>
                <td><?= $row['farmer_id'] ?></td>
                <td><?= $row['reason'] ?></td>
                <td><?= $row['suggestion'] ?></td>
                <td><?= $row['created_at'] ?></td>
                <td class="actions">
                    <a href="?edit_preventive=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                    <a href="?delete_preventive=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Delete this record?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<h1>Improvement Updates</h1>
<form method="POST">
    <input type="hidden" name="id" value="<?= $edit_improvement['id'] ?? '' ?>">
    <input type="text" name="product_id" placeholder="Product ID" required value="<?= $edit_improvement['product_id'] ?? '' ?>">
    <input type="text" name="batch_id" placeholder="Batch ID" required value="<?= $edit_improvement['batch_id'] ?? '' ?>">
    <input type="text" name="farmer_name" placeholder="Farmer Name" required value="<?= $edit_improvement['farmer_name'] ?? '' ?>">
    <input type="text" name="farmer_id" placeholder="Farmer ID" required value="<?= $edit_improvement['farmer_id'] ?? '' ?>">
    <textarea name="update_status" placeholder="Update Status" required><?= $edit_improvement['update_status'] ?? '' ?></textarea>
    <button name="<?= isset($edit_improvement) ? 'update_improvement' : 'submit_improvement' ?>">
        <?= isset($edit_improvement) ? 'Update Record' : 'Add Improvement Update' ?>
    </button>
</form>

<form class="search-form" method="GET">
    <input type="text" name="search_improvement" placeholder="Search Improvements..." value="<?= htmlspecialchars($search_improvement) ?>">
    <button type="submit">Search</button>
</form>

<table>
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Batch ID</th>
            <th>Farmer Name</th>
            <th>Farmer ID</th>
            <th>Update Status</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $improvement->fetch_assoc()): ?>
            <tr>
                <td><?= $row['product_id'] ?></td>
                <td><?= $row['batch_id'] ?></td>
                <td><?= $row['farmer_name'] ?></td>
                <td><?= $row['farmer_id'] ?></td>
                <td><?= $row['update_status'] ?></td>
                <td><?= $row['created_at'] ?></td>
                <td class="actions">
                    <a href="?edit_improvement=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                    <a href="?delete_improvement=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Delete this record?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
