<?php include('config.php'); ?>

<?php
/** @var mysqli $connection */  // <-- This tells the linter what $connection is

if (isset($_POST['add_products'])) {
    $harvestbatchid = $_POST['harvest_batch_id'];
    $harvestdate = $_POST['harvest_date'];
    $harvestproduct = $_POST['harvest_product'];
    $quantity = $_POST['quantity'];
    $harvestloss = $_POST['harvest_loss'];
    


    if (empty($harvestdate)) {
        header('Location: harvestbatch.php?message=You will need to fill in the product name');
        exit;
    } else {
        $query = "INSERT INTO `harvestbatch` (`HarvestBatchID`, `HarvestDate`, `HarvestProduct`, `quantity`,`HarvestLoss`)  VALUES ('$harvestbatchid', '$harvestdate', '$harvestproduct', '$quantity', '$harvestloss' )";
        $result = mysqli_query($connection, $query);

        if (!$result) {
            die("Query Failed: " . mysqli_error($connection));
        } else {
            header('Location: harvestbatch.php?insert_msg=Your data has been added successfully');
        }
    }
}
?>
