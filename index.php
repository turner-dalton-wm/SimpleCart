<?php
require_once('connect.php');

function getProducts($conn) {
    $sql = 'SELECT * FROM products ORDER BY name';
    $stmt = $conn->prepare($sql);
    if ($stmt->execute()) {
        while ($row = $stmt->fetch()) {
            echo '<div>
                    Name: '.$row['name'].'<br>
                    Price: $'.$row['price'].'<br>
                    <form method="post" action="/SimpleCart/cart/">
                        <input type="hidden" name="id" value="'.$row['id'].'"/>
                        <input type="submit" name="add" value="ADD"/>
                    </form>
                    </div>';
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
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
