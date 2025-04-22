<?php

include "db.php";

$sql = "SELECT ID, `first Name` as fname, `Last Name` as lastname, Area, City, `Postal Code` as pc,`Phone Number` as phone, Gender FROM farmers";

$result = $conn->query($sql);
// {   id:[1,2,3],
// name:["a","b","c"]
// .....
// }

?>

<!DOCTYPE html>

<html>

<head>

    <title>View Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

</head>

<body>

    <div class="container">

        <h2>Users</h2>

        <table class="table">

            <thead>

                <tr>
                    <th>ID</th>

                    <th>First Name</th>

                    <th>Last Name</th>

                    <th>Area</th>

                    <th>City</th>

                    <th>Postal Code</th>

                    <th>Gender</th>

                    <th>Phone Number</th>

                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

                <?php

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>

                        <tr>

                            <td><?php echo $row['ID']; ?></td>

                            <td><?php echo $row['fname']; ?></td>

                            <td><?php echo $row['lastname']; ?></td>

                            <td><?php echo $row['Area']; ?></td>

                            <td><?php echo $row['City']; ?></td>

                            <td><?php echo $row['pc']; ?></td>

                            <td><?php echo $row['Gender']; ?></td>

                            <td><?php echo $row['phone']; ?></td>

                            <td>
                                <a class="btn btn-info" href="update.php?id=<?php echo $row['ID']; ?>">Edit</a>&nbsp;
                                <a class="btn btn-danger" href="delete.php?id=<?php echo $row['ID']; ?>">Delete</a>
                            </td>

                        </tr>

                <?php   }
                }
                $conn->close();
                ?>

            </tbody>

        </table>
        <a style="color:black;" class="btn btn-warning" href="form.php"><b>Add Farmer</b></a>
    </div>

</body>

</html>