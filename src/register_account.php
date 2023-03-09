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
            <div class="container">
                <!---make "container-fluid" if needed more space--->
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
                        <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Sign in</a></li>
                        <li class="active"><a href="register_account.php"><span class="glyphicon glyphicon-user"></span> Sign up <span class="sr-only">(current)</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!--SignUp square-->
        <div class="container">
            <div class="panel panel-default" style="text-align:center;">

                <div class="center2">
                    <h1>SignUp</h1>
                    <form method="post">
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
                        <input type="submit" value="SignUp" />
                    </form>
                </div>
            </div>
        </div>

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

	$username = $_POST['username'];
	$pass = $_POST['password'];

	/* Check if username exists in user table*/
	$sql = "SELECT u_name FROM user WHERE u_name='$username'";
	$res = $conn->query($sql);

	if(($username != "" && $pass != "") && (mysqli_num_rows($res) == 0)){

		/* A loop to check which u_id that is availible, if available insert username*/
		$i = 0;
		$sql2 = "SELECT u_id FROM user WHERE u_id='$i'";
		$res2 = $conn->query($sql2);

		while(mysqli_num_rows($res2) != 0 ) {
			$i = $i + 1;
			$sql2 = "SELECT u_id FROM user WHERE u_id='$i'";
	                $res2 = $conn->query($sql2);
		}
		/* Can add numbers as username but not characters right now*/
		$sql3 = "INSERT INTO user VALUES ($i, '$username', '$pass')";
		$res3 = $conn->query($sql3);

		/* Change alerts to real popup windows to look better */
		echo '<script> alert("A user has now been added"); </script>';

	} else if(mysqli_num_rows($res) > 0) {
		echo '<script> alert("Inserted username is already taken"); window.location="/register_account.php" </script>';	/* print out that username is already taken*/
	}

?>
    </body>
</html>
