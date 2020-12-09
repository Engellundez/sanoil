<?php
    include("../conexion/conexion.php");
    $email = $_REQUEST['correo'];
    $password = $_REQUEST['password'];
    $pass = hash('whirlpool', $password);

    // echo "$password $email";

    $busqueda = "SELECT * FROM usuarios WHERE correo = '$email' AND password = '$pass' ";
    $respuesta_verificada = mysqli_query($conexion, $busqueda);

    // echo "$busqueda";
    // exit;
        
    while($log_usuario = mysqli_fetch_array($respuesta_verificada)){
        if($log_usuario['mostrar'] == '0'){
            header("location: ../registros/login.php?e=despedido");
            die();
        }else{
            session_start();
            $_SESSION['id']         = $log_usuario['id'];
            $_SESSION['usuario']    = $log_usuario['nombre']." ".$log_usuario['apellido_p']." ".$log_usuario['apellido_m'];
            $_SESSION['email']      = $log_usuario['correo'];
            $_SESSION['password']   = $log_usuario['password'];
            
            header("location: ../vistas/inicio.php");
            die();
        }
    }
    header("refresh: 1; login.php?e=error");
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