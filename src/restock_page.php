<?php
	session_start();
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
                            <li class="active"><a href="index.html">Home <span class="sr-only">(current)</a></li>
                            <li class="inactive"><a href="about.html">About <span class="sr-only">(current)</a></li>
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
	<div class="container" style="padding-top:100px;">
	    <div class="panel panel-default">
		<div class="panel-body">
		<form>
<?php

$sql = "SELECT * FROM product";

$res = $conn->query($sql);


echo '<table class="table table-bordered table-responsive table-hover table-cursor" cellpadding="0">';
while($row = $res->fetch_assoc()) {
	echo '<tr onclick="goto_product_page(' . $row['p_id'] . ')">
		<td style="width: 10%">' . '<img src="'.$row['image'].'">' . '</td>
		<td><h1>' . $row['name'] . '</h1><hr>
		<h3>' . $row['description'] . '</h3></td>
		<td style="width:20%; vertical-align: middle; text-align: center;">
		<div class="form-group" id="price_'.$row['p_id'].'">
			<h3>Price:</h3>
			<input type="number" class="form-control" placeholder="'.$row['price'].'"
		</div>
		<div class="form-group" id="stock_'.$row['p_id'].'">
			<h3>Stock:</h3>
			<input type="number" class="form-control" placeholder="'.$row['stock'].'"
		</div>
		</tr>';
};
?>
			</form>
			</div>
		</div>
	</div>

    </body>
</html>
