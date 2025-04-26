<?php

$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "inventorymanagementsystem"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$measure_name = $conn->real_escape_string($_POST['measure_name']);
$description = $conn->real_escape_string($_POST['description']);
$implementation_date = $_POST['implementation_date'];
$responsible_person = $conn->real_escape_string($_POST['responsible_person']);

$sql = "INSERT INTO preventive_measures (measure_name, description, implementation_date, responsible_person)
        VALUES ('$measure_name', '$description', '$implementation_date', '$responsible_person')";

if ($conn->query($sql) === TRUE) {
 
  header("Location: view_measures.php");
  exit();
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
