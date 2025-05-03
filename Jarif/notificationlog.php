<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "inventorymanagementsystem"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

able
$sql = "SELECT id, loss_id, notification_type, status, message, sent_at FROM lossanalysis ORDER BY id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loss Analysis Notifications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            position: sticky;
            top: 0;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .action-icons {
            white-space: nowrap;
        }
        .action-icons a {
            margin-right: 5px;
            text-decoration: none;
        }
        .failed {
            color: red;
        }
        .sent {
            color: green;
        }
        .checkbox-col {
            width: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Loss Analysis Notifications</h2>
    
    <table>
        <thead>
            <tr>
                <th class="checkbox-col"><input type="checkbox" id="select-all"></th>
                <th>Actions</th>
                <th>id</th>
                <th>loss_id</th>
                <th>notification_type</th>
                <th>status</th>
                <th>message</th>
                <th>sent_at</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $statusClass = strtolower($row["status"]) == "failed" ? "failed" : "sent";
                    echo "<tr>";
                    echo "<td class='checkbox-col'><input type='checkbox' class='row-checkbox'></td>";
                    echo "<td class='action-icons'>
                            <a href='edit.php?id=" . $row["id"] . "' title='Edit'><img src='edit-icon.png' alt='Edit' width='16'>Edit</a>
                            <a href='copy.php?id=" . $row["id"] . "' title='Copy'><img src='copy-icon.png' alt='Copy' width='16'>Copy</a>
                            <a href='delete.php?id=" . $row["id"] . "' title='Delete'><img src='delete-icon.png' alt='Delete' width='16'>Delete</a>
                          </td>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["loss_id"] . "</td>";
                    echo "<td>" . $row["notification_type"] . "</td>";
                    echo "<td class='" . $statusClass . "'>" . $row["status"] . "</td>";
                    echo "<td>" . $row["message"] . "</td>";
                    echo "<td>" . $row["sent_at"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No notifications found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        
        document.getElementById('select-all').addEventListener('change', function() {
            document.querySelectorAll('.row-checkbox').forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>

</body>
</html>

<?php

$conn->close();
?>