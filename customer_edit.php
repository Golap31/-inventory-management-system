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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $edit ? "Edit Customer" : "Add Customer" ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
                        url('https://t3.ftcdn.net/jpg/02/47/37/32/240_F_247373254_tI8NE7An2wy92KT4vovz37SCXnRQe7CO.jpg') no-repeat center center/cover;
            color: white;
            min-height: 100vh;
        }
        .navbar {
            background-color: #d32f2f;
            color: white;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            height: 50px;
            z-index: 1000;
        }
        .navbar .profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            border: 2px solid white;
        }
        .sidebar {
            width: 250px;
            background-color: #d32f2f;
            color: white;
            height: 100vh;
            padding-top: 80px;
            position: fixed;
            top: 0;
            left: 0;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li a {
            display: block;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
        }
        .sidebar ul li a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .dashboard-content {
            margin-left: 270px;
            margin-top: 80px;
            padding: 20px;
        }
        .table-container {
            background: rgba(255, 255, 255, 0.95);
            color: black;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }
    </style>
<body class="bg-light">
    <!-- Navbar -->
<div class="navbar">
    <div class="profile d-flex align-items-center">
        <img src="https://www.w3schools.com/howto/img_avatar.png" alt="User">
        <h4 class="mb-0">Inventory</h4>
    </div>
</div>
<!-- Sidebar -->
<div class="sidebar">
    <ul>
       <!--Rose-->
      <li><a href="crud_app\products.php">🏢 Inventory Tracking</a></li>
      

      <!-- nafij -->
      <li><a href="nafis/inventorymanagementsystem/monitoring.php">📦Real Time Monitoring</a></li>

      <li><a href="purchase_view.php">📦 Sales and Distribution</a></li>

      <li><a href="nafis/inventorymanagementsystem/shipment.php">🚚 Loss recording</a></li>

      <li><a href="Jarif/dashboard.php">📊Loss Analysis</a></li>

      <li><a href="Riyad/dashboard.php">Prevention and Improviment</a></li>

      <!-- joti -->
      <!-- <li><a href="purchase_view.php">📦 Sales and Distribution</a></li>
      <li><a href="distribution_view.php">📦 Distribution</a></li> -->

      <!-- Saad -->
      <li><a href="saad/warehouse.php">🏢 Warehouse Management</a></li>
      <li><a href="warehouse_view.php">🏢 Inventory</a></li>
      
      
      <li><a href="customer_view.php">📦 Add Customer</a></li>


      
      <li><a href="home.php">Logout</a></li>
    </ul>
</div>
<div class="dashboard-content">
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
</div>
</body>
</html>

<?php $conn->close(); ?>
