<?php
session_start();

// From: stackoverflow.com/qusetions/1280767/how-i-run-php-code-when-a-user-clicks-on-a-link
$page = $_SERVER["PHP_SELF"];
$file_name_begin_pos = strripos($page, "/");
$file_name = substr($page, ++$fileNamePos);
?>
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
    $sql = "SELECT * FROM employee WHERE u_id='$u_id' AND is_manager=1";

    $res = $conn->query($sql);

    if(mysqli_num_rows($res) != 0){
?>

                        <li class="active"><a href="admin_orders.php">View orders</a></li>
                        <li class="inactive"><a href="manager_page.php">Manage employees <span class="sr-only">(current)</a></li>
<?php
    }
?>
                        <li><a href="checkout_page.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart</a></li>
                        <li class="inactive"><a href="user_account_page.php"><span class="glyphicon glyphicon-user"></span> Account <span class="sr-only">(current)</a></li>
                        <li><a href="logout.php?redirect_to=<?=$file_name?>"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
<?php
}
?>
                    </ul>
                </div>
            </div>
        </nav>
<?php
    $u_id = $_SESSION["u_id"];
    if(!isset($_SESSION["u_id"])) {
        echo '<div class="container" style="padding-top:150px;">';
        echo $u_id;
        die("Not logged in as manager!");
    }
    $sql = "SELECT * FROM employee WHERE u_id='$u_id' AND is_manager=1";

    $res = $conn->query($sql);

    if(mysqli_num_rows($res) == 0 ){
        echo '<div class="container" style="padding-top:150px;">';
        die("Not logged in as manager!");
    }
?>
<!-- Page body -->

<div class="container" style="padding-top:50px;">
    <div class="panel panel-default">
    <div class="panel-body" style="background-color: #f1f1f3;">
    <div class="row">
        <!-- Purchase history -->
        <div class="col-md-6" style="vertical-align: middle; text-align: center;">
        <h2>Order history:</h2>
        <table class="table table-bordered table-responsive" cellpadding="0">
            <tr>
                <td style="width: 10%"><b>UserID:</b></td>
                <td style="width: 15%"><b>Username:</b></td>
                <td style="width: 35%"><b>Order date:</b></td>
                <td><b>Product:</b></td>
                <td style="width: 10%"><b>Quantity:</b></td>
                <td style="width: 15%"><b>Price:</b></td>
            </tr>
        </table>
        <div style="overflow-y: scroll; height:75vh;">
<?php

    $sql = "SELECT orders.o_id, orders.order_date, user.u_id, user.u_name FROM orders
            INNER JOIN user ON user.u_id=orders.u_id
            ORDER BY o_id DESC";

    $orders = $conn->query($sql);


    while($order = $orders->fetch_assoc()) {
        echo '<table class="table table-bordered table-responsive" cellpadding="0">';
        $sql = "SELECT order_item.quantity, order_item.price, product.name
                FROM order_item
                INNER JOIN product ON order_item.p_id=product.p_id
                WHERE o_id=".$order['o_id']."
                ";
        $items = $conn->query($sql);
        while($item = $items->fetch_assoc()) {
            echo '<tr>';
            echo '<td style="width: 10%">'.$order['u_id'].'</td>
                  <td style="width: 15%">'.$order['u_name'].'</td>
                  <td style="width: 35%">'.$order['order_date'].'</td>
                  <td>'.$item['name'].'</td>
                  <td style="width: 10%; vertical-align: middle; text-align: center;">'.$item['quantity'].'</td>
                  <td style="width: 15%; vertical-align: middle; text-align: center;">'.$item['price'].'</td>';
            echo '</tr>';
        }
        echo '</table>';
    }

?>
        </div>
        </div>
        <style>
            .vertical_line {
                border-left: 2px solid lightgrey;
                height: 85vh;
            }
        </style>
        <!-- Account info -->
        <div class="col-md-6 vertical_line" style="vertical-align: middle; text-align: center;">
        <h2>Current shopping carts:</h2>
        <table class="table table-bordered table-responsive" cellpadding="0">
            <tr>
                <td style="width: 10%"><b>UserID:</b></td>
                <td style="width: 15%"><b>Username:</b></td>
                <td><b>Product:</b></td>
                <td style="width: 10%"><b>Quantity:</b></td>
                <td style="width: 15%"><b>Price:</b></td>
            </tr>
        </table>
        <div style="overflow-y: scroll; height:75vh;">
<?php
    $sql = "SELECT user.u_id, user.u_name, shopping_cart.quantity, product.name, product.price
            FROM shopping_cart
            INNER JOIN user ON user.u_id=shopping_cart.c_id
            INNER JOIN product ON product.p_id=shopping_cart.p_id
            ORDER BY user.u_id";
    $cart_entries = $conn->query($sql);

    echo '<table class="table table-bordered table-responsive" cellpadding="0">';
    $first = 1;
    while($entry = $cart_entries->fetch_assoc()) {
        $current = $entry['u_id'];
        if($first) {
            $last = $current;
            $first = 0;
        }

        if($current != $last) {
            $last = $current;
            echo '</table>';
            echo '<table class="table table-bordered table-responsive" cellpadding="0">';
        }

        echo '<tr>';
        echo '<td style="width: 10%">'.$entry['u_id'].'</td>
              <td style="width: 15%">'.$entry['u_name'].'</td>
              <td>'.$entry['name'].'</td>
              <td style="width: 10%; vertical-align: middle; text-align: center;">'.$entry['quantity'].'</td>
              <td style="width: 15%; vertical-align: middle; text-align: center;">'.$entry['price'].'</td>';
        echo '</tr>';


    }
    echo '</table>';
?>
        </div>
    </div>
    </div>
    </div>
</div>

    </body>
</html>

