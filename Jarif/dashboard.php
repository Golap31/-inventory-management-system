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



