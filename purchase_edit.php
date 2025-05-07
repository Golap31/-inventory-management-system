<?php
include 'db.php';

$purchaseID = $_GET['id'] ?? '';
$edit = false;
$Toal_Amount = $Paid_Amount = $Due_Amount = $Product_Purchased = '';

if ($purchaseID) {
    $edit = true;
    $stmt = $conn->prepare("SELECT * FROM Purchase_T WHERE Purchase_ID = ?");
    $stmt->bind_param("s", $purchaseID);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result) {
        $Toal_Amount = $result['Toal_Amount'];
        $Paid_Amount = $result['Paid_Amount'];
        $Due_Amount = $result['Due_Amount'];
        $Product_Purchased = $result['Product_Purchased'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['Purchase_ID'];
    $total = $_POST['Toal_Amount'];
    $paid = $_POST['Paid_Amount'];
    $due = $_POST['Due_Amount'];
    $product = $_POST['Product_Purchased'];

    if ($_POST['edit_mode'] == '1') {
        $stmt = $conn->prepare("UPDATE Purchase_T SET Toal_Amount=?, Paid_Amount=?, Due_Amount=?, Product_Purchased=? WHERE Purchase_ID=?");
        $stmt->bind_param("iiiis", $total, $paid, $due, $product, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO Purchase_T (Purchase_ID, Toal_Amount, Paid_Amount, Due_Amount, Product_Purchased) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siiii", $id, $total, $paid, $due, $product);
    }

    $stmt->execute();
    header("Location: purchase_view.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $edit ? 'Edit Purchase' : 'Add Purchase' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            color: black;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            max-width: 600px;
        }
    </style>
</head>
<body>

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

<!-- Content -->
<div class="dashboard-content">
    <div class="form-container">
        <h2 class="mb-4"><?= $edit ? 'Edit Purchase' : 'Add Purchase' ?></h2>
        <form method="POST">
            <input type="hidden" name="edit_mode" value="<?= $edit ? '1' : '0' ?>">

            <div class="mb-3">
                <label for="Purchase_ID" class="form-label">Purchase ID</label>
                <input type="text" class="form-control" id="Purchase_ID" name="Purchase_ID" value="<?= $purchaseID ?>" <?= $edit ? 'readonly' : '' ?> required>
            </div>

            <div class="mb-3">
                <label for="Toal_Amount" class="form-label">Total Amount</label>
                <input type="number" class="form-control" id="Toal_Amount" name="Toal_Amount" value="<?= $Toal_Amount ?>" required>
            </div>

            <div class="mb-3">
                <label for="Paid_Amount" class="form-label">Paid Amount</label>
                <input type="number" class="form-control" id="Paid_Amount" name="Paid_Amount" value="<?= $Paid_Amount ?>" required>
            </div>

            <div class="mb-3">
                <label for="Due_Amount" class="form-label">Due Amount</label>
                <input type="number" class="form-control" id="Due_Amount" name="Due_Amount" value="<?= $Due_Amount ?>" required>
            </div>

            <div class="mb-3">
                <label for="Product_Purchased" class="form-label">Product Purchased</label>
                <input type="number" class="form-control" id="Product_Purchased" name="Product_Purchased" value="<?= $Product_Purchased ?>" required>
            </div>

            <button type="submit" class="btn btn-primary"><?= $edit ? 'Update' : 'Submit' ?></button>
            <a href="purchase_view.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

</body>
</html>
