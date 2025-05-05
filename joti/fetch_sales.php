<?php
header('Content-Type: application/json');

$servername="localhost";
    $username="root";
    $password="";
    $db_name="inventorymanagementsystem";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  echo json_encode([]);
  exit;
}

$sql = "SELECT * FROM sales ORDER BY id DESC";
$result = $conn->query($sql);

$sales = [];
while($row = $result->fetch_assoc()) {
  $sales[] = $row;
}

echo json_encode($sales);

$conn->close();
?>
