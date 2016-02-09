<?php
require_once('../connect.php');

function addProduct($conn, $id) {
    $token = getToken();
    $sql = 'INSERT INTO orders_products (orders_id, products_id) (SELECT o.id, ? FROM users u LEFT JOIN orders o ON u.id = o.users_id AND o.status = "new" WHERE u.token = ?)';
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array($id, $token))) {

    }
}

function deleteProduct($conn, $id) {
    $token = getToken();
    $sql = 'DELETE op FROM users u LEFT JOIN orders o ON u.id = o.users_id AND o.status = "new" LEFT JOIN orders_products op ON o.id = op.orders_id WHERE u.token = ? AND op.id = ?';
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array($token, $id))) {

    }
}

function getProducts($conn) {
    $token = getToken();
    $sql = 'SELECT p.name, p.price, p.preview, op.id FROM users u LEFT JOIN orders o ON u.id = o.users_id AND o.status = "new" LEFT JOIN orders_products op ON o.id = op.orders_id LEFT JOIN products p ON op.products_id = p.id WHERE u.token = ?';
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array($token))) {
        while ($row = $stmt->fetch()) {
            if ($row['id'] != null) {
                echo '<div>
                    Name: '.$row['name'].'<br>
                    Price: $'.$row['price'].'<br>
                    <form method="post" action="/SimpleCart/cart/">
                        <input type="hidden" name="id" value="'.$row['id'].'"/>
                        <input type="submit" name="delete" value="DELETE"/>
                    </form>
                    </div>';
            }
        }
    }
}

function getToken() {
    if (isset($_COOKIE['token'])) {
        return $_COOKIE['token'];
    }
    else {
        header('location:/SimpleCart/login/');
    }
}

if(isset($_POST['add'])) {
    $id = $_POST['id'];
    addProduct($dbh, $id);
}

if(isset($_POST['delete'])) {
    $id = $_POST['id'];
    deleteProduct($dbh, $id);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
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
        getProducts($dbh);
    ?>
</div>
</body>
</html>
