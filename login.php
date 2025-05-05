<?php
if (isset($_POST["submitPassword"])) {
    echo "Form was submitted";
    // TODO: Handle authentication here
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AgriHigh Login - Inventory Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url('https://t3.ftcdn.net/jpg/02/47/37/32/240_F_247373254_tI8NE7An2wy92KT4vovz37SCXnRQe7CO.jpg') no-repeat center center/cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 8px 20px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
        }

        .login-box .logo {
            width: 70px;
            height: 70px;
            margin-bottom: 10px;
        }

        .login-box h3 {
            margin-bottom: 10px;
            font-weight: bold;
        }

        .login-box .form-control {
            margin-bottom: 15px;
        }

        .login-box .btn {
            width: 100%;
        }

        .login-box .links {
            margin-top: 15px;
            text-align: center;
        }

        .login-box .links a {
            text-decoration: none;
            color: #198754;
        }
    </style>
</head>
<body>

    <div class="login-box text-center">
        <img src="https://img.icons8.com/?size=100&id=tkTUf04HuACx&format=png&color=000000" class="logo" alt="AgriHigh Logo">
        <h3>Sign In</h3>
        <p class="text-muted mb-4">to continue to <strong>AgriHigh</strong></p>

        <form method="POST">
            <input type="text" name="email" class="form-control" placeholder="Username" required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <input type="submit" name="submitPassword" class="btn btn-success" value="Login">
        </form>

        <div class="links">
            
            <p><a href="register.php">Need an account? Sign up here</a></p>
            <p><a href="dashboard.php">Go to Dashboard</a></p>
        </div>
    </div>

</body>
</html>
