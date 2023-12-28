<?php
    session_start();
    require_once("database.php");

?>

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
            
                        if ( isset($_SESSION["success"]) )  //limit access based on if the user is logged in 
                        {
                            echo("<a href = 'profile.php'>".$_SESSION["account"]."</a>\n");
                        }

                        else    //let user log in if not
                        {
                            echo("<a href = 'login.php'>Log in</a>");
                        }
                    ?>
                </td>

            </tr>
        </table>
    </header>

    <h1>Search:</h1>
    <form action = "search.php" method = "post">
        <input type = "text" name = "search" placeholder = "search">   <!--search by author and/or title -->

        <select name="genre" id="lang">         <!--search by  genre -->
            <option value = "NULL">Genre</option>
            <option value="Health">Health</option>
            <option value="Business">Business</option>
            <option value="Biography">Biography</option>
            <option value="Technology">Technology</option>
            <option value="Travel">Travel</option>
            <option value="Self-Help">Self Help</option>
            <option value="Cookery">Cookery</option>
            <option value="Fiction">Fiction</option>
        </select>

      <br>
      <input type="submit" value="Search" />
    </form>


    <?php

    $search = $_POST['search']; //get the value from the form using the post method
    $genre = $_POST['genre'];

    $conn = new mysqli($host, $username,$password,$dbname);

    //echo($search); //for debugging

    if ( $search != NULL and $genre = "NULL")   //display the table with searched value, no category restraint
    {   
        //select all values from books where book title or author contain the search value 
        $sql = ("SELECT * FROM books WHERE booktitle LIKE '%$search%' OR author LIKE '%$search%'");

        $result = $conn->query($sql);

        if($result->num_rows > 0)   //if there are more than 0 results
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
                    <th>reserve</th>
                </tr>";
            
            while($row = $result->fetch_assoc())//while the row is the same as the next row in result
            {
                echo ("<tr>");
                
                //echo books values
                echo("<td>".$row["ISBN"]);
                echo("</td><td>".$row["booktitle"]);
                echo("</td><td>".$row["author"]);
                echo("</td><td>".$row["edition"]);
                echo("</td><td>".$row["year"]);
                echo("</td><td>".$row["category"]);
                echo("</td><td>".$row["reserved"]);           
                echo("</td><td>");

                if ( isset($_SESSION["success"]) ) 
                {          
                    if($row["reserved"] == 1)  //if a book cant be reserved
                    {
                        echo '<form method="post"';   
                        echo '<input type="hidden" name="reserve" action = "search.php"/>';
                        echo '<input type="submit" name="submit_button" value="cannot reserve" />';
                        echo '</form>';
                    }

                    elseif($row["reserved"] == 0)  //if a book can be reserved
                    {
                        echo '<form method="post" action="reserve.php">';
                        //hidden button stores the ISBN of the row
                        echo '<input type="hidden" name="reserve" value="'.$row["ISBN"].'" />';
                        //subits the ISBN value by post
                        echo '<input type="submit" name="submit_button" value="reserve" />';
                        echo '</form>';

                    }
                }
                else
                {
                    echo("<form action = 'login.php'>");    //for if the user isnt logged in
                        echo ("<input type = 'submit' value = 'Log in' >");
                    echo("</form>");
                }
                echo("</td></tr>");
            }
            echo"</table>";
        }

        else //print echo 0 results
        {   //complete :]
            echo("0 results found");
        }
    }


    elseif ($search = 'NULL' and $genre != "NULL")//print genre
    {   
        //get the ID of the category chosen by the user based on categorydesc 

        $sql = ("SELECT CategoryID FROM `categories` WHERE categorydesc LIKE '$genre'");

        $result = $conn->query($sql);

        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $categoryID = $row["CategoryID"];//set categoryID to the result

                //second sql to select all values in books that have the categoryID gotten from the previous 
                //sql statement
                $sql2 = ("SELECT * FROM `books` WHERE category = $categoryID");
        
                $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0)
                {
                    echo"<table class = 'search'>";
                    echo"<tr>
                            <th>ISBN</th>
                            <th>booktitle</th>
                            <th>author</th>
                            <th>edition</th>
                            <th>year</th>
                            <th>category</th>
                            <th>reserved</th>
        
                        </tr>
                    ";
                    while($row2 = $result2->fetch_assoc())
                    {
                        echo ("<tr>");
                
                        echo("<td>".$row2["ISBN"]);
                        echo("</td><td>".$row2["booktitle"]);
                        echo("</td><td>".$row2["author"]);
                        echo("</td><td>".$row2["edition"]);
                        echo("</td><td>".$row2["year"]);
                        echo("</td><td>".$genresqlval);
                        echo("</td><td>".$row2["reserved"]);           
                        echo("</td><td>");
            
                        if ( isset($_SESSION["success"]) ) 
                        {                        
                            if($row2["reserved"] == 1)  //if a book cant be reserved
                            {
                                echo '<form method="post"';   
                                echo '<input type="hidden" name="reserve" action = "search.php"/>';
                                echo '<input type="submit" name="submit_button" value="cannot reserve" />';
                                echo '</form>';
                            }

                            elseif($row2["reserved"] == 0)  //if a book can be reserved
                            {
                                echo '<form method="post" action="reserve.php">';
                                //hidden button stores value of its row's ISBN 
                                echo '<input type="hidden" name="reserve" value="'.$row2["ISBN"].'" />';
                                //posts the ISBN value when the reserve button is clicked
                                echo '<input type="submit" name="submit_button" value="reserve" />';
                                echo '</form>';

                            }
                        }
                        else
                        {
                            //you must be logged in to reserve
                            echo("<form action = 'login.php'>");    //for if user is logged in
                                echo ("<input type = 'submit' value = 'Log in' >");
                            echo("</form>");
                        }

                        echo("</td></tr>");
                    }
                    echo("</table>");

                }
                else    //if category has no values go here
                {
                    echo("0 results found");
                }
                
            }
        }

        else //print echo 0 results
        {   //complete :]
            echo("0 results found ");
        }  
    }
    $conn->close();
    ?> 

    <footer>
        Contact us<br>
        made_up@library.com<br>
        (01) 890 6719<br>



    </footer>
</body>


</html>