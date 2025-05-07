<?php include 'db.php'; ?>
<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>customer_view - Dashboard</title>
    <title>Customer List</title>
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
    <h2 class="mb-4">👥 Customer List</h2>
    <a href="customer_edit.php" class="btn btn-primary mb-3">➕ Add New Customer</a>

    <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>City</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM Customer_T";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?= htmlspecialchars($row['Customer_Name']) ?></td>
                <td><?= htmlspecialchars($row['Customer_Phone']) ?></td>
                <td><?= htmlspecialchars($row['Customer_Email']) ?></td>
                <td><?= htmlspecialchars($row['Customer_City']) ?></td>
                <td>
                    <a href="customer_edit.php?name=<?= urlencode($row['Customer_Name']) ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="customer_delete.php?name=<?= urlencode($row['Customer_Name']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</div>
</body>
</html>

<?php $conn->close(); ?>
