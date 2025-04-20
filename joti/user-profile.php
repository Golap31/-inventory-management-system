<?php
    include("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .profile-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid #d32f2f;
            object-fit: cover;
        }

        .profile-name {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }

        .profile-info {
            font-size: 16px;
            color: #555;
            margin: 5px 0;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-edit {
            background: #2196F3;
            color: white;
        }

        .btn-logout {
            background: #F44336;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

    <div class="profile-container">
        <img src="https://www.w3schools.com/howto/img_avatar.png" alt="User Image" class="profile-img">
        <h2 class="profile-name">John Doe</h2>
        <p class="profile-info"><strong>Email:</strong> johndoe@example.com</p>
        <p class="profile-info"><strong>Phone:</strong> +123 456 7890</p>
        <p class="profile-info"><strong>Role:</strong> Admin</p>

        <a href="#" class="btn btn-edit">Edit Profile</a>
        <a href="#" class="btn btn-logout">Logout</a>
    </div>

</body>
</html>