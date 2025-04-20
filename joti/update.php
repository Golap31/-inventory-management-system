<?php

include "ims.php";

if (isset($_POST['update'])) {

    $firstname = $_POST['firstname'];

    $user_id = $_POST['user_id'];

    $lastname = $_POST['lastname'];

    $area = $_POST['area'];

    $city = $_POST['city'];

    $postal = $_POST['postal'];

    $gender = $_POST['gender'];

    $phone = $_POST['phone'];

    $sqlup = "UPDATE `farmers` SET `First Name`='$firstname',`Last Name`='$lastname',`Area`='$area',`City`='$city', `Postal Code`='$postal', `gender`='$gender', `Phone Number`='$phone' WHERE `id`='$user_id'";

    $result = $conn->query($sqlup);

    if ($result == TRUE) {

        echo '<div class="alert alert-success" role="alert">';
        echo 'Record updated successfully.';
        echo '</div>';
        echo "<script>console.log('Record updated successfully.');</script>";
        header("refresh:2; url=./view.php");
    } else {

        echo "Error:" . $sqlup . "<br>" . $conn->error;
    }
}

if (isset($_GET['id'])) {

    $user_id = $_GET['id'];

    $sql = "SELECT * FROM `farmers` WHERE `ID`='$user_id'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            $first_name = $row['First Name'];

            $lastname = $row['Last Name'];

            $area = $row['Area'];

            $city  = $row['City'];

            $postal  = $row['Postal Code'];

            $gender = $row['Gender'];

            $phone  = $row['Phone Number'];

            $id = $row['ID'];
        }

?>

        <html>

        <head>
            <title>User Update Form</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>

        <body>

            <div class="container">
                <h2>Farmer Update Form</h2>

                <form action="" method="post">

                    <fieldset>

                        <legend>Personal Information:</legend>

                        <div class="form-group">
                            <label for="firstname">First name:</label>
                            <input type="text" class="form-control" name="firstname" value="<?php echo $first_name; ?>">
                        </div>

                        <input type="hidden" name="user_id" value="<?php echo $id; ?>">

                        <div class="form-group">
                            <label for="lastname">Last name:</label>
                            <input type="text" class="form-control" name="lastname" value="<?php echo $lastname; ?>">
                        </div>

                        <div class="form-group">
                            <label for="lastname">Area:</label>
                            <input type="text" class="form-control" name="area" value="<?php echo $area; ?>">
                        </div>

                        <div class="form-group">
                            <label for="lastname">City:</label>
                            <input type="text" class="form-control" name="city" value="<?php echo $city; ?>">
                        </div>

                        <div class="form-group">
                            <label for="lastname">Postal Code:</label>
                            <input type="text" class="form-control" name="postal" value="<?php echo $postal; ?>">
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender:</label><br>
                            <input type="radio" name="gender" value="Male" <?php if ($gender == 'Male') {
                                                                                echo "checked";
                                                                            } ?>> Male
                            <input type="radio" name="gender" value="Female" <?php if ($gender == 'Female') {
                                                                                    echo "checked";
                                                                                } ?>> Female
                        </div>

                        <div class="form-group">
                            <label for="lastname">Phone Number:</label>
                            <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>">
                        </div>

                        <input type="submit" class="btn btn-primary" value="Update" name="update">

                    </fieldset>

                </form>
            </div>

        </body>

        </html>

<?php

    } else {

        header('Location: view.php');
    }
}

?>