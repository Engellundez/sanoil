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

    include ("../conexion/conexion.php");
?>
<!doctype html>
<html>

<head>
    <?php include ("../plantillas/head.php"); ?>
</head>

<body>
    <?php include ("../plantillas/sidebar.php"); ?>
    <?php include ("../plantillas/encabezado.php"); ?>
    <div class="contenido">
    
    

    </div>
    <!-- scripts del Documento -->

    <!-- scripts -->
    <script src="../js/fecha.js"></script>
    <script src="../js/sidebar.js"></script>

    <!-- scripts Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- footer -->
    <?php include("../plantillas/footer.php"); ?>
</body>
</html>