<?php
include 'db/db_connect.php';
require_once('TCPDF-main/tcpdf.php');

$sql = "SELECT * FROM shipments";
$result = $conn->query($sql);

class PDF extends TCPDF {
    public function Header() {
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 10, 'Shipment Report', 0, 1, 'C');
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

if (isset($_POST['generate_pdf'])) {
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 10);

    $html = '<style>
                table { border-collapse: collapse; width: 100%; }
                th, td { border: 1px solid #000; padding: 5px; font-size: 10px; }
                th { background-color: #f2f2f2; }
            </style>';
    $html .= '<h3>Shipment Report</h3>';
    $html .= '<table>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Transport Mode</th>
                    <th>Departure Date</th>
                    <th>Arrival Date</th>
                    <th>Loading Loss</th>
                    <th>Unloading Loss</th>
                </tr>';

    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . htmlspecialchars($row['product_name']) . '</td>
                    <td>' . $row['quantity'] . '</td>
                    <td>' . htmlspecialchars($row['transport_mode']) . '</td>
                    <td>' . $row['departure_date'] . '</td>
                    <td>' . $row['arrival_date'] . '</td>
                    <td>' . $row['loading_loss'] . '</td>
                    <td>' . $row['unloading_loss'] . '</td>
                  </tr>';
    }

    $html .= '</table>';
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('shipment_report.pdf', 'I');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shipment Management</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        thead tr {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        button {
            margin: 10px 5px;
            padding: 10px 15px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        #addShipmentForm {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 999;
            overflow-y: auto;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        #addShipmentForm.show {
            display: block;
            opacity: 1;
        }

        #addShipmentForm input[type="text"],
        #addShipmentForm input[type="number"],
        #addShipmentForm input[type="date"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        #addShipmentForm button[type="submit"] {
            background-color: #4CAF50;
        }

        #addShipmentForm button[type="button"] {
            background-color: #f44336;
        }

        #addShipmentForm button[type="button"]:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <h2>Shipment Management</h2>
    <button onclick="openAddShipmentForm()">Add Shipment</button>

    <form method="POST" action="">
        <button type="submit" name="generate_pdf">Generate PDF</button>
    </form>

    <!-- Shipment Table -->
    <div id="shipmentTable">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Transport Mode</th>
                    <th>Departure Date</th>
                    <th>Arrival Date</th>
                    <th>Loading Loss</th>
                    <th>Unloading Loss</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $result->data_seek(0);
                    while ($row = $result->fetch_assoc()) {
                        $id = isset($row['id']) ? $row['id'] : '';
                        echo "<tr>
                            <td>{$id}</td>
                            <td>" . htmlspecialchars($row['product_name']) . "</td>
                            <td>" . htmlspecialchars($row['quantity']) . "</td>
                            <td>" . htmlspecialchars($row['transport_mode']) . "</td>
                            <td>" . htmlspecialchars($row['departure_date']) . "</td>
                            <td>" . htmlspecialchars($row['arrival_date']) . "</td>
                            <td>" . htmlspecialchars($row['loading_loss']) . "</td>
                            <td>" . htmlspecialchars($row['unloading_loss']) . "</td>
                            <td>
                                <a href='edit_shipment.php?id={$id}'>Edit</a> |
                                <a href='delete_shipment.php?id={$id}' onclick=\"return confirm('Are you sure?');\">Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No shipments found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add Shipment Form -->
    <div id="addShipmentForm">
        <h3>Add Shipment</h3>
        <form id="shipmentForm" method="POST">
            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" required>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required>

            <label for="transport_mode">Transport Mode:</label>
            <input type="text" name="transport_mode" required>

            <label for="departure_date">Departure Date:</label>
            <input type="date" name="departure_date" required>

            <label for="arrival_date">Arrival Date:</label>
            <input type="date" name="arrival_date" required>

            <label for="loading_loss">Loading Loss:</label>
            <input type="number" name="loading_loss" required>

            <label for="unloading_loss">Unloading Loss:</label>
            <input type="number" name="unloading_loss" required>

            <button type="submit">Save Shipment</button>
        </form>
        <button onclick="closeAddShipmentForm()">Cancel</button>
    </div>

    <script>
        function openAddShipmentForm() {
            document.getElementById("addShipmentForm").classList.add("show");
        }

        function closeAddShipmentForm() {
            document.getElementById("addShipmentForm").classList.remove("show");
        }

        document.getElementById("shipmentForm").addEventListener("submit", function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            fetch('add_shipment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                closeAddShipmentForm();
                location.reload(); // Reload to see the updated table
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
