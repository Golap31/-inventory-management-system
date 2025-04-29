<?php

if (isset($_POST['add_products'])) {
    $productname = $_POST['product_name'];
    $producttype = $_POST['product_type'];
    
    if (empty($productname)) {
        header('Location: products.php?message=You will need to fill in the product name');
        exit;
    }




}

?>
