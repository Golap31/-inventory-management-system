<?php
// Include the database connection file
require_once('db/loss_db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loss Report</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Loss Report</h1>

        <!-- Navigation Menu -->
        <nav>
            <ul>
                <li><a href="record_loss.php">Record Loss</a></li>
                <li><a href="loss_report.php">Check Loss Report</a></li>
                <li><a href="filter_loss.php">Filter Loss by Date</a></li>
            </ul>
        </nav>

        <div class="overview">
            <h2>Loss Data</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Loss Type</th>
                        <th>Stage</th>
                        <th>Date</th>
                        <th>Lost Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch loss data from the database
                    $query = "SELECT * FROM loss";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['product_name'] . "</td>";
                        echo "<td>" . $row['loss_type'] . "</td>";
                        echo "<td>" . $row['stage'] . "</td>";
                        echo "<td>" . $row['loss_date'] . "</td>";
                        echo "<td>" . $row['lost_amount'] . " " . $row['unit'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Button to Download Loss PDF -->
        <div class="download-section" style="margin-top: 20px;">
            <a href="generate_pdf.php" class="btn btn-primary" target="_blank">Download Loss PDF</a>
        </div>
    </div>
</body>
</html>
