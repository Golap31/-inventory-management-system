<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory & Post-Harvest Loss Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: url('https://t3.ftcdn.net/jpg/02/47/37/32/240_F_247373254_tI8NE7An2wy92KT4vovz37SCXnRQe7CO.jpg') no-repeat center center/cover;
            min-height: 100vh;
        }

        .hero {
            color: #fff700;
            text-shadow: 2px 2px 8px #000;
            padding: 100px 0;
            text-align: center;
            font-weight: bold;
            background: rgba(0, 0, 0, 0.5);
        }

        .feature-card {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
        }

        .image-section img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 24px;
        }

        footer {
            color: white;
            text-align: center;
            padding: 20px 0;
            background-color: rgba(0, 0, 0, 0.7);
            margin-top: 40px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">Inventory & Loss Mgmt</a>
        <div class="d-flex">
            <a href="login.php" class="btn btn-outline-success me-2">Login</a>
            <a href="register.php" class="btn btn-success">Register</a>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Efficient Inventory & Loss Reduction for Perishables</h1>
    </div>
</section>

<!-- Main Content -->
<div class="container mt-5 mb-5">
    <div class="text-center text-white">
        <h2 class="fw-bold">Welcome to Our System</h2>
        <p class="lead">Optimize inventory management and reduce post-harvest losses through real-time monitoring and intelligent reporting.</p>
    </div>

    <!-- Image Section -->
    <div class="row image-section mt-4">
        <div class="col-md-6 mb-4">
            <img src="https://via.placeholder.com/600x400?text=Inventory+Management" alt="Inventory" class="img-fluid shadow">
        </div>
        <div class="col-md-6 mb-4">
            <img src="https://via.placeholder.com/600x400?text=Post-Harvest+Handling" alt="Post Harvest" class="img-fluid shadow">
        </div>
    </div>

    <!-- Feature Cards -->
    <div class="row mt-5">
        <div class="col-md-4 mb-4">
            <div class="card feature-card p-4 shadow-sm h-100">
                <h5 class="card-title">📦 Real-Time Inventory Tracking</h5>
                <p class="card-text">Monitor stock levels and track perishables efficiently to prevent overstock or spoilage.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card feature-card p-4 shadow-sm h-100">
                <h5 class="card-title">⚠️ Automated Alerts & Reports</h5>
                <p class="card-text">Get notified about spoilage risks and generate insightful reports for better decisions.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card feature-card p-4 shadow-sm h-100">
                <h5 class="card-title">🚚 Supply Chain Optimization</h5>
                <p class="card-text">Enhance delivery and storage efficiency to minimize delays and product waste.</p>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    &copy; <?= date("Y") ?> Inventory & Post-Harvest Loss Management System. All Rights Reserved.
</footer>

</body>
</html>
