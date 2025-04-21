<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Dashboard</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; display: flex; flex-direction: column; }
        .navbar {
            background-color: #2b2828; color: white; padding: 10px;
            display: flex; align-items: center; justify-content: space-between;
            position: fixed; width: 100%; top: 0; height: 50px; box-shadow: 0 4px 6px rgba(0,0,0,0.2); z-index: 1000;
        }
        .navbar .profile { display: flex; align-items: center; }
        .navbar .profile img { width: 40px; height: 40px; border-radius: 50%; margin-right: 10px; border: 2px solid white; }
        .navbar h2 { margin: 0; }

        .sidebar {
            width: 250px; background-color: #363434c5; color: #d7cccc;
            height: 100vh; padding-top: 80px; position: fixed; top: 0; left: 0;
        }
        .sidebar ul { list-style: none; padding: 0; }
        .sidebar ul li {
            padding: 15px; border-bottom: 1px solid rgba(242,235,235,0.2); cursor: pointer;
        }
        .sidebar ul li:hover { background: rgba(64, 63, 63, 0.2); }

        .dashboard {
            margin-left: 270px; margin-top: 80px; padding: 20px; background: #6a3b3b; color: white;
        }
        .cards {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;
        }
        .card {
            padding: 20px; border-radius: 8px; text-align: center; font-weight: bold; color: white;
        }
        .blue { background: #2196F3; }
        .green { background: #4CAF50; }
        .orange { background: #FF9800; }
        .red { background: #F44336; }
        .purple { background: #9C27B0; }
        .teal { background: #009688; }
        .yellow { background: #FFC107; }
        .gray { background: #607D8B; }
    </style>
</head>
<body>

<div class="navbar">
    <div class="profile">
        <img src="https://via.placeholder.com/40" alt="User">
        <h2>Admin</h2>
    </div>
</div>

<div class="sidebar">
    <ul>
        <li>Dashboard</li>
        <li>Items</li>
        <li>Category</li>
        <li>Warehouse</li>
        <li>Elements</li>
        <li>Products</li>
        <li>Orders</li>
        <li>Members</li>
        <li>Permissions</li>
        <li>Company</li>
        <li>Logout</li>
    </ul>
</div>

<div class="dashboard">
    <h1>Dashboard</h1>
    <div class="cards">
        <div class="card blue"><h1><?= $totalItems ?></h1>Total Items</div>
        <div class="card purple"><h1><?= $totalCategories ?></h1>Total Category</div>
        <div class="card orange"><h1><?= $totalElements ?></h1>Total Elements</div>
        <div class="card green"><h1><?= $totalSales ?></h1>Total Sales</div>
        <div class="card teal"><h1><?= $totalProducts ?></h1>Total Products</div>
        <div class="card yellow"><h1><?= $paidOrders ?></h1>Paid Orders</div>
        <div class="card red"><h1><?= $unpaidOrders ?></h1>Unpaid Orders</div>
        <div class="card gray"><h1><?= $totalMembers ?></h1>Total Members</div>
    </div>
</div>

</body>
</html>