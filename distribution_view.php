<?php
include 'db.php';

$search = $_GET['search'] ?? '';
$search_sql = $conn->real_escape_string($search);

$sql = "SELECT * FROM Purchase_T";
if (!empty($search)) {
    $sql .= " WHERE Product_Purchased LIKE '%$search_sql%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Distribution Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
                        url('https://t3.ftcdn.net/jpg/02/47/37/32/240_F_247373254_tI8NE7An2wy92KT4vovz37SCXnRQe7CO.jpg') no-repeat center center/cover;
            color: white;
            min-height: 100vh;
            /* display: flex;
            min-height: 100vh; */
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
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
            background: #f8f9fa;
        }
        .topbar {
            background-color: #ffffff;
            padding: 10px 20px;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
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

<!-- Main content -->
<div class="dashboard-content">
<!-- <div class="main-content"> -->
    <!-- Topbar -->
    <div class="topbar d-flex justify-content-between align-items-center">
        <!-- <h4 class="mb-0">Distribution Records</h4> -->
        <div><strong>Date:</strong> <?= date("F j, Y") ?></div>
    </div>

    <!-- Search form -->
    <form method="GET" class="mb-4 row g-3">
        <div class="col-auto">
            <input type="text" name="search" class="form-control" placeholder="Search by Product Purchased" value="<?= htmlspecialchars($search) ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">🔍 Search</button>
            <a href="purchase_view.php" class="btn btn-secondary">🔄 Reset</a>
        </div>
    </form>

    <a href="purchase_edit.php" class="btn btn-success mb-3">➕ Add New Purchase</a>

    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
            <tr>
                <th>Purchase ID</th>
                <th>Total Amount</th>
                <th>Paid Amount</th>
                <th>Due Amount</th>
                <th>Product Purchased</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['Purchase_ID'] ?></td>
                        <td><?= $row['Toal_Amount'] ?></td>
                        <td><?= $row['Paid_Amount'] ?></td>
                        <td><?= $row['Due_Amount'] ?></td>
                        <td><?= $row['Product_Purchased'] ?></td>
                        <td>
                            <a href="purchase_edit.php?id=<?= $row['Purchase_ID'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="purchase_delete.php?id=<?= $row['Purchase_ID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this purchase?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-danger">No purchase records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
