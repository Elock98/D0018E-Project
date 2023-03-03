<!DOCTYPE html>

<?php
	session_start();
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
        <!--Navbar-->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <!--make "container-fluid" if needed more space-->
                <!--Make collapsable-->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#page_header" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="" class="navbar-brand navbar-left"><img src="img/header-icon.jpeg"></a>
                </div>
                <!--Collapsable navbar-->
                <div class="collapse navbar-collapse" id="page_header">
                    <!--Navigation buttons-->
                    <div class="navbar-nav navbar-left">
                        <ul class="nav navbar-nav">
                            <li class="inactive"><a href="index.php">Home <span class="sr-only">(current)</a></li>
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
                        <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Sign in</a></li>
                        <li><a href="register_account.html"><span class="glyphicon glyphicon-user"></span> Sign up</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!--SignÍn square-->
        <div class="container">
            <div class="panel panel-default" style="text-align:center;">

                <div class="center">
                    <h1>SignIn</h1>
                    <form method="post" action="login.php">
                        <div class="text_line">
                            <input type="Username" name="username" required />
                            <span></span>
                            <label>Username</label>
                        </div>

                        <div class="text_line">
                            <input type="password" name="password" required />
                            <span></span>
                            <label>Password</label>
                        </div>
                        <input type="submit" value="SignIn" />
                        <div class="SignUp">
                            If not a member? <a href="register_account.php">SignUp</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<script>
function go_home(){
        window.location.href = "index.php";
}
</script>

<?php
	$user="admin";
	$password="1234";
	$database="stonebase";
	$table="product";

	$server="localhost";

	$conn = new mysqli($server, $user, $password, $database);
	if($conn->connect_error){
		die("connection failed: " . $conn->connect_error);
	}

	/*Login should take username and password and check if it exists in database user table
	  If it does, the user is logged in and goes to another page, if not, then login failed */

	$username = $_POST['username'];
	$pass_input = $_POST['password'];

	$sql = "SELECT u_id FROM user WHERE u_name='$username' AND u_password='$pass_input'";
	$res = $conn->query($sql);

	if(mysqli_num_rows($res) == 1){
		$row=$res->fetch_assoc();
		$u_id=$row["u_id"];
		$_SESSION["u_id"]=$u_id;

		echo '<script type="text/javascript">',
			'go_home();',
			'</script>';

	/* Works but could make the message look better*/
	} else if($username != "" || $pass_input != ""){
		echo '<script> alert("wrong password or username"); window.location="/login.php" </script>';
	}


?>

    </body>
</html>

