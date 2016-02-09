<?php
require_once('../connect.php');

function register($conn) {
    $username = $_POST['username'];
    $password = sha1($_POST['password']);
    $email = $_POST['email'];
    $token = generateToken();

    $sql = 'INSERT INTO users (username, password, email, token) VALUES (?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    try {
        if ($stmt->execute(array($username, $password, $email, $token))) {
            echo 'Account Registered';
        }
    }
    catch (PDOException $e) {
        echo 'Username or Email Already Registered';
    }
}

function generateToken() {
    $date = date(DATE_RFC2822);
    $rand = rand();
    return sha1($date.$rand);
}

if(isset($_POST['register'])) {
    register($dbh);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
<form method="post" action="">
    <input type="text" name="username" placeholder="Username"/>
    <input type="password" name="password" placeholder="Password"/>
    <input type="text" name="email" placeholder="Email"/>
    <input type="submit" name="register" value="Register"/>
</form>
</body>
</html>
