<?php
include "db.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $P_ID = $_POST['P_ID'];
    $TotalAmount = $_POST['TotalAmount'];
    $PaidAmount = $_POST['PaidAmount'];
    $DueAmount = $_POST['DueAmount'];
    $ProductPurchased = $_POST['ProductPurchased'];

    $sql = "UPDATE PURCHASE SET 
                Parchase_ID = '$P_ID', 
                TotalAmount = '$TotalAmount', 
                PaidAmount = '$PaidAmount', 
                DueAmount = '$DueAmount', 
                ProductPurchased = '$ProductPurchased' 
            WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); // redirect to main page
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Get data to edit
$result = $conn->query("SELECT * FROM PURCHASE WHERE ID = $id");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Purchase</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Edit Purchase</h2>
        <form method="POST">
            <div class="form-group">
                <label>Parchase ID</label>
                <input type="text" class="form-control" name="P_ID" value="<?php echo $row['Parchase_ID']; ?>" required>
            </div>
            <div class="form-group">
                <label>Total Amount</label>
                <input type="text" class="form-control" name="TotalAmount" value="<?php echo $row['TotalAmount']; ?>" required>
            </div>
            <div class="form-group">
                <label>Paid Amount</label>
                <input type="text" class="form-control" name="PaidAmount" value="<?php echo $row['PaidAmount']; ?>" required>
            </div>
            <div class="form-group">
                <label>Due Amount</label>
                <input type="text" class="form-control" name="DueAmount" value="<?php echo $row['DueAmount']; ?>" required>
            </div>
            <div class="form-group">
                <label>Product Purchased</label>
                <input type="text" class="form-control" name="ProductPurchased" value="<?php echo $row['ProductPurchased']; ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a class="btn btn-default" href="index.php">Cancel</a>
        </form>
    </div>
</body>
</html>
