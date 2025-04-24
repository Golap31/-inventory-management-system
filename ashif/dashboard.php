<?php
// Database connection settings
$host = "localhost";
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$database = "inventorymanagementsystem"; // Change this to your database name

// Create database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process bulk actions
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && isset($_POST['selected'])) {
    $action = $_POST['action'];
    
    if ($action == 'delete' && !empty($_POST['selected'])) {
        // Redirect to delete.php with selected IDs
        echo "<script>window.location.href = 'delete.php?" . http_build_query($_POST) . "';</script>";
        exit;
    } else if ($action == 'edit' && !empty($_POST['selected'])) {
        // Redirect to edit.php with first selected ID
        echo "<script>window.location.href = 'edit.php?" . http_build_query($_POST) . "';</script>";
        exit;
    } else if ($action == 'copy' && !empty($_POST['selected'])) {
        // Redirect to copy.php with selected IDs
        echo "<script>window.location.href = 'copy.php?" . http_build_query($_POST) . "';</script>";
        exit;
    } else if ($action == 'export' && !empty($_POST['selected'])) {
        // Handle export action (to be implemented)
        // For now, just show an alert
        echo "<script>alert('Export functionality will be implemented soon.');</script>";
    }
}

// Query to fetch data from lossanalysis table
$sql = "SELECT * FROM lossanalysis";
$result = $conn->query($sql);

// Prepare data for charts
$detectedIssues = [];
$alertStatus = [];
$storageLocations = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Count detected issues
        if (!isset($detectedIssues[$row['detected_issue']])) {
            $detectedIssues[$row['detected_issue']] = 1;
        } else {
            $detectedIssues[$row['detected_issue']]++;
        }
        
        // Count alert statuses
        if (!isset($alertStatus[$row['alert_status']])) {
            $alertStatus[$row['alert_status']] = 1;
        } else {
            $alertStatus[$row['alert_status']]++;
        }
        
        // Count storage locations
        if (!isset($storageLocations[$row['storage_location']])) {
            $storageLocations[$row['storage_location']] = 1;
        } else {
            $storageLocations[$row['storage_location']]++;
        }
    }
    // Reset result pointer for table display
    $result->data_seek(0);
}

// Convert data to JSON for JavaScript
$issuesJson = json_encode(array_keys($detectedIssues));
$issuesCountJson = json_encode(array_values($detectedIssues));

$statusJson = json_encode(array_keys($alertStatus));
$statusCountJson = json_encode(array_values($alertStatus));

