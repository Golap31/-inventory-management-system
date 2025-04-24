<?php
// Database connection settings
$host = "localhost";
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$database = "ims"; // Change this to your database name

// Create database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM lossanalysis WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Success message
        $message = "Record deleted successfully";
    } else {
        // Error message
        $message = "Error deleting record: " . $conn->error;
    }
    
    // Close statement
    $stmt->close();
} elseif (isset($_POST['selected']) && is_array($_POST['selected']) && count($_POST['selected']) > 0) {
    // Handle bulk delete from form submission
    $ids = array_map('intval', $_POST['selected']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    
    // Prepare statement
    $stmt = $conn->prepare("DELETE FROM lossanalysis WHERE id IN ($placeholders)");
    
    // Bind parameters dynamically
    $types = str_repeat('i', count($ids));
    $stmt->bind_param($types, ...$ids);
    
    // Execute the statement
    if ($stmt->execute()) {
        $message = count($ids) . " record(s) deleted successfully";
    } else {
        $message = "Error deleting records: " . $conn->error;
    }
    
    // Close statement
    $stmt->close();
} else {
    $message = "No record specified for deletion";
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Record - Loss Analysis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .message {
            padding: 10px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Delete Record</h1>
    
    <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : 'success'; ?>">
        <?php echo $message; ?>
    </div>
    
    <a href="index.php" class="btn">Back to Loss Analysis</a>
    
    <script>
        // Auto redirect after 3 seconds
        setTimeout(function() {
            window.location.href = "index.php";
        }, 3000);
    </script>
</body>
</html>