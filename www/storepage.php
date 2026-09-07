<?php 
session_start();
include "db.php";
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <a href="logout.php">Log out</a>
    <center>
        <h1>Welcome to my store <?= $_SESSION['email'] ?></h1> <hr>
        <div class="products-grid">
        <?php
        $sql = 'SELECT * FROM products;';
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
            
            <div class="product">
                <form action="productpage.php" id="myForm" method="get">
                    <img src="<?= $row['image'] ?>" width="150" height="150" alt="<?= $row['name'] ?>">
                    <p class="p-name"><?= $row['name'] ?></p>
                    <p class="p-price">$<?= $row['price'] ?></p>
                    <input type="hidden" name="productId" value="<?= $row['product_id'] ?>">
                    <button type="submit">Show details</button>
                </form>
            </div>
            
        <?php
            }
        }
        ?>
        </div>


        

    </center>
</body>
</html>