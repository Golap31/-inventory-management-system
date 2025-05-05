<?php include 'db.php';

$name = $location = $address = $capacity = "";
$edit = false;

if (isset($_GET['name'])) {
    $edit = true;
    $stmt = $conn->prepare("SELECT * FROM warehouse_t WHERE `Warehouse Name` = ?");
    $stmt->bind_param("s", $_GET['name']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows) {
        $data = $result->fetch_assoc();
        $name = $data['Warehouse Name'];
        $location = $data['Location'];
        $address = $data['Address'];
        $capacity = $data['Capacity'];
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $address = $_POST['address'];
    $capacity = $_POST['capacity'];

    if (isset($_POST['edit_old_name'])) {
        $old_name = $_POST['edit_old_name'];
        $stmt = $conn->prepare("UPDATE warehouse_t SET `Warehouse Name`=?, `Location`=?, `Address`=?, `Capacity`=? WHERE `Warehouse Name`=?");
        $stmt->bind_param("sssds", $name, $location, $address, $capacity, $old_name);
    } else {
        $stmt = $conn->prepare("INSERT INTO warehouse_t (`Warehouse Name`, `Location`, `Address`, `Capacity`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssd", $name, $location, $address, $capacity);
    }

    if ($stmt->execute()) {
        header("Location: warehouse_view.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $edit ? "Edit Warehouse" : "Add Warehouse" ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2><?= $edit ? "✏️ Edit Warehouse" : "➕ Add New Warehouse" ?></h2>
    <form method="post" class="mt-4">
        <div class="mb-3">
            <label class="form-label">Warehouse Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($location) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($address) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Capacity</label>
            <input type="number" name="capacity" class="form-control" value="<?= htmlspecialchars($capacity) ?>" required>
        </div>

        <?php if ($edit): ?>
            <input type="hidden" name="edit_old_name" value="<?= htmlspecialchars($_GET['name']) ?>">
        <?php endif; ?>

        <button type="submit" class="btn btn-success"><?= $edit ? "Update" : "Add" ?> Warehouse</button>
        <a href="warehouse_view.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>

<?php $conn->close(); ?>
