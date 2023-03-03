<!DOCTYPE html>

<html>

    <title>We have stones</title>

    <head>
        <!-- Include css -->
        <link rel="stylesheet" href="style.css">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <?php
            session_start();
        ?>
    </head>

    <body>
        <!---Navbar--->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container"> <!---make "container-fluid" if needed more space--->
                <!---Make collapsable--->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#page_header" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="" class="navbar-brand navbar-left"><img src="Images/header-icon.jpeg"></a>
                </div>
                <!---Collapsable navbar--->
                <div class="collapse navbar-collapse" id="page_header">
                    <!--Navigation buttons-->
                    <div class="navbar-nav navbar-left">
                        <ul class="nav navbar-nav">
                            <li class="inactive"><a href="index.php">Home <span class="sr-only">(current)</a></li>
                            <li class="inactive"><a href="about.html">About <span class="sr-only">(current)</a></li>
                            <li class="inactive"><a href="checkout_page.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-minecart" viewBox="0 0 16 16">
  <path d="M4 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm0 1a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm8-1a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm0 1a2 2 0 1 0 0-4 2 2 0 0 0 0 4zM.115 3.18A.5.5 0 0 1 .5 3h15a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 14 12H2a.5.5 0 0 1-.491-.408l-1.5-8a.5.5 0 0 1 .106-.411zm.987.82 1.313 7h11.17l1.313-7H1.102z"/>
</svg></a></li>
                        </ul>
                    </div>
                    <!--Search bar-->
                    <div class="navbar-nav">
                        <form class="navbar-form navbar-left" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">Search</button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <!--Accout related buttons-->
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Sign in</a></li>
                        <li><a href="register_account.html"><span class="glyphicon glyphicon-user"></span> Sign up</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <?php
            ini_set('display_errors', 1);
            $user="admin";
            $password="1234";
            $database="stonebase";
            $server="localhost";

            $conn = new mysqli($server, $user, $password, $database);
            if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
            }

            $p_id=$_GET["pid"];

            $error_msg="";
            $succ_msg="";
            if(isset($_POST['add'])) {
                if(isset($_SESSION['u_id'])) {
                    $u_id=$_SESSION['u_id'];

                    $sql = "SELECT * FROM shopping_cart WHERE c_id = '$u_id' AND p_id = '$p_id'";
                    $res = $conn->query($sql);
                    if(mysqli_num_rows($res) >= 1){
                        $error_msg="Product already in cart";
                    } else{
                        $sql = "INSERT INTO shopping_cart (c_id, p_id, quantity) VALUES ($u_id, $p_id, 1)";
                        $result = $conn->query($sql);
                        $succ_msg="Product added to cart";
                    }
                } else {
                    $error_msg="Please login";
                }
            }

            $sql = "SELECT * FROM product WHERE p_id = $p_id";

            $result = $conn->query($sql);

            echo '<table class="table table-bordered table-responsive" cellpadding="0">';
            $row = $result->fetch_assoc();
            echo '<tr>
                <td style="width: 20%">' . '<img src="'.$row['image'].'" width="100%" height="100%">' . '
                <h3>review</h3></td>
                <td><h1>' . $row['name'] . '</h1><hr>
                <h3>' . $row['description'] . '</h3></td>
                <td style="width:20%; vertical-allign: middle; text-allign: center;"><h2>' . $row['price'] . ' kr</h2>
                <h2>' . $row['stock'] . ' in stock</h2>
                <form method="post">
                    <input type="submit" name="add" value="Add to cart"/>
                </form>
                <h4 style="color:red">' . $error_msg . '</h4>
                <h4 style="color:green">' . $succ_msg . '</h4></td>

            </tr>';
        ?>
    </body>
</html>
