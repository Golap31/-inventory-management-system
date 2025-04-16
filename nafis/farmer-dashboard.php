<?php
include 'db.php';
session_start();

if (!isset($_SESSION['farmer_id'])) {
    header("Location: login.php");
    exit;
}

$farmer_id = $_SESSION['farmer_id'];
?>

<h2>Welcome, <?php echo $_SESSION['farmer_name']; ?>!</h2>
<a href="logout.php">Logout</a>

<h3>Your Inventory</h3>
<table border="1">
    <tr>
        <th>Crop</th>
        <th>Quantity</th>
        <th>Harvest Date</th>
        <th>Status</th>
    </tr>

    <?php
    $sql = "SELECT * FROM inventory WHERE farmer_id = $farmer_id";
    $result = $conn->query($sql);
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['crop_name']}</td>
            <td>{$row['quantity']}</td>
            <td>{$row['harvest_date']}</td>
            <td>{$row['storage_status']}</td>
        </tr>";
    }
    ?>
</table>

<h3>Add Crop</h3>
<form method="POST">
    Crop Name: <input type="text" name="crop_name"><br>
    Quantity (kg): <input type="number" name="quantity"><br>
    Harvest Date: <input type="date" name="harvest_date"><br>
    Status: <input type="text" name="status"><br>
    <input type="submit" name="add_crop" value="Add Crop">
</form>

<?php
if (isset($_POST['add_crop'])) {
    $crop = $_POST['crop_name'];
    $qty = $_POST['quantity'];
    $date = $_POST['harvest_date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO inventory (farmer_id, crop_name, quantity, harvest_date, storage_status)
            VALUES ($farmer_id, '$crop', $qty, '$date', '$status')";

    if ($conn->query($sql)) {
        echo "Crop added successfully.";
        header("Refresh:0");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
