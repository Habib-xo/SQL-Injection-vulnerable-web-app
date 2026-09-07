<?php 
include "db.php";
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if (($_SERVER['REQUEST_METHOD']  === 'POST') && (isset($email) && isset($password))) {
    
    $sql = "SELECT email,password FROM users where email='$email' and password='$password';"; #vulnerable code payload => anything@gmail.com' OR 1=1 #
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            session_start();
            $_SESSION['email'] = $email;
            header("Location: check.php");
            exit;
        }
    } else {
        echo "Invalid email / password";
    }

    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <center><h1>Welcome to my Store</h1> <br> <hr>
    <p>Please sign in with your credentials</p>
    
        <form action="?" method="POST">
            <input type="text" name="email" placeholder="email"> <br> <br>
            <input type="password" name="password" placeholder="password"> <br> <br>
            <button type="submit">Login</button>
        </form>
        
    </center>
</body>
</html>