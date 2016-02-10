<?php
require_once('../connect.php');

function retireOrder($conn) {
    $token = getToken();
    $sql = 'UPDATE users u LEFT JOIN orders o ON u.id = o.users_id AND o.status = "new" SET o.status = "old" WHERE u.token = ?';
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array($token))) {

    }
}

function createNewOrder($conn) {
    $token = getToken();
    $sql = 'INSERT INTO orders (users_id, status) (SELECT u.id, "new" FROM users u WHERE u.token = ?)';
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array($token))) {

    }
}

function checkout($conn) {
    retireOrder($conn);
    createNewOrder($conn);
    echo 'Checkout Successful';
}

function getToken() {
    if (isset($_COOKIE['token'])) {
        return $_COOKIE['token'];
    }
    else {
        header('location:/SimpleCart/login/');
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>
<div>
    <a href="/SimpleCart">Home</a>
    <a href="/SimpleCart/login">Login</a>
    <a href="/SimpleCart/register">Register</a>
    <a href="/SimpleCart/cart">Cart</a>
</div><br><br>
<div>
    <?php
        if(isset($_POST['checkout'])) {
            checkout($dbh);
        }
    ?>
</div>
</body>
</html>