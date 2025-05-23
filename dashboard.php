<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Inventory Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
<body>

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
    <!-- Chart Section -->
    <div class="charts">
      <div class="chart-container">
        <h3>Monthly Sales</h3>
        <canvas id="barChart"></canvas>
      </div>
      <div class="chart-container">
        <h3>Order Status</h3>
        <canvas id="pieChart"></canvas>
      </div>
    </div>
  </div>

  <script>
    // Bar Chart Example
    const barCtx = document.getElementById('barChart');
    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        datasets: [{
          label: 'Sales',
          data: [12, 19, 3, 5, 9],
          backgroundColor: '#4CAF50'
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: { beginAtZero: true }
        }
      }
    });

    // Pie Chart Example
    const pieCtx = document.getElementById('pieChart');
    new Chart(pieCtx, {
      type: 'pie',
      data: {
        labels: ['Paid', 'Unpaid'],
        datasets: [{
          label: 'Orders',
          data: [75, 25],
          backgroundColor: ['#FFC107', '#F44336']
        }]
      },
      options: {
        responsive: true
      }
    });
  </script>

</body>
</html>
