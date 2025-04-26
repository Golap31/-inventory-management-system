<?php
// Include the database connection file
require_once('db/loss_db.php');

// Fetch loss data based on the selected date range
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get start and end date from the form
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Get losses from the database within the date range
    $result = getLossesByDate($start_date, $end_date);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Losses</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Filter Losses by Date</h1>

        <!-- Filter Form -->
        <form method="POST" action="filter_loss.php">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>

            <button type="submit">Filter</button>
        </form>

        <hr>

        <!-- Display Filtered Loss Data -->
        <?php if (isset($result) && mysqli_num_rows($result) > 0): ?>
            <h2>Filtered Loss Data</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Loss Type</th>
                        <th>Stage</th>
                        <th>Date</th>
                        <th>Lost Amount</th>
                        <th>Unit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo $row['loss_type']; ?></td>
                            <td><?php echo $row['stage']; ?></td>
                            <td><?php echo $row['loss_date']; ?></td>
                            <td><?php echo $row['lost_amount']; ?></td>
                            <td><?php echo $row['unit']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <br>
            <!-- Button to Generate PDF with selected dates -->
            <a href="generate_pdf.php?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" class="btn">Generate PDF</a>

        <?php else: ?>
            <p>No loss data found for the selected date range.</p>
        <?php endif; ?>
    </div>
</body>
</html>
