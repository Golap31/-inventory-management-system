<!-- index.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sales and Distribution</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Sales and Distribution Records</h1>
  <form action="add_record.php" method="POST">
    <label for="product_id">Product ID:</label>
    <input type="text" id="product_id" name="product_id" required><br>

    <label for="quantity_sold">Quantity Sold:</label>
    <input type="number" id="quantity_sold" name="quantity_sold" required><br>

    <label for="distribution_point">Distribution Point:</label>
    <input type="text" id="distribution_point" name="distribution_point" required><br>

    <label for="sale_date">Sale Date:</label>
    <input type="date" id="sale_date" name="sale_date" required><br>

    <input type="submit" value="Add Record">
  </form>

  <h2>Existing Records</h2>
  <div id="records">
    <?php include 'view_records.php'; ?>
  </div>
</body>
</html>

<?php
// add_record.php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $quantity_sold = $_POST['quantity_sold'];
    $distribution_point = $_POST['distribution_point'];
    $sale_date = $_POST['sale_date'];

    $sql = "INSERT INTO sales_records (product_id, quantity_sold, distribution_point, sale_date)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $product_id, $quantity_sold, $distribution_point, $sale_date);

    if ($stmt->execute()) {
        echo "Record added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: index.html");
    exit();
}
?>

<?php
// view_records.php
include 'db_connection.php';

$sql = "SELECT * FROM sales_records ORDER BY sale_date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Product ID</th><th>Quantity Sold</th><th>Distribution Point</th><th>Sale Date</th><th>Actions</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['product_id']}</td>
                <td>{$row['quantity_sold']}</td>
                <td>{$row['distribution_point']}</td>
                <td>{$row['sale_date']}</td>
                <td>
                    <a href='edit_record.php?id={$row['id']}'>Edit</a> |
                    <a href='delete_record.php?id={$row['id']}' onclick=\"return confirm('Are you sure?');\">Delete</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}
$conn->close();
?>

<?php
// db_connection.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventorymanagement";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
// delete_record.php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM sales_records WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("Location: index.html");
    exit();
}
?>

<?php
// edit_record.php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $product_id = $_POST['product_id'];
    $quantity_sold = $_POST['quantity_sold'];
    $distribution_point = $_POST['distribution_point'];
    $sale_date = $_POST['sale_date'];

    $sql = "UPDATE sales_records SET product_id=?, quantity_sold=?, distribution_point=?, sale_date=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissi", $product_id, $quantity_sold, $distribution_point, $sale_date, $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("Location: index.html");
    exit();
} else if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM sales_records WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $record = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Record</title>
</head>
<body>
    <h1>Edit Sales Record</h1>
    <form method="POST" action="edit_record.php">
        <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
        <label>Product ID:</label><input type="text" name="product_id" value="<?php echo $record['product_id']; ?>" required><br>
        <label>Quantity Sold:</label><input type="number" name="quantity_sold" value="<?php echo $record['quantity_sold']; ?>" required><br>
        <label>Distribution Point:</label><input type="text" name="distribution_point" value="<?php echo $record['distribution_point']; ?>" required><br>
        <label>Sale Date:</label><input type="date" name="sale_date" value="<?php echo $record['sale_date']; ?>" required><br>
        <input type="submit" value="Update Record">
    </form>
</body>
</html>
<?php } ?>
