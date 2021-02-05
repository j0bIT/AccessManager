<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
</head>
<body>
<div class="login-dark" style="width: 100vw; height: 100vh;">
    <div class="menu">
    <div class="form-group"><h1><?php
    echo "Logout erfolgreich";
    ?></h1></div>

<div class="form-group"><a href="login.php"><button class="btn btn-primary btn-block">Login</button></a></div>
    </div>
</div>
</body>
</html>

