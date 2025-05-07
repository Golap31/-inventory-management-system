<!-- header.php -->
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

<style>
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
    z-index: 999;
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
</style>
