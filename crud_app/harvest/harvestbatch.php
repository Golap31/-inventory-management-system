<?php include('header.php'); ?>
<?php include('config.php'); ?>
        <div class="header">
        <h2>ALL Harvest </h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">ADD PRODUCTS</button>
        </div>
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>HarvestBatchID</th>
                <th>HarvestDate</th>
                <th>HarvestProduct</th>
                <th>quantity </th>
                <th>HarvestLoss</th>

            </tr>
        </thead>
       <tbody>
        <?php
        $query = "select * FROM harvestbatch";
        $result = mysqli_query($connection, $query);


        if(!$result){
            die("query Failed".mysqli_error());
            }
            else{
                while($row = mysqli_fetch_assoc($result)) {

                    ?>
            </tr>
                <td><?php echo $row['HarvestBatchID']; ?></td>
                <td><?php echo $row['HarvestDate']; ?></td>
                <td><?php echo $row['HarvestProduct']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $row['HarvestLoss']; ?></td>
                <td>
                    <a href="update_page.php?id=<?php echo $row['HarvestBatchID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_page.php?id=<?php echo $row['HarvestBatchID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
        </td>

                </td>
            <tr>
            
                
                    <?php
                }
            }
            ?>

                



        </tbody>
    </table>


<?php

if (isset($_GET['message'])) {
    echo "<h6>" . $_GET['message'] . "</h6>";
}

?>
<?php
if (isset($_GET['update_msg'])) {
    echo "<p style='color: green;'>" . $_GET['update_msg'] . "</p>";
}
?>
<?php
if (isset($_GET['update_msg'])) {
    echo "<p style='color: green;'>" . $_GET['update_msg'] . "</p>";
}
?>
<?php if (isset($_GET['delete_msg'])): ?>
    <p style="color: green;"><?php echo htmlspecialchars($_GET['delete_msg']); ?></p>
<?php endif; ?>

<form action="insert_data.php" method="post">
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductModalLabel">Add New Harvest Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
            <div class="form-group">
                <label for="f_name">HarvestBatchID</label>
                <input type="text" name="harvest_batch_id" class="form-control">
            </div>
            <div class="form-group">
                <label for="f_name">HarvestDate</label>
                <input type="text" name="harvest_date" class="form-control">
            </div>
            <div class="form-group">
                <label for="f_name">HarvestProduct</label>
                <input type="text" name="harvest_product" class="form-control">
            </div>
            <div class="form-group">
                <label for="f_name">quantity</label>
                <input type="text" name="quantity" class="form-control">
            </div>
            <div class="form-group">
                <label for="f_name">HarvestLoss</label>
                <input type="text" name="harvest_loss" class="form-control">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-success" name = "add_products" value= "ADD"> 
      </div>
    </div>
  </div>
</div>
</form>


<?php include ('footer.php'); ?>