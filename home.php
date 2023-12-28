<?php
    session_start();
    
    require_once("database.php");//lets us make our connection
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
            
                        if ( isset($_SESSION["success"]) ) //checks if user has signed in
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
    <h1>Ohara Library    </h1>
    <br>
    <p>
        <img src = "image/big_image.jpeg" alt = "empty library" class = "center"width = "30%">

        <h2 text-align:center>Explore Possibilities</h2> <!-- filler text for aesthetic-->
        <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
            Aliquam egestas leo eget sapien viverra ultrices. 
            Maecenas efficitur venenatis odio, in interdum nunc scelerisque sed.
             In suscipit diam vel semper aliquet. 
             Phasellus at accumsan odio, nec auctor diam. 
             Nullam ultricies accumsan turpis et accumsan. 
             Cras fringilla, erat vitae laoreet tempus, diam lorem posuere neque, a lobortis velit sem ac est.
              Vivamus rutrum nisi nec malesuada blandit. 
              Fusce vel convallis nunc. Donec a vestibulum metus.
               Nulla malesuada libero accumsan porta aliquet. In libero lacus, vestibulum eu felis pretium, pharetra malesuada risus. 
            Curabitur dapibus tellus ex, at tincidunt risus porta nec.
        </h3>
    </p>




    <footer><!--not real contact info please dont contact these people -->
        Contact us<br>
        made_up@library.com<br>
        (01) 890 6719<br>



    </footer>
</body>
</html>