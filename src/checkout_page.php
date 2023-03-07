<!DOCTYPE html>

<?php
    session_start();
    if(isset($_SESSION['redirect'])) {
        unset($_SESSION['redirect']);
        header("Location: index.php");
        die();
    }
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
                            <li class="active"><a href="checkout_page.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-minecart" viewBox="0 0 16 16">
  <path d="M4 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm0 1a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm8-1a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm0 1a2 2 0 1 0 0-4 2 2 0 0 0 0 4zM.115 3.18A.5.5 0 0 1 .5 3h15a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 14 12H2a.5.5 0 0 1-.491-.408l-1.5-8a.5.5 0 0 1 .106-.411zm.987.82 1.313 7h11.17l1.313-7H1.102z"/>
</svg></a></li>
                    <!---<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-minecart-loaded" viewBox="0 0 16 16">
  <path d="M4 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm0 1a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm8-1a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm0 1a2 2 0 1 0 0-4 2 2 0 0 0 0 4zM.115 3.18A.5.5 0 0 1 .5 3h15a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 14 12H2a.5.5 0 0 1-.491-.408l-1.5-8a.5.5 0 0 1 .106-.411zm.987.82 1.313 7h11.17l1.313-7H1.102z"/>
  <path fill-rule="evenodd" d="M6 1a2.498 2.498 0 0 1 4 0c.818 0 1.545.394 2 1 .67 0 1.552.57 2 1h-2c-.314 0-.611-.15-.8-.4-.274-.365-.71-.6-1.2-.6-.314 0-.611-.15-.8-.4a1.497 1.497 0 0 0-2.4 0c-.189.25-.486.4-.8.4-.507 0-.955.251-1.228.638-.09.13-.194.25-.308.362H3c.13-.147.401-.432.562-.545a1.63 1.63 0 0 0 .393-.393A2.498 2.498 0 0 1 6 1z"/>
</svg>-->
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
                        <li><a href="login.html"><span class="glyphicon glyphicon-log-in"></span> Sign in</a></li>
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

            if(isset($_SESSION['u_id'])) {
                $u_id=$_SESSION['u_id'];

                $sql = "SELECT * FROM product INNER JOIN shopping_cart ON shopping_cart.c_id = '$u_id' WHERE product.p_id = shopping_cart.p_id";
                $result = $conn->query($sql);
                echo '<table class="table table-bordered table-responsive" cellpadding="0">';
                while($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td style="width: 10%">' . '<img src="'.$row['image'].'">' . '</td>
                            <td><h1>' . $row['name'] . '</h1><hr>
                            <h2>Quantity: ' . $row['quantity'] .'</h2></td>
                            <td style="width:20%; vertical-align: middle; text-align: center;">
                            <h2>' . $row['price'] . ' kr</h2></td>
                        </tr>';
                };

                echo '<form method="post">
                        <input type="submit" name="order" value="Order"/>
                    </form>';

		        if(isset($_POST['order'])) {
                    $createOrder="INSERT INTO orders (u_id, order_date) values ('$u_id', now())";
                    $conn->query($createOrder);

                    $getOrderID="SELECT o_id FROM orders WHERE u_id = $u_id";
                    $result=$conn->query($getOrderID);
                    $order_id=-1;
                    while($res = $result->fetch_assoc()) { if ($order_id < $res['o_id']) { $order_id = $res['o_id']; } }
                    
		            $result=$conn->query($sql);
              	    while($res = $result->fetch_assoc()) {
                        $p_id=$res['p_id'];
                     	$orderItem="INSERT INTO order_item (o_id, p_id, quantity) values ($order_id, $p_id, 1)";
                        $conn->query($orderItem);
               	    }

                    $clearShoppingCart="DELETE FROM shopping_cart WHERE c_id = $u_id";
                    $conn->query($clearShoppingCart);

                    
                    $_SESSION['redirect'] = 1;
                    echo "<script>location.reload()</script>";
                } 
            }
        ?>

    </body>
</html>
