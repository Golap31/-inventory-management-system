<?php
include('../db.php');

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle adding a warehouse
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $address = $_POST['address'];
    $capacity = $_POST['capacity'];

    $insert_query = "INSERT INTO warehouse (name, location, address, capacity, temperature, humidity, last_updated)
                     VALUES (?, ?, ?, ?, ROUND(RAND() * 10 + 20, 1), ROUND(RAND() * 20 + 50, 1), NOW())";

    if ($stmt = $conn->prepare($insert_query)) {
        $stmt->bind_param("sssi", $name, $location, $address, $capacity);

        if ($stmt->execute()) {
            $last_id = $stmt->insert_id;
            $sensor_id = 'SEN-' . str_pad($last_id, 3, '0', STR_PAD_LEFT);

            $update_sensor_query = "UPDATE warehouse SET sensor_id = ? WHERE id = ?";
            if ($update_stmt = $conn->prepare($update_sensor_query)) {
                $update_stmt->bind_param("si", $sensor_id, $last_id);
                $update_stmt->execute();
                $update_stmt->close();
            }
        }

        $stmt->close();
    }

    header("Location: warehouse.php");
    exit();
}

// Handle updating a warehouse
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $location = $_POST['location'];
    $address = $_POST['address'];
    $capacity = $_POST['capacity'];

    $update_query = "UPDATE warehouse SET name = ?, location = ?, address = ?, capacity = ? WHERE id = ?";

    if ($stmt = $conn->prepare($update_query)) {
        $stmt->bind_param("sssii", $name, $location, $address, $capacity, $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: warehouse.php");
    exit();
}

// Handle deleting a warehouse
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete_query = "DELETE FROM warehouse WHERE id = ?";
    if ($stmt = $conn->prepare($delete_query)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: warehouse.php");
    exit();
}

// Close DB connection
mysqli_close($conn);
?>
