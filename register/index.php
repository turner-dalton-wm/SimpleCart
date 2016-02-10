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
            setcookie('token', $token, 0, "/");
            $sql = 'INSERT INTO orders (users_id, status) (SELECT u.id, "new" FROM users u WHERE u.token = ?)';
            $stmt1 = $conn->prepare($sql);
            if ($stmt1->execute(array($token))) {
                echo 'Account Registered';
            }
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

?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
<div>
    <a href="/SimpleCart">Home</a>
    <a href="/SimpleCart/login">Login</a>
    <a href="/SimpleCart/register">Register</a>
    <a href="/SimpleCart/cart">Cart</a>
</div><br><br>
<?php
    if(isset($_POST['register'])) {
        register($dbh);
    }
?>
<form method="post" action="">
    <input type="text" name="username" placeholder="Username"/>
    <input type="password" name="password" placeholder="Password"/>
    <input type="text" name="email" placeholder="Email"/>
    <input type="submit" name="register" value="REGISTER"/>
</form>
</body>
</html>
