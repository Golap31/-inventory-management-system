<?php

include "ims.php";

if (isset($_GET['id'])) {

    $user_id = $_GET['id'];

    $sql = "DELETE FROM `farmers` WHERE `ID`='$user_id'";

    $result = $conn->query($sql);

    if ($result == TRUE) {

        echo '<div class="alert alert-success" role="alert">Record successfully deleted!</div>';
        header("refresh:2; url=./view.php");
    } else {

        echo "Error:" . $sql . "<br>" . $conn->error;
    }
}
?>