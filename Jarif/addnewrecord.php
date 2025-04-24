<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change if different
$password = ""; // Change if different
$dbname = "inventorymanagementsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$message = "";
$messageType = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_record'])) {
    // Get form data
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
    
    // Prepare and execute SQL query
    $sql = "INSERT INTO lossanalysis (product_name, batch_code, harvest_date, storage_location, 
            detected_issue, issue_description, reported_by, detected_date, expiry_date, alert_status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ssssssssss", 
            $product_name, 
            $batch_code, 
            $harvest_date, 
            $storage_location, 
            $detected_issue, 
            $issue_description, 
            $reported_by, 
            $detected_date, 
            $expiry_date, 
            $alert_status
        );
        
        if ($stmt->execute()) {
            $message = "Record added successfully!";
            $messageType = "success";
        } else {
            $message = "Error: " . $stmt->error;
            $messageType = "error";
        }
        
        $stmt->close();
    } else {
        $message = "Error: " . $conn->error;
        $messageType = "error";
    }
}

// Get existing records for display
$sql = "SELECT * FROM lossanalysis";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loss Analysis Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .add-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 700px;
            border-radius: 5px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="date"], select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .actions-btn {
            padding: 5px 10px;
            margin: 2px;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
        }
        .edit-btn {
            background-color: #4CAF50;
        }
        .copy-btn {
            background-color: #2196F3;
        }
        .delete-btn {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <h1>Loss Analysis Report</h1>
    
    <?php if (!empty($message)): ?>
        <div class="message <?php echo $messageType; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <button class="add-btn" onclick="openModal()">Add New Record</button>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Batch Code</th>
                <th>Harvest Date</th>
                <th>Storage Location</th>
                <th>Detected Issue</th>
                <th>Issue Description</th>
                <th>Reported By</th>
                <th>Detected Date</th>
                <th>Expiry Date</th>
                <th>Alert Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['batch_code']; ?></td>
                        <td><?php echo $row['harvest_date']; ?></td>
                        <td><?php echo $row['storage_location']; ?></td>
                        <td><?php echo $row['detected_issue']; ?></td>
                        <td><?php echo $row['issue_description']; ?></td>
                        <td><?php echo $row['reported_by']; ?></td>
                        <td><?php echo $row['detected_date']; ?></td>
                        <td><?php echo $row['expiry_date']; ?></td>
                        <td><?php echo $row['alert_status']; ?></td>
                        <td>
                            <button class="actions-btn edit-btn">Edit</button>
                            <button class="actions-btn copy-btn">Copy</button>
                            <button class="actions-btn delete-btn">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12">No records found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <!-- Add New Record Modal -->
    <div id="addRecordModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Add New Record</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" id="product_name" name="product_name" required>
                </div>
                
                <div class="form-group">
                    <label for="batch_code">Batch Code</label>
                    <input type="text" id="batch_code" name="batch_code" required>
                </div>
                
                <div class="form-group">
                    <label for="harvest_date">Harvest Date</label>
                    <input type="date" id="harvest_date" name="harvest_date" required>
                </div>
                
                <div class="form-group">
                    <label for="storage_location">Storage Location</label>
                    <select id="storage_location" name="storage_location" required>
                        <option value="">Select Location</option>
                        <option value="Cold Storage A">Cold Storage A</option>
                        <option value="Warehouse B">Warehouse B</option>
                        <option value="Refrigerator Unit 3">Refrigerator Unit 3</option>
                        <option value="Warehouse C">Warehouse C</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="detected_issue">Detected Issue</label>
                    <select id="detected_issue" name="detected_issue" required>
                        <option value="">Select Issue</option>
                        <option value="Spoilage">Spoilage</option>
                        <option value="Physical Damage">Physical Damage</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="issue_description">Issue Description</label>
                    <input type="text" id="issue_description" name="issue_description" required>
                </div>
                
                <div class="form-group">
                    <label for="reported_by">Reported By</label>
                    <input type="text" id="reported_by" name="reported_by" required>
                </div>
                
                <div class="form-group">
                    <label for="detected_date">Detected Date</label>
                    <input type="date" id="detected_date" name="detected_date" required>
                </div>
                
                <div class="form-group">
                    <label for="expiry_date">Expiry Date</label>
                    <input type="date" id="expiry_date" name="expiry_date" required>
                </div>
                
                <div class="form-group">
                    <label for="alert_status">Alert Status</label>
                    <select id="alert_status" name="alert_status" required>
                        <option value="">Select Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Alert Sent">Alert Sent</option>
                        <option value="Resolved">Resolved</option>
                    </select>
                </div>
                
                <input type="submit" name="add_record" value="Save Record" class="submit-btn">
            </form>
        </div>
    </div>
    
    <script>
        // Modal functionality
        const modal = document.getElementById("addRecordModal");
        
        function openModal() {
            modal.style.display = "block";
        }
        
        function closeModal() {
            modal.style.display = "none";
        }
        
        // Close modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>