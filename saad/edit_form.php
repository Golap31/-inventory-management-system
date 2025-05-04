<?php
include('../db.php');

// Ensure the ID exists in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Use a prepared statement to avoid SQL injection
    $query = "SELECT * FROM warehouse WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id); // 'i' for integer type
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if the warehouse exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Warehouse not found.";
        exit;
    }
} else {
    echo "Invalid or missing warehouse ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Warehouse</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 30px;
            display: flex;
            justify-content: center;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-size: 16px;
            color: #555;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #007BFF;
            outline: none;
        }

        button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .back-link a {
            color: #007BFF;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Warehouse</h2>
    <form method="POST" action="crud_warehouse.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">

        <label for="name">Warehouse Name:</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required><br>

        <label for="location">Location:</label><br>
        <input type="text" name="location" value="<?php echo htmlspecialchars($row['location']); ?>" required><br>

        <label for="address">Address:</label><br>
        <input type="text" name="address" value="<?php echo htmlspecialchars($row['address']); ?>" required><br>

        <label for="capacity">Capacity:</label><br>
        <input type="number" name="capacity" value="<?php echo htmlspecialchars($row['capacity']); ?>" required><br><br>

        <button type="submit" name="update">Update Warehouse</button>
    </form>
    <br>
    <div class="back-link">
        <a href="warehouse.php">Back to Dashboard</a>
    </div>
</div>

<?php
// Close the database connection
$stmt->close();
$conn->close();
?>

</body>
</html>
