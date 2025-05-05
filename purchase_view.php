<?php
include 'db.php';

$sql = "SELECT * FROM Purchase_T";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Records - Dashboard</title>
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
        .table-container {
            background: rgba(255, 255, 255, 0.95);
            color: black;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
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
        <!-- Rose -->
      <li><a href="crud_app/products.php">Products</a></li>
      <li><a href="crud_app/harvest/harvestbatch.php">Harvest</a></li>

      <!-- nafij -->
      <li><a href="nafis/inventorymanagementsystem/shipment.php">🚚 Shipment Tracking</a></li>
      <li><a href="nafis/inventorymanagementsystem/monitoring.php">📦Real Time Monitoring</a></li>


      <!-- Saad -->
      <li><a href="saad/warehouse.php">🏢 Warehouse Management</a></li>
      
      <!-- joti -->
      <!-- <li><a href="purchase_view.php">📦 Purchase Records</a></li> -->
      <li><a href="purchase_view.php">📦 Purchase Records</a></li>

      <!-- loss record page -->
      <li><a href="Jarif/dashboard.php">📊Loss Analysis</a></li>

      <!-- riyad -->
      <li><a href="Riyad/dashboard.php">Preventive Measures</a></li>

      
      <li><a href="home.php">Logout</a></li>
    </ul>
</div>

<!-- Content -->
<div class="dashboard-content">
    <div class="table-container">
        <h2 class="mb-4">Purchase Records</h2>
        <a href="purchase_edit.php" class="btn btn-success mb-3">Add New Purchase</a>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Due</th>
                    <th>Product Purchased</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['Purchase_ID'] ?></td>
                    <td><?= $row['Toal_Amount'] ?></td>
                    <td><?= $row['Paid_Amount'] ?></td>
                    <td><?= $row['Due_Amount'] ?></td>
                    <td><?= $row['Product_Purchased'] ?></td>
                    <td>
                        <a href="purchase_edit.php?id=<?= $row['Purchase_ID'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="purchase_delete.php?id=<?= $row['Purchase_ID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
