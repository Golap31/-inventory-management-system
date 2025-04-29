<!-- <?php
    $servername="localhost";
    $username="root";
    $password="";
    $db_name="inventorymanagementsystem";

    $conn=new mysqli($servername, $username, $password, $db_name);
    
    if($conn->connect_error){
    	die("Connection Failed".$conn->connect_error);
    }
    else {
        echo "<script>console.log('Database Connected successfully');</script>";
    }

?> -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "inventorymanagementsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT product_name, batch_code, detected_issue, issue_description, expiry_date, alert_status 
        FROM LossAnalysis 
        ORDER BY expiry_date ASC";

$result = $conn->query($sql);
?>
