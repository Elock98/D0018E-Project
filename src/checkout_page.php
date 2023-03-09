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
            if(isset($_SESSION['cart_update'])) {
                unset($_SESSION['cart_update']);
                unset($_POST);
                header("Location: checkout_page.php");
                die();
            }
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

            }
        ?>

	<!-- onclick ska ett sql skickas till databasen med update kommando.
	     quantiteten i shopping_cart ska ökas eller minskas med ett.
	      -->

    </body>
</html>
