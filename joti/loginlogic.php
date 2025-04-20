<?php
    include("db.php");

    // Check if form is submitted
    if (isset($_POST['submit'])) { 
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email= $_POST['email'];

        // SQL query to check if username and password match
        $sql = "SELECT * FROM login WHERE username = '$username' and password = '$password' and ";
        $result = mysqli_query($conn, $sql);

        // Fetch the row and count the results
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);

        if ($count == 1) {
            // Successful login, redirect to index.php
            header("Location: welcome.php");
            exit(); // It's good practice to call exit() after header redirect to ensure no further code is executed.
        } else {
            // If login fails, show alert and redirect to home.php
            echo "<script>
                alert('Login Failed! Invalid username or password');
                window.location.href = 'home.php';
            </script>";
        }
    }
?>
