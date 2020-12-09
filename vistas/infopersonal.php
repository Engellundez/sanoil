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
    <title>Sanoil | Información Personal</title>
    <?php include ("../plantillas/head.php"); ?>
</head>

<body>
    <?php include ("../plantillas/sidebar.php"); ?>
    <?php include ("../plantillas/encabezado.php"); ?>
    <div class="contenido">
        <div class="container separacion peque">
        <?php
            include("../conexion/conexion.php");
            $resuser = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id = ".$id);
            $rowuser = mysqli_fetch_array($resuser);
        ?>
            <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Nombre</span>
                </div>
                <input type="text" readonly class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="<?php echo $rowuser['nombre']." ".$rowuser['apellido_p']." ".$rowuser['apellido_m'] ?>">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Para Cambiar hable con un Administrador</span>
                </div>
            </div>
            <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Correo</span>
                </div>
                <input type="text" readonly class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="<?php echo $rowuser['correo'] ?>">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Para Cambiar hable con un Administrador</span>
                </div>
            </div>
            <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Contraseña</span>
                </div>
                <input type="password" readonly class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="************">
                <div class="input-group-prepend">
                    <button class="btn btn-warning cambiar_contrasena" id="inputGroup-sizing-sm"><img src="../img/icons/editar.png" class="icon">Cambiar Contraseña</button>
                </div>
            </div>
        </div>
    </div>
    <!-- scripts del Documento -->
    <script src="../js/infopersonal.js"></script>

    <!-- scripts -->
    <script src="../js/fecha.js"></script>
    <script src="../js/sidebar.js"></script>

    <!-- scripts Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- footer -->
    <?php include("../plantillas/footer.php"); ?>
</body>
</html>