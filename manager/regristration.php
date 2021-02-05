<?php 
session_start();
$database = include('config/config.php');
$host = $database['host'];
$dbname = $database['dbname'];
$user = $database['user'];
$password = $database['password'];
$pdo = new PDO("mysql:host={$host};dbname={$dbname}", $user, $password);

 
if(isset($_GET['register'])) {
    $error = false;
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
      
    if(strlen($password) == 0) {
        $errorMessage = 'Bitte ein Passwort angeben';
        $error = true;
    }
    if($password != $password2) {
        $infoMessage = 'Die Passwörter müssen übereinstimmen';
        $error = true;
    }
    
    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) { 
        $statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $result = $statement->execute(array('username' => $username));
        $user = $statement->fetch();
        
        if($user !== false) {
            $errorMessage = 'Dieser Benutzername ist bereits vergeben';
            $error = true;
        }    
    }
    
    //Keine Fehler, wir können den Nutzer registrieren
    if(!$error) {    
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        $statement = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $result = $statement->execute(array('username' => $username, 'password' => $password_hash));
        
        if($result) {        
            $infoMessage = 'Du wurdest erfolgreich registriert.';
        } else {
            $errorMessage = 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    } 
}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regristration</title>
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
</head>
<body>
<div class="login-dark" style="width: 100vw; height: 100vh;">
    <form id="menu" action="?register=1" method="post">
    <div class="form-group"><h1>Regristration</h1></div>
        <div class="form-group"><input type="username" class="form-control" name="username" placeholder="Username" /></div>
        <div class="form-group"><input type="password" class="form-control" name="password" placeholder="Password" /></div>
        <div class="form-group"><input type="password" class="form-control" name="password2" placeholder="Repeat Password" /></div>
        <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Register</button></div>
        <div class="info">    
            <?php if (isset($infoMessage)) {
        echo $infoMessage;
    }
    ?> </div>
            <div class="error">    
            <?php if (isset($errorMessage)) {
        echo $errorMessage;
    }
    ?>
        </div>
        </div>
    </form>
</div>
</body>
</html>

 
</body>
</html>