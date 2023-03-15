<?php
    session_start();
    if(isset($_SESSION['redirect'])) {
        unset($_SESSION['redirect']);
        header("Location: index.php");
        die();
    }
    if(isset($_SESSION['cart_update'])) {
	unset($_SESSION['cart_update']);
	unset($_POST);
	header("Location: checkout_page.php");
	die();
    }

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
?>
                        <li class="active"><a href="checkout_page.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart <span class="sr-only">(current)</a></li>
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

            $p_id_array = array();
            $quantity_array = array();

            if(isset($_SESSION['u_id'])) {
                $u_id=$_SESSION['u_id'];

                $sql = "SELECT * FROM product INNER JOIN shopping_cart ON shopping_cart.c_id = '$u_id' WHERE product.p_id = shopping_cart.p_id";
                $result = $conn->query($sql);

                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    /* Make loop through all p_ids*/
                    $quantity_array = $_SESSION['quantity_array'];
                    $p_id_array = $_SESSION['p_id_array'];
                    $p_id_num = count($p_id_array);

                    for($i = 0; $i < $p_id_num; $i++) {
                        if(isset($_POST['decrease_'.$p_id_array[$i]])) {

                            if($quantity_array[$i] > 0){
                                $sql = "UPDATE shopping_cart SET quantity =".($quantity_array[$i] - 1)." WHERE p_id =".$p_id_array[$i]."" ;
                                $res = $conn->query($sql);
                                $_SESSION['cart_update'] = 1;
                            }
                        }

                        if(isset($_POST['increase_'.$p_id_array[$i]])) {
                            $sql = "UPDATE shopping_cart SET quantity =".($quantity_array[$i] + 1)." WHERE p_id =".$p_id_array[$i]."" ;
                            $res = $conn->query($sql);
                            $_SESSION['cart_update'] = 1;
                        }
                    }

                        /* reset post after loop, reset post variable*/
                }
                $p_id_array = array();
                $quantity_array = array();

                echo '<table class="table table-bordered table-responsive" cellpadding="0">';
                while($row = $result->fetch_assoc()) {
                    /* add p_id to fill the p_id array*/
                    array_push($p_id_array, $row['p_id']);
                    array_push($quantity_array, $row['quantity']);
                    echo '<form method="post">
                           <tr>
                            <td style="width: 10%">' . '<img src="'.$row['image'].'">' . '</td>
                            <td><h1>' . $row['name'] . '</h1><hr>
                            <h2>Quantity:
			    <button type="submit" name="decrease_'.$row['p_id'].'" value="decrease"
		            class="quantity-button decrease-button"
           		    title="minus">-</button>

			    ' . $row['quantity'] .'
 		            <button type="submit" name="increase_'.$row['p_id'].'" value="increase"
           		    class="quantity-button increase-button"
      			    title="plus">+</button>

			    </h2></td>
                            <td style="width:20%; vertical-align: middle; text-align: center;">
                            <h2>' . $row['price'] . ' kr</h2></td>
                        </tr>
                        </form>';
                };
                $_SESSION['quantity_array'] = $quantity_array;
                $_SESSION['p_id_array'] = $p_id_array;

                echo '<form method="post">
                        <input type="submit" name="order" value="Order"/>
                    </form>';

		        if(isset($_POST['order'])) {
                    # Check stock
                    $quantityOfProd=$conn->query("SELECT stock FROM product LEFT JOIN shopping_cart ON shopping_cart.c_id = '$u_id' WHERE product.p_id = shopping_cart.p_id");
                    $i=0;
                    while($res=$quantityOfProd->fetch_assoc()) { if($res['stock'] < $quantity_array[$i]) { echo "Quantity exceeds the current stock."; exit(0); } $i++; }

                    $createOrder="INSERT INTO orders (u_id, order_date) values ('$u_id', now())";
                    $conn->query($createOrder);

                    $getOrderID="SELECT o_id FROM orders WHERE u_id = $u_id";
                    $result=$conn->query($getOrderID);
                    $order_id=-1;
                    while($res = $result->fetch_assoc()) { if ($order_id < $res['o_id']) { $order_id = $res['o_id']; } }
                    
		            $result=$conn->query($sql);
              	    while($res = $result->fetch_assoc()) {
                        $p_id=$res['p_id'];
                        $prod=$conn->query("SELECT * FROM shopping_cart INNER JOIN product ON product.p_id = $p_id WHERE shopping_cart.p_id = $p_id AND shopping_cart.c_id = $u_id");
                        $res=$prod->fetch_assoc();
                        $quantity=$res['quantity'];
                        $price=$res['price'];

                     	$orderItem="INSERT INTO order_item (o_id, p_id, quantity, price) values ($order_id, $p_id, $quantity, $price)";
                        $conn->query($orderItem);
               	    }

                    $res=$conn->query($sql);
                    while($r=$res->fetch_assoc()) {
                        $newStock=$r['stock'] - $r['quantity'];
                        $p_id=$r['p_id'];
                        $conn->query("UPDATE product SET stock = $newStock WHERE p_id = $p_id");
                    }

                    $clearShoppingCart="DELETE FROM shopping_cart WHERE c_id = $u_id";
                    $conn->query($clearShoppingCart);

                    
                    $_SESSION['redirect'] = 1;
                    echo "<script>location.reload()</script>";
                } 
            }
        ?>

	<!-- onclick ska ett sql skickas till databasen med update kommando.
	     quantiteten i shopping_cart ska ökas eller minskas med ett.
	      -->
    </body>
</html>
