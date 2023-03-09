<?php
    //From stackoverflow.com/question/1280767/how-do-i-run-php-code-when-a-user-click-on-a-link
    session_start();
    $_SESSION = array();
    session_destroy();
    $page = "index.php";
    if(isset($_GET["redirect_to"])){
        $file = $_GET["redirect_to"];
    }
    header("Location: $file");
?>
