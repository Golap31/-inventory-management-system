<?php
// Database connection
$servername = "localhost";
$username = "root"; // your DB username
$password = "";     // your DB password
$dbname = "inventorymanagementsystem"; // your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Receive form data
$item = $_POST['item'];
$quantity = $_POST['quantity'];
$transportMode = $_POST['transportMode'];
$receiver = $_POST['receiver'];
$distributionDate = $_POST['distributionDate'];
$departureDate = $_POST['departureDate'];
$arrivalDate = $_POST['arrivalDate'];
$loadingLoss = $_POST['loadingLoss'];
$unloadingLoss = $_POST['unloadingLoss'];
$harvestLoss = $_POST['harvestLoss'];

// Auto-generate Shipment ID
$shipmentId = 'SHIP-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);

// Insert into database
$sql = "INSERT INTO distribution_records (shipment_id, item, quantity, transport_mode, receiver, distribution_date, departure_date, arrival_date, loading_loss, unloading_loss, harvest_loss)
VALUES ('$shipmentId', '$item', '$quantity', '$transportMode', '$receiver', '$distributionDate', '$departureDate', '$arrivalDate', '$loadingLoss', '$unloadingLoss', '$harvestLoss')";

if ($conn->query($sql) === TRUE) {
  echo "Record saved successfully! <br> <a href='index.html'>Go back</a>";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
