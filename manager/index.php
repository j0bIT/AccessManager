<?php
if (session_status() === 1) {
    session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}
$database = include('config/config.php');
$host = $database['host'];
$dbname = $database['dbname'];
$user = $database['user'];
$password = $database['password'];
$pdo = new PDO("mysql:host={$host};dbname={$dbname}", $user, $password);
}


if (isset($_GET['manage'])) {
    $minutes = $_POST['minutes'];
    $hours = $_POST['hours'];
    $days = $_POST['days'];

    $milliseconds = round(microtime(true) * 1000);
    if(is_numeric($minutes)){
        $milliseconds +=  $minutes * 60000;
    }else{$minutes = 0;}
    if(is_numeric($hours)){
        $milliseconds +=  $hours * 3600000;
    }else{$hours = 0;}
    if(is_numeric($days)){
        $milliseconds +=  $days * 86400000;
    }else{$days = 0;}


    $result = $pdo->query("UPDATE timet SET ms={$milliseconds} WHERE id=1");

    if ($result) {
        $infoMessage = "Für die nächsten {$minutes} Tage, {$hours} Stunden, {$days} Minuten Minuten haben alle Nutzer auf deine Webseite zugriff! ";
    } else {
        $errorMessage = "Es ist ein Fehler aufgetreten";
    }
}

$statement = $pdo->query("SELECT * FROM timet WHERE id = 1");
$result = $statement->fetch();

if ($result) {
    $remaining = $result['ms'] -  round(microtime(true) * 1000);
    if ($remaining < 0) {
        $infoMessage = "Keine aktuelle Freigabe";
    } else {

        $d = floor($remaining / 86400000);
        $h = floor(($remaining - $d * 86400000) / 3600000);
        $m = round(($remaining -  $d * 86400000 - $h * 3600000)/ 60000);
        

        $infoMessage = "Noch {$d} Tage, {$h} Stunden, {$m} Minuten freigegeben";
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AccessManager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
</head>

<body>

    <?php
    if (isset($errorMessage)) {
        echo $errorMessage;
    }
    ?>

<div class="login-dark" style="width: 100vw; height: 100vh;">
    <form id="menu" action="?manage=1" method="post">
    <div class="form-group"><h1>Manager</h1></div>
        <div class="form-group"><input type="number" class="form-control" name="minutes" placeholder="Minuten" /></div>
        <div class="form-group"><input type="number" class="form-control" name="hours" placeholder="Stunden" /></div>
        <div class="form-group"><input type="number" class="form-control" name="days" placeholder="Tage" /></div>
        <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Festlegen</button></div>
        <div class="error">    
            <?php if (isset($errorMessage)) {
        echo $errorMessage;
    }
    ?> </div>
            <div class="info">    
            <?php if (isset($infoMessage)) {
        echo $infoMessage;
    }
    ?> </div>

    </form>

    <div class="menu">
    <div class="form-group"><a href="../"><button class="btn btn-primary btn-block">Interner Bereich</button></a></div>
        <div class="form-group"><a href="logout.php"><button class="btn btn-primary btn-block">Logout</button></a></div>

    </div>
</div>



</body>

</html>



