


<?php
// Include the database connection file
require_once('db/loss_db.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loss Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Loss Dashboard</h1>

        <!-- Navigation Menu -->
        <nav>
            <ul>
                <li><a href="record_loss.php">Record Loss</a></li>
                <li><a href="loss_report.php">Check Loss Report</a></li>
                <li><a href="filter_loss.php">Filter Loss by Date</a></li>
            </ul>
        </nav>

        <div class="overview">
            <h2>Overview</h2>
            <p>Welcome to the Loss Dashboard. Here you can manage and track losses for your products.</p>
        </div>
    </div>
</body>
</html>
