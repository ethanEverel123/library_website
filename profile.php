<?php
    session_start();
    require_once("database.php"); 

    if(isset($_POST['un-reserve']))//check if a value has been posted to un-reserve
    {
        $ISBN = $_POST['ISBN'];

        $unreservesql = ("UPDATE books SET reserved = 0 WHERE ISBN = '$ISBN';");    //sets the reserved value back to being unreserved

        $conn-> query($unreservesql);   //run sql query to unreserve books

        $sql = ("DELETE FROM reservations WHERE ISBN = '$ISBN';");  //get rid of the record in reservations

        $conn-> query($sql);

    }
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
            
                        if ( isset($_SESSION["success"]) )  //limit profile.php access based on if logged in 
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
    <img src="image/profile.png" class="center" width = "10%">  

    <?php
    
    $account = $_SESSION["account"]; //let the username of the user be a variable account


    echo($account."<br>"); 


    //gets the values from books where the reservations are made under the current user
    $sql = ("SELECT * FROM books INNER JOIN reservations ON books.ISBN = reservations.ISBN 
    WHERE reservations.username LIKE '$account'"); 

    $result = $conn->query($sql);


    if($result->num_rows > 0)
    {
        echo"<table>";
        echo"<tr>
                <th>ISBN</th>
                <th>booktitle</th>
                <th>author</th>
                <th>edition</th>
                <th>year</th>
                <th>category</th>
                <th>reserved</th>
            </tr>";
        
        while($row = $result->fetch_assoc())
        {
            echo ("<tr>");
            
            echo("<td>".$row["ISBN"]);
            echo("</td><td>".$row["booktitle"]);
            echo("</td><td>".$row["author"]);
            echo("</td><td>".$row["edition"]);
            echo("</td><td>".$row["year"]);
            echo("</td><td>".$row["category"]);
            echo("</td><td>".$row["reserved"]);           
            echo("</td><td>");
        
            echo '<form action = "profile.php" method="post" >';   
            echo '<input type="hidden" name="ISBN" value = '.$row["ISBN"].'>';  //use a hidden button to store the value of its row
            echo '<input id = "submit" type="submit" name = "un-reserve" value="un-reserve">';  //submits this stored value
            echo '</form>';

            echo("</td></tr>");
        }

        echo"</table>";
        
    }
    else
    {
        echo("0 results found");
    }

    $conn->close();

    echo("<form action = 'logout.php'>");   //logout form
        echo ("<input type = 'submit' value = 'logout' >");
    echo("</form>");

    ?>
</body>
</html>