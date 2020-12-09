<?php
    session_start();
    session_destroy();
    header("location:login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Espere</title>
</head>
<body>
    <div align="center" style="margin-top: 10%;">
        <img src="../img/cargando.gif" alt="Cargando"><br>
    </div>
</body>
</html>