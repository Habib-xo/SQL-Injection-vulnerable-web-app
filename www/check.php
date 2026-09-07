<?php 
session_start();

if (isset($_SESSION['email'])){
    header("Location: storepage.php");
    exit;
} else {
    header("Location: login.php");
    exit;
}

?>