<?php
$servername = "mysql";
$username = "root";
$password = "supersecretpassword";
$dbname = "bobDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}



?>