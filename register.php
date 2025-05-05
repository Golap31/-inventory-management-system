<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");

$account = new Account($con);

if (isset($_POST["submitButton"])) {
    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
    $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
    $email2 = FormSanitizer::sanitizeFormEmail($_POST["email2"]);
    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
    $password2 = FormSanitizer::sanitizeFormPassword($_POST["password2"]);

    $account->validateFirstName($firstName);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - AgriHigh IMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
                        url('https://t3.ftcdn.net/jpg/02/47/37/32/240_F_247373254_tI8NE7An2wy92KT4vovz37SCXnRQe7CO.jpg') no-repeat center center/cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .register-box {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
        }

        .register-box h3 {
            font-weight: 600;
            color: #333;
        }

        .register-box input[type="text"],
        .register-box input[type="email"],
        .register-box input[type="password"] {
            margin-bottom: 15px;
        }

        .logo {
            width: 70px;
            margin-bottom: 15px;
        }

        .signInMessage {
            display: block;
            margin-top: 15px;
            text-align: center;
            font-size: 14px;
            color: #007bff;
        }

        .signInMessage:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <div class="text-center">
            <img src="https://img.icons8.com/?size=100&id=tkTUf04HuACx&format=png&color=000000" class="logo" alt="Logo">
            <h3>Sign Up</h3>
            <p class="text-muted">to continue to AgriHigh Inventory System</p>
        </div>

        <form method="POST">
            <?php echo $account->getError(Constants::$firstNameCharacters); ?>
            <input type="text" name="firstName" class="form-control" placeholder="First Name" required>
            <input type="text" name="lastName" class="form-control" placeholder="Last Name" required>
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <input type="email" name="email" class="form-control" placeholder="Email" required>
            <input type="email" name="email2" class="form-control" placeholder="Confirm Email" required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <input type="password" name="password2" class="form-control" placeholder="Confirm Password" required>

            <input type="submit" name="submitButton" value="SUBMIT" class="btn btn-success w-100 mt-2">
        </form>

        <a href="login.php" class="signInMessage">Already have an account? Sign in here!</a>
    </div>
</body>
</html>
