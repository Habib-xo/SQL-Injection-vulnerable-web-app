<?php 
session_start();

if (isset($_SESSION['email'])){
    echo "Welcome to store ".$_SESSION['email'];
} else {
    header("Location: index.php");
    exit;
}

?>