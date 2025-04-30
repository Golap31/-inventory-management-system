<?php
// Include database connection
require_once('db/loss_db.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $loss_type = $_POST['loss_type'];
    $stage = $_POST['stage'];
    $loss_date = $_POST['loss_date'];
    $lost_amount = $_POST['lost_amount'];
    $unit = $_POST['unit'];

    // Prepare SQL statement
    $sql = "INSERT INTO loss (product_name, loss_type, stage, loss_date, lost_amount, unit)
            VALUES ('$product_name', '$loss_type', '$stage', '$loss_date', '$lost_amount', '$unit')";

    if (mysqli_query($conn, $sql)) {
        echo "Record saved successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!-- HTML form for recording loss -->
<form action="" method="POST">
    <label for="product_name">Product Name:</label>
    <input type="text" name="product_name" required><br>

    <label for="loss_type">Loss Type:</label>
    <select name="loss_type" required>
        <option value="spoilage">Spoilage</option>
        <option value="expired">Expired</option>
        <option value="weight">Weight</option>
        <option value="other">Other</option>
    </select><br>

    <label for="stage">Stage:</label>
    <select name="stage" required>
        <option value="shipment">Shipment</option>
        <option value="warehouse">Warehouse</option>
    </select><br>

    <label for="loss_date">Loss Date:</label>
    <input type="date" name="loss_date" required><br>

    <label for="lost_amount">Lost Amount:</label>
    <input type="number" name="lost_amount" step="any" required><br>

    <label for="unit">Unit:</label>
    <select name="unit" required>
        <option value="kg">kg</option>
        <option value="liter">liter</option>
        <option value="pieces">pieces</option>
        <option value="cease">cease</option>
        <option value="other">other</option>
    </select><br>

    <input type="submit" value="Record Loss">
</form>
