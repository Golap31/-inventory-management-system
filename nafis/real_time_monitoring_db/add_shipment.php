<?php
include 'db/db_connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form values
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $transport_mode = $_POST['transport_mode'];
    $departure_date = $_POST['departure_date'];
    $arrival_date = $_POST['arrival_date'];
    $loading_loss = $_POST['loading_loss'];
    $unloading_loss = $_POST['unloading_loss'];

    // Prepare the SQL query to insert data into the database
    $sql = "INSERT INTO shipments (product_name, quantity, transport_mode, departure_date, arrival_date, loading_loss, unloading_loss)
            VALUES ('$product_name', '$quantity', '$transport_mode', '$departure_date', '$arrival_date', '$loading_loss', '$unloading_loss')";

    // Execute the query and check if the insertion was successful
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the shipment page after successful insertion
        header("Location: shipment.php");
        exit();
    } else {
        // If insertion fails, show an error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
