<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");

    $account = new Account($con);

    if(isset($_POST["submitButton"])) {
        
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
<html>
    <head>
        <title> Welcome to AgriHigh: AN INVENTORY MANAGEMENT SYSTEM </title>
        <link rel= "stylesheet" type = "text/css" href = "assets/style/style.css" /> 
    </head>
    <body>
        <div class = "signInContainer">
            <div class = "column">
                <div class="header">
                    <img src ="https://img.icons8.com/?size=100&id=tkTUf04HuACx&format=png&color=000000" width="80" 
                    height="80" title="Logo" alt="Site logo"/>
                    <h3>Sign UP </h3>
                    <span> to continue to INVENTORY MANAGEMENT SYSTEM </span>


                <form method ="POST">

                    <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                    <input type = "text"  name = "firstName" placeholder = "First name" required>
                    <input type = "text"  name = "lastName" placeholder = "LastName" required>
                    <input type = "text"  name = "username" placeholder = "Username" required>
                    <input type = "email"  name = "email" placeholder = "Email" required>
                    <input type = "email"  name = "email2" placeholder = "Confirm Email" required>
                    <input type = "password"  name = "password" placeholder = "Password" required>
                    <input type = "password"  name = "password2" placeholder = "Confirm Password" required> 
                    <input type = "submit"  name = "submitButton" value= "SUBMIT" >
                </form>
                <a href="login.php" class= "signInMessage" >Already have an account? Sign in here!</a>
                    

            </div> 
        </div>


    </body>

</html>