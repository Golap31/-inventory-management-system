<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Warehouse List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
      background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
                  url('https://t3.ftcdn.net/jpg/02/47/37/32/240_F_247373254_tI8NE7An2wy92KT4vovz37SCXnRQe7CO.jpg') no-repeat center center/cover;
      background-attachment: fixed;
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
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
      z-index: 1000;
    }

    .navbar .profile {
      display: flex;
      align-items: center;
    }

    .navbar .profile img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
      cursor: pointer;
      border: 2px solid white;
    }

    .navbar h2 {
      margin: 0;
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
      margin: 0;
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

    .dashboard {
      margin-left: 270px;
      margin-top: 80px;
      padding: 20px;
      color: white;
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 15px;
    }

    .card {
      padding: 20px;
      border-radius: 8px;
      color: white;
      text-align: center;
      font-weight: bold;
    }

    .blue { background: #2196F3; }
    .green { background: #4CAF50; }
    .orange { background: #FF9800; }
    .red { background: #F44336; }
    .purple { background: #9C27B0; }
    .teal { background: #009688; }
    .yellow { background: #FFC107; }
    .gray { background: #607D8B; }

    .charts {
      margin-top: 40px;
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      justify-content: center;
    }

    .chart-container {
      background: white;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      padding: 20px;
      width: 500px;
    }

    canvas {
      width: 100% !important;
      height: 300px !important;
    }
  </style>
  </head>
<body class="bg-light">
    <!-- Navbar -->
  <div class="navbar">
    <div class="profile">
      <img src="https://www.w3schools.com/howto/img_avatar.png" alt="User">
      <h2>Inventory</h2>
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
  <!-- Dashboard Content -->
  <div class="dashboard">
<div class="container mt-5">
    <h2 class="mb-4">📦 Inventory</h2>
    <a href="edit.php" class="btn btn-primary mb-3">➕ Add New Warehouse</a>

    <!-- Search Form -->
    <form method="GET" class="mb-4 d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Search by warehouse name..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
        <button type="submit" class="btn btn-secondary">🔍 Search</button>
    </form>

    <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>Warehouse Name</th>
                <th>Location</th>
                <th>Address</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Handle search input
            $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
            $sql = "SELECT * FROM warehouse_t";
            if (!empty($search)) {
                $sql .= " WHERE `Warehouse Name` LIKE '%$search%'";
            }

            $result = $conn->query($sql);
            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?= htmlspecialchars($row['Warehouse Name']) ?></td>
                <td><?= htmlspecialchars($row['Location']) ?></td>
                <td><?= htmlspecialchars($row['Address']) ?></td>
                <td><?= htmlspecialchars($row['Capacity']) ?></td>
                <td>
                    <a href="edit.php?name=<?= urlencode($row['Warehouse Name']) ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete.php?name=<?= urlencode($row['Warehouse Name']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this warehouse?')">Delete</a>
                </td>
            </tr>
            <?php
                endwhile;
            else:
            ?>
            <tr><td colspan="5" class="text-center">No warehouses found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
  </div>
</body>
</html>

<?php $conn->close(); ?>
