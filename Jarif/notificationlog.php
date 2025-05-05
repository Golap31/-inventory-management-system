<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "inventorymanagementsystem"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, notification_type, status, message, sent_at FROM notificationlog ORDER BY id";
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
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
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
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .action-icons a {
            text-decoration: none;
            padding: 8px 15px;
            color: #fff;
            font-weight: bold;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .action-icons a.edit-btn {
            background-color: #4CAF50;
        }

        .action-icons a.edit-btn:hover {
            background-color: #45a049;
        }

        .action-icons a.copy-btn {
            background-color: #2196F3;
        }

        .action-icons a.copy-btn:hover {
            background-color: #1976d2;
        }

        .action-icons a.delete-btn {
            background-color: #f44336;
        }

        .action-icons a.delete-btn:hover {
            background-color: #e53935;
        }

        .failed {
            color: red;
            font-weight: bold;
        }

        .sent {
            color: green;
            font-weight: bold;
        }

        .checkbox-col {
            width: 30px;
            text-align: center;
        }

        .checkbox-col input {
            margin: 0;
            padding: 0;
        }

        #select-all {
            cursor: pointer;
        }

        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            table {
                font-size: 14px;
            }

            th, td {
                padding: 10px;
            }

            .action-icons {
                display: block;
                text-align: center;
            }

            .action-icons a {
                margin: 5px 0;
                font-size: 12px;
            }

            .checkbox-col {
                width: 20px;
            }
        }
    </style>
</head>
<body>
    <h2>Loss Analysis Notifications</h2>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th class="checkbox-col"><input type="checkbox" id="select-all"></th>
                    <th>Actions</th>
                    <th>id</th>
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
                                <a href='edit.php?id=" . $row["id"] . "' title='Edit' class='edit-btn'>Edit</a>
                                <a href='copy.php?id=" . $row["id"] . "' title='Copy' class='copy-btn'>Copy</a>
                                <a href='delete.php?id=" . $row["id"] . "' title='Delete' class='delete-btn'>Delete</a>
                              </td>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["notification_type"] . "</td>";
                        echo "<td class='" . $statusClass . "'>" . $row["status"] . "</td>";
                        echo "<td>" . $row["message"] . "</td>";
                        echo "<td>" . $row["sent_at"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No notifications found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

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