$locationsJson = json_encode(array_keys($storageLocations));
$locationsCountJson = json_encode(array_values($storageLocations));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loss Analysis</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1, h2 {
            color: #333;
        }
        .chart-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin: 20px 0;
        }
        .chart-box {
            width: 30%;
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .actions {
            white-space: nowrap;
        }
        .pending {
            color: orange;
            font-weight: bold;
        }
        .resolved {
            color: green;
            font-weight: bold;
        }
        .alert-sent {
            color: red;
            font-weight: bold;
        }
        .edit-btn, .copy-btn, .delete-btn {
            padding: 2px 5px;
            margin-right: 5px;
            text-decoration: none;
            border-radius: 3px;
            font-size: 12px;
            display: inline-block;
        }
        .edit-btn {
            color: #fff;
            background-color: #4CAF50;
        }
        .copy-btn {
            color: #fff;
            background-color: #2196F3;
        }
        .delete-btn {
            color: #fff;
            background-color: #f44336;
        }
        .actions-row {
            margin-top: 10px;
            padding: 10px 0;
            border-top: 1px solid #ddd;
        }
        .check-all {
            margin-right: 10px;
        }
        .confirmation-dialog {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 999;
        }
        .dialog-content {
            background-color: white;
            width: 300px;
            padding: 20px;
            border-radius: 5px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
        .dialog-buttons {
            margin-top: 20px;
        }
        .dialog-btn {
            padding: 8px 16px;
            margin: 0 5px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .confirm-btn {
            background-color: #f44336;
            color: white;
        }
        .cancel-btn {
            background-color: #ccc;
        }
    </style>
</head>
<body>
    <h1>Loss Analysis Report</h1>

    <!-- Charts Section -->
   

    <form method="post" id="recordsForm">
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" id="check-all"></th>
                    <th>Actions</th>
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
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Set status class
                        $statusClass = '';
                        if ($row['alert_status'] == 'Pending') {
                            $statusClass = 'pending';
                        } else if ($row['alert_status'] == 'Resolved') {
                            $statusClass = 'resolved';
                        } else if ($row['alert_status'] == 'Alert Sent') {
                            $statusClass = 'alert-sent';
                        }
                        
                        echo "<tr>";
                        echo "<td><input type='checkbox' name='selected[]' value='" . $row['id'] . "'></td>";
                        echo "<td class='actions'>
                                <a href='edit.php?id=" . $row['id'] . "' class='edit-btn'>Edit</a>
                                <a href='copy.php?id=" . $row['id'] . "' class='copy-btn'>Copy</a>
                                <a href='javascript:void(0);' onclick='confirmDelete(" . $row['id'] . ")' class='delete-btn'>Delete</a>
                              </td>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['product_name'] . "</td>";
                        echo "<td>" . $row['batch_code'] . "</td>";
                        echo "<td>" . $row['harvest_date'] . "</td>";
                        echo "<td>" . $row['storage_location'] . "</td>";
                        echo "<td>" . $row['detected_issue'] . "</td>";
                        echo "<td>" . $row['issue_description'] . "</td>";
                        echo "<td>" . ($row['reported_by'] == 'NULL' ? '' : $row['reported_by']) . "</td>";
                        echo "<td>" . $row['detected_date'] . "</td>";
                        echo "<td>" . $row['expiry_date'] . "</td>";
                        echo "<td class='" . $statusClass . "'>" . $row['alert_status'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='13' style='text-align:center;'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        
        <div class="actions-row">
            <select name="action" id="bulk-action">
                <option value="">-- Select Action --</option>
                <option value="edit">Edit Selected</option>
                <option value="copy">Copy Selected</option>
                <option value="delete">Delete Selected</option>
                <option value="export">Export Selected</option>
            </select>
            <button type="button" onclick="applyBulkAction()">Apply</button>
            <a href="add.php" style="float:right;padding:5px 10px;background-color:#4CAF50;color:white;text-decoration:none;border-radius:3px;">Add New Record</a>
        </div>
    </form>

    <div class="chart-container">
        <div class="chart-box">
            <h2>Detected Issues</h2>
            <canvas id="issuesChart"></canvas>
        </div>
        <div class="chart-box">
            <h2>Alert Status</h2>
            <canvas id="statusChart"></canvas>
        </div>
        <div class="chart-box">
            <h2>Storage Locations</h2>
            <canvas id="locationsChart"></canvas>
        </div>
    </div>

    <!-- Confirmation Dialog -->
    <div id="confirmation-dialog" class="confirmation-dialog">
        <div class="dialog-content">
            <p>Are you sure you want to delete this record?</p>
            <div class="dialog-buttons">
                <button class="dialog-btn confirm-btn" onclick="deleteRecord()">Delete</button>
                <button class="dialog-btn cancel-btn" onclick="hideConfirmDialog()">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        // Chart.js configurations
        document.addEventListener('DOMContentLoaded', function() {
            // Extract data from PHP variables
            const issuesLabels = <?php echo $issuesJson; ?>;
            const issuesData = <?php echo $issuesCountJson; ?>;
            
            const statusLabels = <?php echo $statusJson; ?>;
            const statusData = <?php echo $statusCountJson; ?>;
            
            const locationsLabels = <?php echo $locationsJson; ?>;
            const locationsData = <?php echo $locationsCountJson; ?>;
            
            // Chart colors
            const backgroundColors = [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ];
            
            const borderColors = [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ];
            
            // Create Issues Chart
            const issuesCtx = document.getElementById('issuesChart').getContext('2d');
            const issuesChart = new Chart(issuesCtx, {
                type: 'bar',
                data: {
                    labels: issuesLabels,
                    datasets: [{
                        label: 'Number of Issues',
                        data: issuesData,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
            
            // Create Status Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            const statusChart = new Chart(statusCtx, {
                type: 'pie',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        label: 'Alert Status',
                        data: statusData,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });
            
            // Create Locations Chart
            const locationsCtx = document.getElementById('locationsChart').getContext('2d');
            const locationsChart = new Chart(locationsCtx, {
                type: 'doughnut',
                data: {
                    labels: locationsLabels,
                    datasets: [{
                        label: 'Storage Locations',
                        data: locationsData,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });
        });
        
        // Check/Uncheck all checkbox functionality
        document.getElementById('check-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="selected[]"]');
            for (let checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });
        
        // Bulk action functionality
        function applyBulkAction() {
            const action = document.getElementById('bulk-action').value;
            if (action === '') {
                alert('Please select an action');
                return;
            }
            
            const checkboxes = document.querySelectorAll('input[name="selected[]"]:checked');
            if (checkboxes.length === 0) {
                alert('Please select at least one record');
                return;
            }
            
            if (action === 'delete') {
                if (confirm('Are you sure you want to delete the selected records?')) {
                    document.getElementById('recordsForm').submit();
                }
            } else {
                document.getElementById('recordsForm').submit();
            }
        }
        
        // Delete confirmation dialog
        let recordToDelete = null;
        
        function confirmDelete(id) {
            recordToDelete = id;
            document.getElementById('confirmation-dialog').style.display = 'block';
        }
        
        function hideConfirmDialog() {
            document.getElementById('confirmation-dialog').style.display = 'none';
        }
        
        function deleteRecord() {
            if (recordToDelete) {
                window.location.href = 'delete.php?id=' + recordToDelete;
            }
            hideConfirmDialog();
        }
    </script>
</body>
</html>
<?php
// Close the database connection
$conn->close();
?>

<?php
// dashboard.php - Loss Analysis Dashboard
// Database connection
$servername = "localhost";
$username = "root"; // Change if different
$password = ""; // Change if different
$dbname = "ins";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission for new record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_record'])) {
    // Get form data
    $product_name = $_POST['product_name'];
    $batch_code = $_POST['batch_code'];
    $harvest_date = $_POST['harvest_date'];
    $storage_location = $_POST['storage_location'];
    $detected_issue = $_POST['detected_issue'];
    $issue_description = $_POST['issue_description'];
    $reported_by = $_POST['reported_by'] ?? '';
    $detected_date = $_POST['detected_date'];
    $expiry_date = $_POST['expiry_date'];
    $alert_status = $_POST['alert_status'];
    
    // Prepare SQL query
    $sql = "INSERT INTO lossanalysis (product_name, batch_code, harvest_date, storage_location, 
            detected_issue, issue_description, reported_by, detected_date, expiry_date, alert_status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
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
    
    // Execute the statement
    if ($stmt->execute()) {
        $success_message = "Record added successfully!";
    } else {
        $error_message = "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

// Get existing records
$sql = "SELECT * FROM lossanalysis ORDER BY id DESC";
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
            background-color: #f8f9fa;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
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
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
            margin-bottom: 30px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .actions {
            display: flex;
            gap: 5px;
        }
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }
        .btn-edit {
            background-color: #4CAF50;
            color: white;
        }
        .btn-copy {
            background-color: #2196F3;
            color: white;
        }
        .btn-delete {
            background-color: #f44336;
            color: white;
        }
        .btn-add {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .status-pending {
            color: #ff9800;
            font-weight: bold;
        }
        .status-sent {
            color: #f44336;
            font-weight: bold;
        }
        .status-resolved {
            color: #4CAF50;
            font-weight: bold;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
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
            max-width: 800px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: black;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="date"], select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 0;
        }
        .form-row .form-group {
            flex: 1;
        }
        
        /* Charts section */
        .charts {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
        }
        .chart {
            flex: 1;
            min-width: 300px;
            background-color: white;
            padding: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
            border-radius: 5px;
        }
        .chart h2 {
            margin-top: 0;
            color: #333;
            font-size: 18px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Loss Analysis Report</h1>
        
        <?php if (isset($success_message)): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <button class="btn btn-add" onclick="openModal()">Add New Record</button>
        
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>Actions</th>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Batch Code</th>
                    <th>Harvest Date</th>
                    <th>Storage Location</th>
                    <th>Detected Issue</th>
                    <th>Issue Description</th>
                    <th>Detected Date</th>
                    <th>Expiry Date</th>
                    <th>Alert Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><input type="checkbox" class="record-checkbox"></td>
                            <td class="actions">
                                <button class="btn btn-edit">Edit</button>
                                <button class="btn btn-copy">Copy</button>
                                <button class="btn btn-delete">Delete</button>
                            </td>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['batch_code']); ?></td>
                            <td><?php echo htmlspecialchars($row['harvest_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['storage_location']); ?></td>
                            <td><?php echo htmlspecialchars($row['detected_issue']); ?></td>
                            <td><?php echo htmlspecialchars($row['issue_description']); ?></td>
                            <td><?php echo htmlspecialchars($row['detected_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['expiry_date']); ?></td>
                            <td class="<?php 
                                if ($row['alert_status'] == 'Pending') echo 'status-pending';
                                else if ($row['alert_status'] == 'Alert Sent') echo 'status-sent';
                                else if ($row['alert_status'] == 'Resolved') echo 'status-resolved';
                                ?>">
                                <?php echo htmlspecialchars($row['alert_status']); ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12" style="text-align:center;">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <div class="actions-footer">
            <select id="bulkAction">
                <option value="">-- Select Action --</option>
                <option value="delete">Delete Selected</option>
                <option value="mark_pending">Mark as Pending</option>
                <option value="mark_sent">Mark as Alert Sent</option>
                <option value="mark_resolved">Mark as Resolved</option>
            </select>
            <button class="btn" onclick="applyBulkAction()">Apply</button>
        </div>
        
        <!-- Add charts section similar to your screenshot -->
        <div class="charts">
            <div class="chart">
                <h2>Detected Issues</h2>
                <div id="issues-chart">
                    <!-- Chart would be rendered here by JS -->
                    <p>Spoilage: 3, Physical Damage: 2</p>
                </div>
            </div>
            
            <div class="chart">
                <h2>Alert Status</h2>
                <div id="status-chart">
                    <!-- Chart would be rendered here by JS -->
                    <p>Pending: 3, Alert Sent: 1, Resolved: 1</p>
                </div>
            </div>
            
            <div class="chart">
                <h2>Storage Locations</h2>
                <div id="location-chart">
                    <!-- Chart would be rendered here by JS -->
                    <p>Cold Storage A: 2, Warehouse B: 1, Refrigerator Unit 3: 1, Warehouse C: 1</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add New Record Modal -->
    <div id="addRecordModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Add New Loss Analysis Record</h2>
            <form method="POST" action="">
                <div class="form-row">
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" id="product_name" name="product_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="batch_code">Batch Code</label>
                        <input type="text" id="batch_code" name="batch_code" required>
                    </div>
                </div>
                
                <div class="form-row">
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
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="detected_issue">Detected Issue</label>
                        <select id="detected_issue" name="detected_issue" required>
                            <option value="">Select Issue</option>
                            <option value="Spoilage">Spoilage</option>
                            <option value="Physical Damage">Physical Damage</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="reported_by">Reported By</label>
                        <input type="text" id="reported_by" name="reported_by">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="issue_description">Issue Description</label>
                    <textarea id="issue_description" name="issue_description" rows="3" required></textarea>
                </div>
                
                <div class="form-row">
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
                </div>
                
                <div class="form-group" style="text-align: right; margin-top: 20px;">
                    <button type="button" class="btn" onclick="closeModal()">Cancel</button>
                    <button type="submit" name="add_record" class="btn btn-add">Save Record</button>
                </div>
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
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
        
        // Select all checkboxes
        document.getElementById("selectAll").addEventListener("change", function() {
            const checkboxes = document.querySelectorAll(".record-checkbox");
            for (let checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });
        
        // Bulk action functionality
        function applyBulkAction() {
            const action = document.getElementById("bulkAction").value;
            if (!action) {
                alert("Please select an action");
                return;
            }
            
            const selectedBoxes = document.querySelectorAll(".record-checkbox:checked");
            if (selectedBoxes.length === 0) {
                alert("Please select at least one record");
                return;
            }
            
            // Here you would normally send a request to the server to process the selected items
            // For now, just show a confirmation
            alert(`Action "${action}" would be applied to ${selectedBoxes.length} record(s)`);
        }
    </script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>


<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Change to your MySQL username
$password = ""; // Change to your MySQL password
$dbname = "inventory"; // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from lossanalysis table
$sql = "SELECT id, loss_id, notification_type, status, message, sent_at FROM lossanalysis ORDER BY sent_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Logs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            position: sticky;
            top: 0;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .sent {
            color: green;
        }
        .failed {
            color: red;
        }
        .actions {
            white-space: nowrap;
        }
        .actions a {
            margin-right: 5px;
            text-decoration: none;
        }
        .edit {
            color: #0066cc;
        }
        .delete {
            color: #cc0000;
        }
        .header-row {
            background-color: #e9e9e9;
        }
        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }
        .status-sent {
            background-color: green;
        }
        .status-failed {
            background-color: red;
        }
        .notification-email {
            background-color: #e8f4f8;
        }
        .notification-sms {
            background-color: #f8f4e8;
        }
        .notification-push {
            background-color: #f0e8f8;
        }
        .notification-banner {
            background-color: #e8f8ea;
        }
    </style>
</head>
<body>
    <h1>Notification Logs</h1>
    
    <table>
        <thead>
            <tr class="header-row">
                <th><input type="checkbox" id="selectAll"></th>
                <th>ID</th>
                <th>Loss ID</th>
                <th>Type</th>
                <th>Status</th>
                <th>Message</th>
                <th>Sent At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $notificationType = strtolower($row['notification_type']);
                    $rowClass = "notification-" . $notificationType;
                    $statusClass = strtolower($row['status']) == 'sent' ? 'sent' : 'failed';
                    $statusIndicatorClass = strtolower($row['status']) == 'sent' ? 'status-sent' : 'status-failed';
                    
                    echo "<tr class='" . $rowClass . "'>";
                    echo "<td><input type='checkbox' name='selected[]' value='" . $row['id'] . "'></td>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['loss_id'] . "</td>";
                    echo "<td>" . $row['notification_type'] . "</td>";
                    echo "<td><span class='status-indicator " . $statusIndicatorClass . "'></span><span class='" . $statusClass . "'>" . $row['status'] . "</span></td>";
                    echo "<td>" . $row['message'] . "</td>";
                    echo "<td>" . $row['sent_at'] . "</td>";
                    echo "<td class='actions'>
                            <a href='edit.php?id=" . $row['id'] . "' class='edit'>Edit</a>
                            <a href='delete.php?id=" . $row['id'] . "' class='delete' onclick='return confirm(\"Are you sure you want to delete this notification?\")'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No notification logs found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
    <script>
        // Select all checkboxes functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            var checkboxes = document.getElementsByName('selected[]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = this.checked;
            }
        });
    </script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>

<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Change to your MySQL username
$password = ""; // Change to your MySQL password
$dbname = "inventory"; // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from lossanalysis table
$sql = "SELECT id, loss_id, notification_type, status, message, sent_at FROM lossanalysis ORDER BY sent_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Logs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            position: sticky;
            top: 0;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .sent {
            color: green;
        }
        .failed {
            color: red;
        }
        .actions {
            white-space: nowrap;
        }
        .actions a {
            margin-right: 5px;
            text-decoration: none;
        }
        .edit {
            color: #0066cc;
        }
        .delete {
            color: #cc0000;
        }
        .header-row {
            background-color: #e9e9e9;
        }
        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }
        .status-sent {
            background-color: green;
        }
        .status-failed {
            background-color: red;
        }
        .notification-email {
            background-color: #e8f4f8;
        }
        .notification-sms {
            background-color: #f8f4e8;
        }
        .notification-push {
            background-color: #f0e8f8;
        }
        .notification-banner {
            background-color: #e8f8ea;
        }
    </style>
</head>
<body>
    <h1>Notification Logs</h1>
    
    <table>
        <thead>
            <tr class="header-row">
                <th><input type="checkbox" id="selectAll"></th>
                <th>ID</th>
                <th>Loss ID</th>
                <th>Type</th>
                <th>Status</th>
                <th>Message</th>
                <th>Sent At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $notificationType = strtolower($row['notification_type']);
                    $rowClass = "notification-" . $notificationType;
                    $statusClass = strtolower($row['status']) == 'sent' ? 'sent' : 'failed';
                    $statusIndicatorClass = strtolower($row['status']) == 'sent' ? 'status-sent' : 'status-failed';
                    
                    echo "<tr class='" . $rowClass . "'>";
                    echo "<td><input type='checkbox' name='selected[]' value='" . $row['id'] . "'></td>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['loss_id'] . "</td>";
                    echo "<td>" . $row['notification_type'] . "</td>";
                    echo "<td><span class='status-indicator " . $statusIndicatorClass . "'></span><span class='" . $statusClass . "'>" . $row['status'] . "</span></td>";
                    echo "<td>" . $row['message'] . "</td>";
                    echo "<td>" . $row['sent_at'] . "</td>";
                    echo "<td class='actions'>
                            <a href='edit.php?id=" . $row['id'] . "' class='edit'>Edit</a>
                            <a href='delete.php?id=" . $row['id'] . "' class='delete' onclick='return confirm(\"Are you sure you want to delete this notification?\")'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No notification logs found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
    <script>
        // Select all checkboxes functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            var checkboxes = document.getElementsByName('selected[]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = this.checked;
            }
        });
    </script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
