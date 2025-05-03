<?php

$host = "localhost";
$username = "root"; 
$password = ""; 
$database = "inventorymanagementsystem"; 


$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && isset($_POST['selected'])) {
    $action = $_POST['action'];
    
    if ($action == 'delete' && !empty($_POST['selected'])) {
        
        echo "<script>window.location.href = 'delete.php?" . http_build_query($_POST) . "';</script>";
        exit;
    } else if ($action == 'edit' && !empty($_POST['selected'])) {
        
        echo "<script>window.location.href = 'edit.php?" . http_build_query($_POST) . "';</script>";
        exit;
    } else if ($action == 'copy' && !empty($_POST['selected'])) {
        
        echo "<script>window.location.href = 'copy.php?" . http_build_query($_POST) . "';</script>";
        exit;
    } else if ($action == 'export' && !empty($_POST['selected'])) {
       
        echo "<script>alert('Export functionality will be implemented soon.');</script>";
    }
}


$sql = "SELECT * FROM lossanalysis";
$result = $conn->query($sql);


$detectedIssues = [];
$alertStatus = [];
$storageLocations = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
       
        if (!isset($detectedIssues[$row['detected_issue']])) {
            $detectedIssues[$row['detected_issue']] = 1;
        } else {
            $detectedIssues[$row['detected_issue']]++;
        }
        
       
        if (!isset($alertStatus[$row['alert_status']])) {
            $alertStatus[$row['alert_status']] = 1;
        } else {
            $alertStatus[$row['alert_status']]++;
        }
        
       
        if (!isset($storageLocations[$row['storage_location']])) {
            $storageLocations[$row['storage_location']] = 1;
        } else {
            $storageLocations[$row['storage_location']]++;
        }
    }
    
    $result->data_seek(0);
}


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
    <h1></h1>

    
   

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
        
        document.addEventListener('DOMContentLoaded', function() {
           
            const issuesLabels = <?php echo $issuesJson; ?>;
            const issuesData = <?php echo $issuesCountJson; ?>;
            
            const statusLabels = <?php echo $statusJson; ?>;
            const statusData = <?php echo $statusCountJson; ?>;
            
            const locationsLabels = <?php echo $locationsJson; ?>;
            const locationsData = <?php echo $locationsCountJson; ?>;
            
            
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
        
      
        document.getElementById('check-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="selected[]"]');
            for (let checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });
        
        
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

$conn->close();
?>


<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "inventorymanagementsystem";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$message = "";
$messageType = "";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_record'])) {
    
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
    <h1>Analysis of Loss Causes</h1>
    
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