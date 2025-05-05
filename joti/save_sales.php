<?php
// --- Database configuration ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventorymanagementsystem";

// --- Create connection ---
$conn = new mysqli($servername, $username, $password, $dbname);

// --- Check connection ---
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// --- Sanitize and validate input ---
$product_name   = $_POST['product'] ?? '';
$quantity       = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
$price_per_unit = isset($_POST['price']) ? (float)$_POST['price'] : 0.0;
$customer_name  = $_POST['customer'] ?? '';
$sale_date      = $_POST['date'] ?? '';

if (!$product_name || !$quantity || !$price_per_unit || !$customer_name || !$sale_date) {
    echo "All fields are required.";
    exit;
}

$total_amount = $quantity * $price_per_unit;
$due_amount = $total_amount;

// --- Insert into database using prepared statements ---
$sql = "INSERT INTO sales (product_name, quantity, price_per_unit, total_amount, due_amount, customer_name, sale_date)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo "Prepare failed: " . $conn->error;
    exit;
}

$stmt->bind_param("sidddss", $product_name, $quantity, $price_per_unit, $total_amount, $due_amount, $customer_name, $sale_date);

if ($stmt->execute()) {
    echo "Sale record inserted successfully!";
} else {
    echo "Database error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
