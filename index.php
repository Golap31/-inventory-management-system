<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Management Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url('https://t3.ftcdn.net/jpg/02/47/37/32/240_F_247373254_tI8NE7An2wy92KT4vovz37SCXnRQe7CO.jpg') no-repeat center center/cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border-radius: 12px;
            background-color: rgba(255, 255, 255, 0.95);
            width: 100%;
            max-width: 650px;
        }

        .list-group-item {
            font-size: 1.1rem;
            transition: all 0.2s ease-in-out;
        }

        .list-group-item:hover {
            background-color: #e9ecef;
            font-weight: 500;
        }

        .header-title {
            font-weight: 600;
            color: #212529;
        }

        .container {
            padding-top: 20px;
            padding-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h2 class="mb-4 header-title text-white">AgriHigh Inventory Dashboard</h2>

        <div class="card shadow p-4 mx-auto">
            <h5 class="mb-3">Quick Navigation</h5>
            <div class="list-group">
                <a href="purchase_view.php" class="list-group-item list-group-item-action">📦 Purchase Records</a>
                <a href="saad/warehouse.php" class="list-group-item list-group-item-action">🏢 Warehouse Management</a>
                <a href="Preventive_Measures.php" class="list-group-item list-group-item-action">🛡️ Preventive Measures</a>
                <a href="nafis/inventorymanagementsystem/shipment.php" class="list-group-item list-group-item-action">🚚 Shipment Tracking</a>
                <a href="Jarif/dashboard.php" class="list-group-item list-group-item-action">📊 Jarif's Dashboard</a>
                <a href="ashif/addnewrecord.php" class="list-group-item list-group-item-action">➕ Add New Record</a>
                <a href="logout.php" class="list-group-item list-group-item-action text-danger">🔓 Log Out</a>
            </div>
        </div>
    </div>
</body>
</html>
