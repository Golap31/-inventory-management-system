<?php
// Database configuration
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form inputs
$product_name = $_POST['product'];
$quantity = (int)$_POST['quantity'];
$price_per_unit = (float)$_POST['price'];
$total_amount = $quantity * $price_per_unit;
$due_amount = $total_amount; // Currently due = total
$customer_name = $_POST['customer'];
$sale_date = $_POST['date'];

// Insert into sales table
$sql = "INSERT INTO sales (product_name, quantity, price_per_unit, total_amount, due_amount, customer_name, sale_date)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sidddss", $product_name, $quantity, $price_per_unit, $total_amount, $due_amount, $customer_name, $sale_date);

if ($stmt->execute()) {
    echo "Sale record inserted successfully!";
    // Optionally redirect back to input page
    header("Location: sales_input.html"); 
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
