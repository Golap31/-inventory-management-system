<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loss Analysis Report</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f8fb; padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #1e4d91; color: white; }
        .alert { background: #ffecec; color: #d8000c; }
    </style>
</head>
<body>

<h2>Loss Analysis & Automated Alerts</h2>
<table>
    <tr>
        <th>Product</th>
        <th>Batch</th>
        <th>Issue</th>
        <th>Description</th>
        <th>Expiry Date</th>
        <th>Status</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $isExpiring = (strtotime($row["expiry_date"]) - time()) < (3 * 24 * 60 * 60); // 3 days warning
            echo "<tr" . ($isExpiring ? " class='alert'" : "") . ">";
            echo "<td>" . htmlspecialchars($row["product_name"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["batch_code"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["detected_issue"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["issue_description"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["expiry_date"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["alert_status"]) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No loss records found.</td></tr>";
    }
    $conn->close();
    ?>
</table>

</body>
</html>
