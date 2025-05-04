<?php
include('config.php');

// Check if the ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Basic input sanitization
    $id = mysqli_real_escape_string($connection, $id);

    // Delete query
    $query = "DELETE FROM harvestbatch WHERE HarvestBatchID = '$id'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        // Redirect back to main page with success message
        header("Location: harvestbatch.php?delete_msg=Harvest batch deleted successfully");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($connection);
    }
} else {
    echo "No harvest batch ID provided.";
}
?>
