<?php include 'db.php';

$name = $phone = $email = $city = "";
$edit = false;

if (isset($_GET['name'])) {
    $edit = true;
    $stmt = $conn->prepare("SELECT * FROM Customer_T WHERE Customer_Name = ?");
    $stmt->bind_param("s", $_GET['name']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows) {
        $data = $result->fetch_assoc();
        $name = $data['Customer_Name'];
        $phone = $data['Customer_Phone'];
        $email = $data['Customer_Email'];
        $city = $data['Customer_City'];
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $city = $_POST['city'];

    if (isset($_POST['edit_old_name'])) {
        $old_name = $_POST['edit_old_name'];
        $stmt = $conn->prepare("UPDATE Customer_T SET Customer_Name=?, Customer_Phone=?, Customer_Email=?, Customer_City=? WHERE Customer_Name=?");
        $stmt->bind_param("sssss", $name, $phone, $email, $city, $old_name);
    } else {
        $stmt = $conn->prepare("INSERT INTO Customer_T (Customer_Name, Customer_Phone, Customer_Email, Customer_City) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $phone, $email, $city);
    }

    if ($stmt->execute()) {
        header("Location: customer_view.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $edit ? "Edit Customer" : "Add Customer" ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2><?= $edit ? "✏️ Edit Customer" : "➕ Add New Customer" ?></h2>
    <form method="post" class="mt-4">
        <div class="mb-3">
            <label class="form-label">Customer Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($phone) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">City</label>
            <input type="text" name="city" class="form-control" value="<?= htmlspecialchars($city) ?>" required>
        </div>

        <?php if ($edit): ?>
            <input type="hidden" name="edit_old_name" value="<?= htmlspecialchars($_GET['name']) ?>">
        <?php endif; ?>

        <button type="submit" class="btn btn-success"><?= $edit ? "Update" : "Add" ?> Customer</button>
        <a href="customer_view.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>

<?php $conn->close(); ?>
