<?php
include('config.php');

// Get the HarvestBatchID from the URL
if (isset($_GET['id'])) {
    $harvestBatchID = $_GET['id'];

    // Fetch current data
    $query = "SELECT * FROM harvestbatch WHERE HarvestBatchID = '$harvestBatchID'";
    $result = mysqli_query($connection, $query);

    if (!$result || mysqli_num_rows($result) == 0) {
        die("Record not found.");
    }

    $row = mysqli_fetch_assoc($result);
} else {
    die("No ID specified.");
}

// Handle the update form submission
if (isset($_POST['update_batch'])) {
    $harvestDate = mysqli_real_escape_string($connection, $_POST['harvest_date']);
    $harvestProduct = mysqli_real_escape_string($connection, $_POST['harvest_product']);
    $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
    $harvestLoss = mysqli_real_escape_string($connection, $_POST['harvest_loss']);

    $updateQuery = "
        UPDATE harvestbatch 
        SET HarvestDate = '$harvestDate', 
            HarvestProduct = '$harvestProduct', 
            quantity = '$quantity', 
            HarvestLoss = '$harvestLoss'
        WHERE HarvestBatchID = '$harvestBatchID'
    ";

    $updateResult = mysqli_query($connection, $updateQuery);

    if ($updateResult) {
        header("Location: harvestbatch.php?update_msg=Record updated successfully");
        exit;
    } else {
        echo "<p style='color: red;'>Error updating record: " . mysqli_error($connection) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Harvest Batch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Update Harvest Batch</h2>
    <form method="POST">
        <div class="mb-3">
            <label>HarvestBatchID</label>
            <input type="text" class="form-control" name="harvest_batch_id" value="<?php echo htmlspecialchars($row['HarvestBatchID']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label>HarvestDate</label>
            <input type="text" class="form-control" name="harvest_date" value="<?php echo htmlspecialchars($row['HarvestDate']); ?>" required>
        </div>
        <div class="mb-3">
            <label>HarvestProduct</label>
            <input type="text" class="form-control" name="harvest_product" value="<?php echo htmlspecialchars($row['HarvestProduct']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Quantity</label>
            <input type="text" class="form-control" name="quantity" value="<?php echo htmlspecialchars($row['quantity']); ?>" required>
        </div>
        <div class="mb-3">
            <label>HarvestLoss</label>
            <input type="text" class="form-control" name="harvest_loss" value="<?php echo htmlspecialchars($row['HarvestLoss']); ?>" required>
        </div>
        <button type="submit" name="update_batch" class="btn btn-success">Update</button>
        <a href="harvestbatch.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
