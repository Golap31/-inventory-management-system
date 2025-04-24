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

