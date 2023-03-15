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
    $sql = "SELECT * FROM employee WHERE u_id='$u_id' AND is_manager=1";

    $res = $conn->query($sql);

    if(mysqli_num_rows($res) != 0){
        // If logged in as manager

?>
                        <li><a href="restock_page.php"><span class="glyphicon glyphicon-list-alt"></span> Manage products</a></li>
                        <li class="active"><a href="manager_page.php">Manage employees <span class="sr-only">(current)</a></li>
<?php
    } else { die("Not logged in as manager!"); }
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
        <div class="container" style="padding-top:50px;">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post">
<?php
	$user="admin";
	$password="1234";
	$database="stonebase";
	$server="localhost";

	$conn = new mysqli($server, $user, $password, $database);
	if($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}

    $sql = "SELECT user.f_name, user.l_name, employee.u_id, employee.salery
            FROM employee
            INNER JOIN user ON employee.u_id=user.u_id";

	$result = $conn->query($sql);

    $salary_id = array();
    $salary = array();

        echo '<table class="table table-bordered table-responsive table-hover table-cursor" cellpadding="0">';
	while($row = $result->fetch_assoc()) {
        array_push($salary_id, $row['u_id']);
        array_push($salary, $row['salery']);
        echo '<tr>
                <td><h3>' . $row['f_name'] . ' ' . $row['l_name'] .'</h3></td>
                <td><div class="form-group">
                    <h3>Salary:</h3>
                    <input type="number" name="salery_'.$row['u_id'].'" class="form-control" placeholder="'.$row['salery'].'">
                </div></td>
            </tr>';
	};
echo '<tr><td><button type="submit" class="btn btn-primary btn-lg" >Submit Changes</button></td></tr></table>';

?>

<!-- Update salary placeholder -->
<script>

function updatePlacholder(id, val){
    console.log(id);
    console.log(val);
    document.getElementsByName(id)[0].placeholder=val;
}

</script>
                    </form>
                </div>
            </div>
        </div>
<!-- Update salary in db -->

<?php
    // Get number of employees
    $emp_count = count($salary_id);

    // For each employee, check if salary is updated
    for($i = 0; $i < $emp_count; $i++) {
        $inp_field = 'salery_'.$salary_id[$i];
        if($_POST[$inp_field] != $salary[$i] &&
            $_POST[$inp_field] != "" &&
            $_POST[$inp_field] > 0) {
            // Update the salary for employee
            $sql = "UPDATE employee SET salery = ".$_POST[$inp_field]." WHERE u_id = ".$salary_id[$i];
            echo $salary_id[$i];
        $res = $conn->query($sql);
        $new = $_POST[$inp_field];
        echo "<script>updatePlacholder('$inp_field', $new)</script>";
        }
    }
?>
    </body>
</html>

