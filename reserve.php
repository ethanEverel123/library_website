<?php
    session_start();
    
    require_once("database.php");

    unset($_SESSION["ISBN"]);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
</head>
<body>
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
            
                        if ( isset($_SESSION["success"]) ) //check if log in was a success
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

    <?php
    $account = $_SESSION['account']; //session account variable holds urrent user's username
    $ISBN = $_POST['reserve'];   //ISBN code of book user wants to reserve
    $date = date('Y-m-d', time());  //current date

    //sets the book to be reserved making it no longer reservable
    $setsql = ("UPDATE books
    SET reserved = 1
    WHERE ISBN LIKE '$ISBN'");
    $conn ->query($setsql);

           

    //insert the collected values into the reservations table for keeping track of who reserved what
    $sql = ("INSERT INTO `reservations` (ISBN,username,reserveddate) VALUES 
    ('$ISBN','$account','$date');");

    $conn ->query($sql);
    ?>

    <h1><!-- confirmation-->
        reservation complete
    </h1>


    <footer>


    </footer>
</body>
</html>