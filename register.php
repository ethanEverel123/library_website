<?php
    session_start();
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
            
                        if ( isset($_SESSION["success"]) ) 
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

    <h1>Please enter your details below</h1>

    <form method="post">    <!-- post used to retrieve new user data-->
        <p>Username:<br>
            <input type="text" name="uname"> 
        </p>
        <p>Password:<br>
            <input type="text" name="password"> 
        </p>
        <p>Confirm Password:<br>
            <input type="text" name="password2"> 
        </p>
        <p>First name:<br>
            <input type="text" name="fname"> 
        </p>
        <p>surname:<br>
            <input type="text" name="sname"> 
        </p>
        <p>Address line 1:<br>
            <input type="text" name="address1"> 
        </p>
        <p>Address line 2:<br>
            <input type="text" name="address2"> 
        </p>
        <p>City:<br>
            <input type="text" name="city"> 
        </p>
        <p>Telephone number:<br>
            <input type="text" name="telephone"> 
        </p>
        <p>Mobile number:<br>
            <input type="text" name="mobile"> 
        </p>
        <p>
            <input type="submit" value="Add new"/>
            <a href="home.php">Cancel</a>
        </p>
    </form>

    <?php
        require_once "database.php";

        $sqlunique = ("SELECT username FROM users where username = '$uname' "); //searches the table to find if there are any of the sma username
        $unique_result = $conn->query($sqlunique);

        $numlength = strlen((string)$mobile);   //finds length of mobile number

        if(strlen($password) > 6)
        {
            echo("password too big<br>");
            return;
        }
        elseif(strlen($password) < 6 and $password != NULL )
        {
            echo("password too small<br>");
            return;
        }
        elseif($unique_result->num_rows > 0)
        {
            echo("username taken<br>");
            return;
        }
        elseif (is_nan($mobile) and $mobile != NULL) //is_nan checks if it is not alphanumeric
        {
            echo("mobile number isn't numeric");
            return;
        }
        elseif ($numlength != 10 and $mobile != NULL) 
        {
            echo("mobile number is incorrect size");
            return;
        }
        elseif ($password != $password2)    //if theyre not the same value
        {
            echo("please repeat your password");
            return;
        }

        elseif 
            ( 
            isset($_POST['uname']) && 
            isset($_POST['password']) && 
            isset($_POST['fname']) && 
            isset($_POST['sname']) &&
            isset($_POST['address1']) && 
            isset($_POST['address2']) && 
            isset($_POST['city']) && 
            isset($_POST['telephone']) && 
            isset($_POST['mobile'])
            ) //validate that all register values have been set
        {


            //sets all the posted values to variables to be inserted
            $uname = $conn -> real_escape_string($_POST['uname']);
            $password = $conn -> real_escape_string($_POST['password']);
            $fname = $conn -> real_escape_string($_POST['fname']);
            $sname = $conn -> real_escape_string($_POST['sname']);
            $address1 = $conn -> real_escape_string($_POST['address1']);
            $address2 = $conn -> real_escape_string($_POST['address2']);
            $city = $conn -> real_escape_string($_POST['city']);
            $telephone = $conn -> real_escape_string($_POST['telephone']);
            $mobile = $conn -> real_escape_string($_POST['mobile']);
            

            //inserts into users
            $sql = (" INSERT INTO users (username, password, firstname, surname, addressline1, addressline2, city, telephone, mobile)
             VALUES 
            ('$uname','$password','$fname','$sname','$address1','$address2','$city','$telephone','$mobile')");

            $conn ->query($sql);
            return;
        }

    $conn->close();
    ?>



<footer><!--not real contact info please dont contact these people -->
        Contact us<br>
        made_up@library.com<br>
        (01) 890 6719<br>



    </footer>
</body>
</html>