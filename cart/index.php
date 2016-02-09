<?php
require_once('../connect.php');

function addProduct($conn, $id) {
    $token = getToken();
    $sql = 'INSERT INTO orders_products (orders_id, products_id) (SELECT o.id, ? FROM users u LEFT JOIN orders o ON u.id = o.users_id AND o.status = "new" WHERE u.token = ?)';
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array($id, $token))) {
        echo 'Product Added To Cart';
    }
}

function deleteProduct($conn, $id) {
    $token = getToken();
    $sql = 'DELETE op FROM users u LEFT JOIN orders o ON u.id = o.users_id AND o.status = "new" LEFT JOIN orders_products op ON o.id = op.orders_id WHERE u.token = ? AND op.id = ?';
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array($token, $id))) {
        echo 'Product Removed From Cart';
    }
}

function getToken() {
    if (isset($_COOKIE['token'])) {
        return $_COOKIE['token'];
    }
    else {
        header('location:/login/');
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
    <title>Login</title>
</head>
<body>

</body>
</html>
