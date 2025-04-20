<?php
include "ims.php";

if (isset($_POST['submit'])) {

  $firstname = $_POST['firstname'];

  $lastname = $_POST['lastname'];

  $area = $_POST['area'];

  $city = $_POST['city'];

  $postal = $_POST['postal'];

  $gender = $_POST['gender'];

  $phone = $_POST['phone'];

  $sql = "INSERT INTO `farmers`(`First Name`, `Last Name`, `Area`, `City`, `Postal Code`, `gender`, `Phone Number`) VALUES ('$firstname','$lastname','$area','$city','$postal','$gender','$phone')";

  $result = $conn->query($sql);

  if ($result == TRUE) {

    echo '<div class="alert alert-success" role="alert">New record created successfully!</div>';
    echo "<script>console.log('New record created successfully!');</script>";
    header("refresh:2; url=./view.php");
  } else {

    echo "Error:" . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>

<!DOCTYPE html>

<html>

<head>
  <title>Signup Form</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

  <div class="container">
    <h2>Signup Form</h2>

    <form action="" method="POST">

      <fieldset>

        <legend>Personal information:</legend>

        <div class="form-group">
          <label for="firstname">First name:</label>
          <input type="text" class="form-control" name="firstname" id="firstname">
        </div>

        <div class="form-group">
          <label for="lastname">Last name:</label>
          <input type="text" class="form-control" name="lastname" id="lastname">
        </div>

        <div class="form-group">
          <label for="lastname">Area:</label>
          <input type="text" class="form-control" name="area" id="area">
        </div>

        <div class="form-group">
          <label for="lastname">City:</label>
          <input type="text" class="form-control" name="city" id="area">
        </div>

        <div class="form-group">
          <label for="lastname">Postal Code:</label>
          <input type="text" class="form-control" name="postal" id="postal">
        </div>

        <div class="form-group">
          <label for="lastname">Phone Number:</label>
          <input type="text" class="form-control" name="phone" id="phone">
        </div>


        <div class="form-group">
          <label for="gender">Gender:</label><br>
          <input type="radio" name="gender" value="Male">Male
          <input type="radio" name="gender" value="Female">Female
        </div>

        <input type="submit" name="submit" value="Submit" class="btn btn-primary">

      </fieldset>

    </form>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>