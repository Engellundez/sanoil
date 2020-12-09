<?php
    session_start();
    $id = $_SESSION['id'];
    $user = $_SESSION['usuario'];
    $correo = $_SESSION['email'];
    $variable = $_SESSION['usuario'];

    if($variable == null || $variable = ''){
        header("location:../registros/login.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cambiar Nombre</title>
    <?php include('../plantillas/plantilla.php'); ?>
    <link rel="stylesheet" href="../css/global.css">
</head>
<body>
    <?php include('../plantillas/encabezado.php'); ?>
    <div class="container separacion">
        
    </div>
</html>