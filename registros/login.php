<?php
    error_reporting(0);
    session_start();
    $variable = $_SESSION['usuario'];

    if($variable != null || $variable != ''){
        header("location:../vistas/inicio.php");
        die();
    }

    $e = "nada";
    if(!empty($_GET)){
        $e = $_GET['e'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Iniciar Sesión</title>
    <!-- PLANTILLAS -->
    <?php
        include ("../plantillas/plantillasl.php");
    ?>
    <!-- CSS -->
    <link rel="stylesheet" href="../css/log.css">
</head>

<body>
    <div align="center" class="container">
        <div align="center" class="login">
        <br><br><br><br><br>
            <!-- <img src="../img/img1.jpg" width="130px" class="my-4"> -->
            <input type="hidden" name="e" id="e" value="<?php echo $e ?>">
            <form action="revicion.php" method="POST">
                <label><img src="../img/logs/correo.png" width="30px" alt="Correo"></label>
                <input type="text" required name="correo" placeholder="Correo"><br><br>

                <label><img src="../img/logs/candado.png" width="30px" alt="Contraseña"></label>
                <input type="password" required name="password" placeholder="Contraseña"><br><br>

                <div class="container">
                    <input class="btn btn-primary block" type="submit" value="Iniciar Sesión">
                </div>
            </form>
            
        </div>
    </div>
    <!-- scripts del documento -->
    <script src="../js/registro.js"></script>

    <!-- scripts -->
    <script src="../js/fecha.js"></script>
    <script src="../js/sidebar.js"></script>

    <!-- scripts Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- footer -->
    <?php include("../plantillas/footer.php"); ?>
</body>
</html>