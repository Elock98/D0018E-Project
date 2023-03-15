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
                        <li class="active"><a href="restock_page.php"><span class="glyphicon glyphicon-list-alt"></span> Manage products <span class="sr-only">(current)</a></li>
<?php
    }
    $sql = "SELECT * FROM employee WHERE u_id='$u_id' AND is_manager=1";

    $res = $conn->query($sql);

    if(mysqli_num_rows($res) != 0){
?>
                        <li class="inactive"><a href="admin_orders.php">View orders</a></li>
                        <li class="inactive"><a href="manager_page.php">Manage employees <span class="sr-only">(current)</a></li>
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
if(!isset($_SESSION["u_id"])) {
    echo '<div class="container" style="padding-top:50px;">
        <h1 style="align: center;"> YOU ARE NOT AN EMPLOYEE </h1>
        </div>';
    die("Not logged in as an employee");
}else{
    /*Connect to db*/
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

    if(mysqli_num_rows($res) == 0) {
        echo '<div class="container" style="padding-top:50px;">
            <h1 style="align: center;"> YOU ARE NOT AN EMPLOYEE </h1>
            </div>';
    die("Not logged in as an employee");
    }

}

?>

    <!-- Logged in as employee here -->
    <div class="container" style="padding-top:50px;">
        <div class="panel panel-default">
        <div class="panel-body">
        <form method="post">
<?php

$sql = "SELECT * FROM product";

$res = $conn->query($sql);

$prices = array();
$stocks = array();
$p_ids = array();

echo '<table class="table table-bordered table-responsive table-hover table-cursor" cellpadding="0">';
while($row = $res->fetch_assoc()) {
    array_push($prices, $row['price']);
    array_push($stocks, $row['stock']);
    array_push($p_ids, $row['p_id']);
    echo '<tr>
        <td style="width: 10%">' . '<img src="'.$row['image'].'">' . '</td>
        <td><h1><div class="form-group"><input type="text" name="name_'.$row['p_id'].'" class="form-control" placeholder="'.$row['name'].'"></div></h1><hr>
        <h3><div class="form-group"><textarea style="resize: none;" rows="4" cols="20" name="description_'.$row['p_id'].'" class="form-control" placeholder="'.$row['description'].'"></textarea></div></h3></td>
        <td style="width:20%; vertical-align: middle; text-align: center;">
        <div class="form-group">
        <h3>Price:</h3>
        <input type="number" name="price_'.$row['p_id'].'" class="form-control" placeholder="'.$row['price'].'">
        </div>
        <div class="form-group">
        <h3>Stock:</h3>
        <input type="number" name="stock_'.$row['p_id'].'" class="form-control" placeholder="'.$row['stock'].'">
        </div>
        </tr>';
};
echo '<tr><td><button type="submit" class="btn btn-primary btn-lg" >Submit Changes</button></td></tr></table>';
?>
            </form>
                <form id="AddForm" method="post" style="display: inline-block; vertical-align: top;">
                    <div class="form-group">
                        <table>
                            <tr>
                                <td style="padding-left: 10px;"><input type="text" name="new_image" class="form-control" placeholder="Images/new_image.jpg"></td>
                                <td style="padding-left: 10px;"><input type="text" name="new_name" class="form-control" placeholder="New Product Name"></td>
                                <td style="padding-left: 10px;"><input type="text" name="new_desc" class="form-control" placeholder="New Product Description"></td>
                                <td style="padding-left: 10px;"><input type="number" name="new_price" class="form-control" placeholder="New Product Price"></td>
                                <td style="padding-left: 10px;"><input type="number" name="new_stock" class="form-control" placeholder="New Product Stock"></td>
                                <td style="padding-left: 10px;"><button type="submit" class="btn btn-primary">Add Product</button></td>
                            </tr>
                        </table>
                    </div>
                </form>

<!-- Update database -->

<script>

function updatePlacholder(id, val){
    console.log(id);
    console.log(val);
    document.getElementsByName(id)[0].placeholder=val;
}

</script>
<?php

/*
 * For each of the products we know the id of each
 * update field. Using this we can check if it has
 * been updated and if this is true we can attempt
 * to update the database using the p_id.
 */

$products = count($prices);
for($i = 0; $i < $products; $i++) {
    $price_name = 'price_'.$p_ids[$i];
    $stock_name = 'stock_'.$p_ids[$i];
    $name_name = 'name_'.$p_ids[$i];
    $desc_name = 'description_'.$p_ids[$i];
    if($_POST[$price_name] != $prices[$i] && $_POST[$price_name] != "" && $_POST[$price_name] >= 0) {
        $sql = "UPDATE product SET price = ".$_POST[$price_name]." WHERE p_id = ".$p_ids[$i];
        $res = $conn->query($sql);
        $new = $_POST[$price_name];
        echo "<script>updatePlacholder('$price_name', $new)</script>";
    }
    if($_POST[$stock_name] != $stocks[$i] && $_POST[$stock_name] != "" && $_POST[$stock_name] >= 0) {
        $sql = "UPDATE product SET stock = ".$_POST[$stock_name]." WHERE p_id = ".$p_ids[$i];
        $res = $conn->query($sql);
        $new = $_POST[$stock_name];
        echo "<script>updatePlacholder('$stock_name', $new)</script>";
    }
    if($_POST[$name_name] != $names[$i] && $_POST[$name_name] != "") {
        $sql = "UPDATE product SET name = '".$_POST[$name_name]."' WHERE p_id = ".$p_ids[$i];
        $res = $conn->query($sql);
        $new = $_POST[$name_name];
        echo "<script>updatePlacholder('$name_name', '$new')</script>";
    }
    if($_POST[$desc_name] != $names[$i] && $_POST[$desc_name] != "") {
        $sql = "UPDATE product SET description = '".$_POST[$desc_name]."' WHERE p_id = ".$p_ids[$i];
        $res = $conn->query($sql);
        $new = $_POST[$desc_name];
        echo "<script>updatePlacholder('$desc_name', '$new')</script>";
    }
}

?>

<!-- Add product -->

<?php

/*
 * Check that all the fields have been filled out,
 * if true then add to db, else don't.
 * For this to work the db needs to be updated to have
 * unique product names and auto incremented p_id.
 */

if($_POST["new_image"] != "" &&
    $_POST["new_name"] != "" &&
    $_POST["new_desc"] != "" &&
    $_POST["new_price"] != "" &&
    $_POST["new_stock"] != "") {

    $sql = "INSERT INTO product(price, stock, name, description, image) VALUES(".$_POST["new_price"].",". $_POST["new_stock"].", '". $_POST["new_name"]."', '". $_POST["new_desc"]."', '". $_POST["new_image"]."')";


    $res = $conn->query($sql);
    echo "<script>location.reload()</script>";
}

?>

            </div>
        </div>
    </div>

    </body>
</html>
