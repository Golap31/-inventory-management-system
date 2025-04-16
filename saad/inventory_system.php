<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'inventory_system';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all inventory items
$inventory = $conn->query("SELECT * FROM inventory");

// Check for expiring items (older than 5 days)
$expiring = $conn->query("SELECT * FROM inventory WHERE DATEDIFF(CURDATE(), harvest_date) >= 5");

// Fetch all loss records
$losses = $conn->query("SELECT * FROM losses");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory Dashboard</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        h1, h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #f2f2f2; }
        .alert { background-color: #ffe0e0; padding: 10px; border: 1px solid red; margin: 10px 0; }
    </style>
</head>
<body>

<h1>📦 Inventory Management Dashboard</h1>

<h2>Real-time Storage Conditions (Simulated)</h2>
<p>Temperature: <b>12°C</b></p>
<p>Humidity: <b>85%</b></p>

<h2>Expiring Soon 🚨</h2>
<?php if ($expiring->num_rows > 0): ?>
    <div class="alert">
        <ul>
            <?php while($item = $expiring->fetch_assoc()): ?>
                <li><b><?= $item['produce_name'] ?></b> (Harvested: <?= $item['harvest_date'] ?>)</li>
            <?php endwhile; ?>
        </ul>
    </div>
<?php else: ?>
    <p>No produce nearing expiry.</p>
<?php endif; ?>

<h2>Inventory List 🧺</h2>
<table>
    <tr>
        <th>Produce</th>
        <th>Quantity</th>
        <th>Harvest Date</th>
        <th>Storage Location</th>
    </tr>
    <?php while($row = $inventory->fetch_assoc()): ?>
    <tr>
        <td><?= $row['produce_name'] ?></td>
        <td><?= $row['quantity'] ?></td>
        <td><?= $row['harvest_date'] ?></td>
        <td><?= $row['storage_location'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<h2>Loss Records ❌</h2>
<table>
    <tr>
        <th>Produce</th>
        <th>Quantity Lost</th>
        <th>Reason</th>
        <th>Stage</th>
        <th>Date</th>
    </tr>
    <?php while($loss = $losses->fetch_assoc()): ?>
    <tr>
        <td><?= $loss['produce_name'] ?></td>
        <td><?= $loss['quantity'] ?></td>
        <td><?= $loss['reason'] ?></td>
        <td><?= $loss['loss_stage'] ?></td>
        <td><?= $loss['loss_date'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<h2>Add New Inventory</h2>
<form method="POST" action="add_inventory.php">
    <input type="text" name="produce_name" placeholder="Produce Name" required>
    <input type="number" name="quantity" placeholder="Quantity" required>
    <input type="date" name="harvest_date" required>
    <input type="text" name="storage_location" placeholder="Storage Location" required>
    <button type="submit">Add</button>
</form>

<h2>Record Loss</h2>
<form method="POST" action="record_loss.php">
    <input type="text" name="produce_name" placeholder="Produce Name" required>
    <input type="number" name="quantity" placeholder="Lost Quantity" required>
    <input type="text" name="reason" placeholder="Reason" required>
    <select name="loss_stage" required>
        <option value="">--Stage--</option>
        <option value="Harvesting">Harvesting</option>
        <option value="Storage">Storage</option>
        <option value="Transport">Transport</option>
    </select>
    <button type="submit">Record Loss</button>
</form>

</body>
</html>
