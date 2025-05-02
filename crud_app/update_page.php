<?php
include('dbcon.php'); // Ensure this file defines $connection

// Handle update form submission
if (isset($_POST['update_product'])) {
    $product_id = intval($_POST['product_id']);
    $productname = mysqli_real_escape_string($connection, $_POST['product_name']);
    $producttype = mysqli_real_escape_string($connection, $_POST['product_type']);

    if (empty($productname)) {
        header('Location: products.php?message=Product name cannot be empty');
        exit;
    }

    $query = "UPDATE `products` SET `productname` = '$productname', `type` = '$producttype' WHERE `id` = $product_id";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Update Failed: " . mysqli_error($connection));
    } else {
        header('Location: products.php?update_msg=Product updated successfully');
        exit;
    }
}

// Fetch product data for editing
$product = null;
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $query = "SELECT * FROM `products` WHERE `id` = $product_id";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Query Failed: " . mysqli_error($connection));
    }

    $product = mysqli_fetch_assoc($result);
    if (!$product) {
        die("Product not found.");
    }
} else {
    die("No product ID specified.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Product</title>
</head>
<body>

<h2>Update Product</h2>
<form action="update_page.php" method="POST">
    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

    <label for="product_name">Product Name:</label>
    <input type="text" name="product_name" value="<?php echo htmlspecialchars($product['productname']); ?>" required><br><br>

    <label for="product_type">Product Type:</label>
    <input type="text" name="product_type" value="<?php echo htmlspecialchars($product['type']); ?>" required><br><br>

    <input type="submit" name="update_product" value="Update Product">
</form>

</body>
</html>
