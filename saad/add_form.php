<?php include('../db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Warehouse</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #f4f4f4;
        }
        h2 {
            text-align: center;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #5bc0de;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #31b0d5;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #0275d8;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }
        .message.success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .message.error {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>

<h2>Add New Warehouse</h2>

<?php
// Display status message (success/error) if available
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    echo '<div class="message ' . ($status == 'success' ? 'success' : 'error') . '">';
    echo $status == 'success' ? 'Warehouse added successfully!' : 'There was an error adding the warehouse.';
    echo '</div>';
}
?>

<form method="POST" action="crud_warehouse.php">
    <label for="name">Warehouse Name:</label><br>
    <input type="text" name="name" required><br>

    <label for="location">Location:</label><br>
    <input type="text" name="location" required><br>

    <label for="address">Address:</label><br>
    <input type="text" name="address" required><br>

    <label for="capacity">Capacity:</label><br>
    <input type="number" name="capacity" required><br><br>

    <button type="submit" name="add">Add Warehouse</button>
</form>

<a href="warehouse.php">Back to Dashboard</a>

</body>
</html>
