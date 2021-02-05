<?php

if (session_status() === 1) {
    session_start();
}
if(!isset($_SESSION['userid'])) {
    $database = include('config/config.php');
    $host = $database['host'];
    $dbname = $database['dbname'];
    $user = $database['user'];
    $password = $database['password'];
    $pdo = new PDO("mysql:host={$host};dbname={$dbname}", $user, $password);

    $statement = $pdo->query("SELECT * FROM timet WHERE id = 1");
    $result = $statement->fetch();
    
    if(!$result) {
        header("Location: manager/login.php");
        //die(include 'login.php');
    }
    
    if($result) {
        $milliseconds = round(microtime(true) * 1000);
        if(!($result['ms'] >= $milliseconds)){
            header("Location: manager/login.php");
        }
    }

}
?>