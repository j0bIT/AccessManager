<?php

if (session_status() === 1) {
    session_start();

    $database = include('config/config.php');
    $host = $database['host'];
    $dbname = $database['dbname'];
    $user = $database['user'];
    $password = $database['password'];
    $pdo = new PDO("mysql:host={$host};dbname={$dbname}", $user, $password);
}


if (isset($_GET['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $result = $statement->execute(array('username' => $username));
        $user = $statement->fetch();
    
        //check password
        if ($user !== false && password_verify($password, $user['password'])) {
            $_SESSION['userid'] = $user['id'];
            header("Location: ../manager");
        } else {
            $errorMessage = "Benutzername oder Passwort war ungültig!";
        }



}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
</head>

<body>



    <div class="login-dark" style="width: 100vw; height: 100vh;">
    <form id="menu" action="?login=1" method="post">
    <div class="form-group"><h1>Login</h1></div>
        <div class="form-group"><input type="username" class="form-control" name="username" placeholder="Username" /></div>
        <div class="form-group"><input type="password" class="form-control" name="password" placeholder="Password" /></div>
        <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Log In</button></div>
        <div class="error">    
            <?php if (isset($errorMessage)) {
        echo $errorMessage;
    }
    ?>
        </div>
    </form>
</div>


    </form>
</body>

</html>