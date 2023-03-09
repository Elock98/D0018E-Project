<!DOCTYPE html>

<?php
	session_start();
// From: stackoverflow.com/qusetions/1280767/how-i-run-php-code-when-a-user-clicks-on-a-link
$page = $_SERVER["PHP_SELF"];
$file_name_begin_pos = strripos($page, "/");
$file_name = substr($page, ++$fileNamePos);
?>

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
    </head>

    <body>
        <!---Navbar--->
        <nav class="navbar navbar-inverse navbar-fixed-top">
           <a class="navbar-brand" href="">MemeStones</a>
            <div class="container"> <!---make "container-fluid" if needed more space--->
                <!---Make collapsable--->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#page_header" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!---Collapsable navbar--->
                <div class="collapse navbar-collapse" id="page_header">
                    <!--Navigation buttons-->
                    <div class="navbar-nav navbar-left">
                        <ul class="nav navbar-nav">
                            <li class="inactive"><a href="index.php">Home <span class="sr-only">(current)</a></li>
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
<?php
if(!isset($_SESSION["u_id"])){
    //If not logged in
?>
                        <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Sign in</a></li>
                        <li><a href="register_account.php"><span class="glyphicon glyphicon-user"></span> Sign up</a></li>
<?php
} else {
    //If logged in
    $user = "admin";
    $password="1234";
    $database="stonebase";
    $server="localhost";

    $conn = new mysqli($server, $user, $password, $database);
    if($conn->connect_error){
        die("Connection to database failed: " . $conn->connect_error);
    }

    $u_id = $_SESSION["u_id"];
    $sql = "SELECT * FROM employee WHERE u_id='$u_id'";

    $res = $conn->query($sql);

    if(mysqli_num_rows($res) != 0){
        // If logged in as employee

?>
                        <li><a href="restock_page.php"><span class="glyphicon glyphicon-list-alt"></span> Manage products</a></li>
<?php
    }
?>
                        <li><a href="checkout_page.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart</a></li>
                        <li><a href="user_account_page.php"><span class="glyphicon glyphicon-user"></span> Account</a></li>
                        <li><a href="logout.php?redirect_to=<?=$file_name?>"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
<?php
}
?>
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
