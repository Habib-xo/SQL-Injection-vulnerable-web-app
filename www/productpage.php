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
    <title>Estore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
$product = $_GET['productId'] ?? 1; #query parameter
$sql = "SELECT * FROM products WHERE product_id=$product"; #vulnerable line payload => OR 1=1
$res = $conn->query($sql);

if (!$res) {
    echo "<center><p style='color:red;'>Database Error: " . $conn->error . "</p></center>";
} else {
    while ($row = $res->fetch_assoc()) {
?>
    <center>
    <div class="product">   
            <img src="<?= $row['image'] ?>" width="150" height="150" alt="">
            <p class="p-name"><?= $row['name'] ?></p>
            <p class="p-price">$<?= $row['price'] ?></p>   
        </form>
    </div>
    </center>
<?}
};

?>
</body>
</html>