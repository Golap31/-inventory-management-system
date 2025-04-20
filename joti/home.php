<?php
    include("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory & Post-Harvest Loss Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('https://t3.ftcdn.net/jpg/02/47/37/32/240_F_247373254_tI8NE7An2wy92KT4vovz37SCXnRQe7CO.jpg') no-repeat center center/cover;
        }
        .navbar {
            background-color: #e0dede;
            padding: 10px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: rgb(78, 76, 76);
            text-decoration: none;
            font-size: 20px;
            font-weight: bold;
        }
        .navbar .buttons {
            display: flex;
            gap: 10px;
        }
        .btn {
            background-color: rgb(153, 238, 153);
            color: #000000;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .hero {
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: rgb(243, 240, 18);
            font-size: 40px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(229, 228, 228, 0.7);
        }
        .container {
            padding: 20px;
            text-align: center;
            color: rgb(239, 244, 239)
        }
        .feature {
            margin-top: 20px;
            padding: 15px;
            background: rgba(45, 45, 43, 0.9);
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .image-section {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .image-section img {
            width: 200px;
            height: auto;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="#">Inventory & Loss Management</a>
        <div class="buttons">
            <button class="btn">Login</button>
            <button class="btn">Register</button>
        </div>
    </div>
    <div class="hero">
        Efficient Inventory and Loss Reduction for Perishable Goods
    </div>
    <div class="container">
        <h2>Welcome to Our System</h2>
        <p>Optimize inventory management and reduce post-harvest losses with our efficient tracking and monitoring system.</p>
        
        <div class="image-section">
            <img src="/Users/joti/Downloads/-inventory-management-system/content/turnkey3-hero-768.jpg" alt="Inventory Management image-section">
            <img src="/Users/joti/Downloads/-inventory-management-system/Egypt_1.jpg" alt="Post-Harvest Management image-section">
        </div>

        <div class="feature">
            <h3>Real-Time Inventory Tracking</h3>
            <p>Monitor stock levels and track perishables efficiently.</p>
        </div>
        <div class="feature">
            <h3>Automated Alerts & Reports</h3>
            <p>Receive notifications on spoilage risks and manage waste effectively.</p>
        </div>
        <div class="feature">
            <h3>Supply Chain Optimization</h3>
            <p>Enhance distribution efficiency and minimize losses.</p>
        </div>
    </div>
</body>
</html>