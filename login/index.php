<?php
require_once('../connect.php');

function login($conn) {
    setcookie('token', "", 0, "/");
    $username = $_POST['username'];
    $password = sha1($_POST['password']);
    $sql = 'SELECT * FROM users WHERE username = ? AND password = ?';
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array($username, $password))) {
        $valid = false;
        while ($row = $stmt->fetch()) {
            $valid = true;
            $token = generateToken();
            $sql = 'UPDATE users SET token = ? WHERE username = ?';
            $stmt1 = $conn->prepare($sql);
            if ($stmt1->execute(array($token, $username))) {
                echo 'Login Successful';
            }
        }
        if(!$valid) {
            echo 'Username or Password Incorrect';
        }
    }
}

function generateToken() {
    $date = date(DATE_RFC2822);
    $rand = rand();
    return sha1($date.$rand);
}

if(isset($_POST['login'])) {
    login($dbh);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<div>
    <a href="/SimpleCart">Home</a>
    <a href="/SimpleCart/login">Login</a>
    <a href="/SimpleCart/register">Register</a>
    <a href="/SimpleCart/cart">Cart</a>
</div><br><br>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Username"/>
        <input type="password" name="password" placeholder="Password"/>
        <input type="submit" name="login" value="LOGIN"/>
    </form>
</body>
</html>
