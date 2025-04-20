<?php include('header.php'); ?>
<?php include('dbcon.php'); ?>
        <h2>ALL Products </h2>
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Product Type</th>
                <th>Product Quantity in Kilograms</th>
                <th>Storage Location</th>

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
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $row['storagelocation']; ?></td>
            <tr>
            
                
                    <?php
                }
            }
            ?>

                



        </tbody>
    </table>
<?php include ('footer.php'); ?>