<?php include('dbcon.php'); ?>

<?php
/** @var mysqli $connection */  // <-- This tells the linter what $connection is

if (isset($_POST['add_products'])) {
    $productname = $_POST['product_name'];
    $producttype = $_POST['product_type'];

    if (empty($productname)) {
        header('Location: products.php?message=You will need to fill in the product name');
        exit;
    } else {
        $query = "INSERT INTO `products` (`productname`, `type`) VALUES ('$productname', '$producttype')";
        $result = mysqli_query($connection, $query);

        if (!$result) {
            die("Query Failed: " . mysqli_error($connection));
        } else {
            header('Location: products.php?insert_msg=Your data has been added successfully');
        }
    }
}
?>


