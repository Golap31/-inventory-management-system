<?php
    $servername="localhost";
    $username="root";
    $password="";
    $db_name="ims";

    $conn=new mysqli($servername, $username, $password, $db_name);
    
    if($conn->connect_error){
    	die("Connection Failed".$conn->connect_error);
    }
    else {
        echo "<script>console.log('Database Connected successfully');</script>";
    }

?>