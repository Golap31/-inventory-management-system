<?php
include('dbcon.php');

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    $query = "DELETE FROM `products` WHERE `id` = $product_id";
    $result = mysqli_query($connection, $query);

    if ($result) {
        header('Location: products.php?delete_msg=Product deleted successfully');
        exit;
    } else {
        die("Delete failed: " . mysqli_error($connection));
    }
} else {
    die("Invalid request.");
}
?>
