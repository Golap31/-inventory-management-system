<?php

$host = "localhost";
$username = "root"; 
$password = ""; 
$database = "inventorymanagementsystem"; 


$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';
$record = null;


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $batch_code = $_POST['batch_code'];
    $harvest_date = $_POST['harvest_date'];
    $storage_location = $_POST['storage_location'];
    $detected_issue = $_POST['detected_issue'];
    $issue_description = $_POST['issue_description'];
    $reported_by = $_POST['reported_by'];
    $detected_date = $_POST['detected_date'];
    $expiry_date = $_POST['expiry_date'];
    $alert_status = $_POST['alert_status'];
    
   
    $stmt = $conn->prepare("UPDATE lossanalysis SET 
                            product_name = ?, 
                            batch_code = ?, 
                            harvest_date = ?, 
                            storage_location = ?, 
                            detected_issue = ?, 
                            issue_description = ?, 
                            reported_by = ?, 
                            detected_date = ?, 
                            expiry_date = ?, 
                            alert_status = ? 
                            WHERE id = ?");
    
    $stmt->bind_param("ssssssssssi", 
                      $product_name, 
                      $batch_code, 
                      $harvest_date, 
                      $storage_location, 
                      $detected_issue, 
                      $issue_description, 
                      $reported_by, 
                      $detected_date, 
                      $expiry_date, 
                      $alert_status, 
                      $id);
    
    
    if ($stmt->execute()) {
        $message = "Record updated successfully";
    } else {
        $message = "Error updating record: " . $conn->error;
    }
    
    
    $stmt->close();
}


$id = 0;
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
} elseif (isset($_POST['selected']) && is_array($_POST['selected']) && count($_POST['selected']) > 0) {
    
    $id = intval($_POST['selected'][0]);
}


if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM lossanalysis WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $record = $result->fetch_assoc();
    } else {
        $message = "No record found with ID: " . $id;
    }
    
    $stmt->close();
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record - Loss Analysis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        h1 {
            color: #333;
        }
        form {
            max-width: 800px;
            margin: 20px 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], 
        input[type="date"], 
        select, 
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            height: 100px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
        }
        .btn-secondary {
            background-color: #6c757d;
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
    </style>
</head>
<body>
    <h1>Edit Loss Analysis Record</h1>
    
    <?php if (!empty($message)): ?>
    <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : 'success'; ?>">
        <?php echo $message; ?>
    </div>
    <?php endif; ?>
    
    <?php if ($record): ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
        
        <div class="form-group">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($record['product_name']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="batch_code">Batch Code:</label>
            <input type="text" id="batch_code" name="batch_code" value="<?php echo htmlspecialchars($record['batch_code']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="harvest_date">Harvest Date:</label>
            <input type="date" id="harvest_date" name="harvest_date" value="<?php echo htmlspecialchars($record['harvest_date']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="storage_location">Storage Location:</label>
            <input type="text" id="storage_location" name="storage_location" value="<?php echo htmlspecialchars($record['storage_location']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="detected_issue">Detected Issue:</label>
            <input type="text" id="detected_issue" name="detected_issue" value="<?php echo htmlspecialchars($record['detected_issue']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="issue_description">Issue Description:</label>
            <textarea id="issue_description" name="issue_description" required><?php echo htmlspecialchars($record['issue_description']); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="reported_by">Reported By:</label>
            <input type="text" id="reported_by" name="reported_by" value="<?php echo htmlspecialchars($record['reported_by']); ?>">
        </div>
        
        <div class="form-group">
            <label for="detected_date">Detected Date:</label>
            <input type="date" id="detected_date" name="detected_date" value="<?php echo htmlspecialchars($record['detected_date']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="expiry_date">Expiry Date:</label>
            <input type="date" id="expiry_date" name="expiry_date" value="<?php echo htmlspecialchars($record['expiry_date']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="alert_status">Alert Status:</label>
            <select id="alert_status" name="alert_status" required>
                <option value="Pending" <?php echo ($record['alert_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="Resolved" <?php echo ($record['alert_status'] == 'Resolved') ? 'selected' : ''; ?>>Resolved</option>
                <option value="Alert Sent" <?php echo ($record['alert_status'] == 'Alert Sent') ? 'selected' : ''; ?>>Alert Sent</option>
            </select>
        </div>
        
        <div class="form-group">
            <button type="submit" name="update" class="btn">Update Record</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
    <?php else: ?>
        <p>Record not found or no ID specified.</p>
        <a href="dashboard.php" class="btn">Back to Loss Analysis</a>
    <?php endif; ?>
    
</body>
</html>