<?php 
    session_start();
    
    //unset the sessions so the user cant still access their info even if they logged in once and then logged out
    unset($_SESSION["account"]);   
    unset($_SESSION["success"]);


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
                        if ( isset($_SESSION["error"]) ) 
                        {
                            echo('<p style="color:red">Error:'.$_SESSION["error"]."</p>\n");
                            unset($_SESSION["error"]);
                        }
            
                        if ( isset($_SESSION["success"]) )  //check if user is logged in to restrict access to profile.php
                        {
                            echo("<a href = 'profile.php'>".$_SESSION["account"]."</a>\n");
                        }

                        else
                        {
                            echo("<a href = 'login.php'>Log in</a>");
                        }
                    ?>
                </td>

            </tr>
        </table>
    </header>
    
    <body>       

        <h1>Thank you for coming! </h1>

        <?php
            if ( isset($_SESSION["error"]) ) 
            {
                echo('<p style="color:red">Error:'.$_SESSION["error"]."</p>\n");
                unset($_SESSION["error"]);
            }

            session_destroy();  //stop this session
            echo("You are now logged out</p>");
            
        ?>

        <input type="button" value="Login" onclick="location.href='login.php'; return false "></p>

    </body>
    
</html>