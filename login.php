<?php 
    session_start();
    require_once("database.php");
?>

<html>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <link href="style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    </head>
    <header>
        <table>
                <tr>
                    <td>
                        <a href = "home.php">Home</a>
                    </td>
                    <td>
                        <a href = "search.php">Find Books</a>
                    </td>
                    <td>
                    <?php
                        if ( isset($_SESSION["error"]) ) //if theres an error setting error
                        {
                            echo('<p style="color:red">Error:'.$_SESSION["error"]."</p>\n");
                            unset($_SESSION["error"]);
                        }
            
                        if ( isset($_SESSION["success"]) ) //if we successsfully logged in
                        {
                            echo("<a href = 'profile.php'>".$_SESSION["account"]."</a>\n");//allow user to access profile,php
                        }

                        else
                        {
                            echo("<a href = 'login.php'>Log in</a>");//else display login.php
                        }
                    ?>
                </td>

                </tr>
        </table>
    </header>
    
    <body>       

        <h1>Please Log In </h1>

        <form method="post"><!-- post the username and password -->
            <p>Username: <input type="text" name="account" value=""></p>
            <p>Password: <input type="text" name="pw" value=""></p>
            <p><input type="submit" value="Log In"></p>
        </form>

        <br>
        No account?
        <br>
        <a href = "register.php">register here</a>

    </body>
    
</html>

<?php
    if (isset($_POST["account"]) && isset($_POST["pw"]))
    { 

        $uname = ($_POST["account"]);
        $pword = ($_POST["pw"]);

        $sql = "SELECT username,password FROM users WHERE username = '$uname'";//check if the username is in the database

        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {

            while($row = $result->fetch_assoc())
            {

                if ($pword == htmlentities($row["password"]))
                {
                    $_SESSION["account"] = $_POST["account"];//this variable will be used when using username e.g reserve.php
                    $_SESSION["success"] = "Logged In"; //used to check that login was a success
                    echo("welcome". $_SESSION["account"]);  //displays the right username if working
                    return;
                } 
        
            }

        }

        else 
        {
            $_SESSION["error"] = "Incorrect password.";
            echo("error doesn't exist");
            return;
        } 
    
    } 
    
    else if (count($_POST) > 0)//if the user has only entered one value
    { 
        $_SESSION["error"] = "Missing Required Information";
        return;
    }

?>