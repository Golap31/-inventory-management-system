<?php
    if(isset($_POST["submitButton"]))  {
        echo "Form was submitted";

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
                    <h3>Sign In </h3>
                    <span> to continue to INVENTORY MANAGEMENT SYSTEM </span>


                <form method ="POST">
                    <input type = "text"  name = "email" placeholder = "Username" required>
                    <input type = "password"  name = "password" placeholder = "Password" required> 
                    <input type = "submit"  name = "submitPassword" value= "SUBMIT" >
                </form>
                <a href="register.php" class= "signInMessage" >Need an account? Sign up here</a>
                <a href="Dashboard.html" class= "Login" >Go to Dashboard page</a>
                    

            </div> 
        </div>


    </body>

</html>