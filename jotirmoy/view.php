<?php
include "db.php";

// Pagination and Search Setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $limit;

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_sql = $search ? "WHERE ProductPurchased LIKE '%$search%'" : "";

// Get total records
$count_result = $conn->query("SELECT COUNT(*) as total FROM PARCHASE $search_sql");
$total_records = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $limit);

// Get actual data
$sql = "SELECT ID, Parchase_ID as PID, TotalAmount as TAmount, PaidAmount as PAmount, DueAmount as DAmount, ProductPurchased as PPurchased
        FROM PARCHASE $search_sql
        ORDER BY ID DESC
        LIMIT $start_from, $limit";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Purchase Records</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Sales</h2>

        <!-- Search Form -->
        <form method="GET" class="form-inline" style="margin-bottom:15px;">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="Search Product" value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <!-- Purchase Table -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Parchase ID</th>
                    <th>Total Amount</th>
                    <th>Paid Amount</th>
                    <th>Due Amount</th>
                    <th>Product Purchased</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['PID']; ?></td>
                            <td><?php echo $row['TAmount']; ?></td>
                            <td><?php echo $row['PAmount']; ?></td>
                            <td><?php echo $row['DAmount']; ?></td>
                            <td><?php echo $row['PPurchased']; ?></td>
                            <td>
                                <a class="btn btn-info" href="update.php?id=<?php echo $row['ID']; ?>">Edit</a>
                                <a class="btn btn-danger" href="delete.php?id=<?php echo $row['ID']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination Links -->
        <nav>
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li><a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">« Prev</a></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="<?php echo $i == $page ? 'active' : ''; ?>">
                        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li><a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">Next »</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <!-- Add Purchase Button -->
        <a style="color:black;" class="btn btn-warning" href="form.php"><b>Add Parchase</b></a>
    </div>
</body>
</html>

<?php $conn->close(); ?>
