<?php include('header.php'); ?>
<?php include('dbcon.php'); ?>
        <div class="header">
        <h2>ALL Products </h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">ADD PRODUCTS</button>
        </div>
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Product Type</th>
            </tr>
        </thead>
       <tbody>
        <?php
        $query = "select * FROM products";
        $result = mysqli_query($connection, $query);


        if(!$result){
            die("query Failed".mysqli_error());
            }
            else{
                while($row = mysqli_fetch_assoc($result)) {

                    ?>
            </tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['productname']; ?></td>
                <td><?php echo $row['type']; ?></td>
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

<form action="insert_data.php" method="post">
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
            <div class="form-group">
                <label for="f_name">Product Name</label>
                <input type="text" name="product_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="f_name">Product Type</label>
                <input type="text" name="product_type" class="form-control">
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