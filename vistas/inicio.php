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
    <title>Mezcal | Inicio</title>
</head>

<body>
    <?php include ("../plantillas/sidebar.php"); ?>
    <?php include ("../plantillas/encabezado.php"); ?>
    <div class="contenido">

        <div class="container separacion">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card text-black">
                        <div class="card bg-primary bg-primary text-white py-2 card-heading">
                            Graficas
                        </div>
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div id="graficaLineal"></div>
                                </div>
                                <div class="col-sm-6">
                                    <div id="graficaBarras"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <!-- scripts del Documento -->
    <script src="../js/inicio.js"></script>
    <!-- scripts -->
    <script src="../js/fecha.js"></script>
    <script src="../js/sidebar.js"></script>

    <!-- scripts Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- footer -->
    <?php include("../plantillas/footer.php"); ?>
</body>
</html>