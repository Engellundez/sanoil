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
    <title>Mezcal | Agregar Nuevo Cliente</title>
</head>

<body>
    <?php include ("../plantillas/sidebar.php"); ?>
    <?php include ("../plantillas/encabezado.php"); ?>
    <div class="contenido">
    
        <div class="container separacion">
            <h3>Registrar un Nuevo Cliente</h3>
            <form action="" method="post" id="registrar_nuevo_cliente">
            <input type="hidden" name="action" value="agregar nuevo cliente">
            <!-- ../consultas/regclientenuevo.php -->
                <div class="row my-5">
                    <div class="col">
                        <span class="span">*</span><label>Nombre</label>
                        <input class="form-control centrar" required type="text" name="nombre" value="" placeholder="Nombre de Cliente">
                    </div>
                    <div class="col">
                        <span class="span">*</span><label>Apellido Paterno</label>
                        <input class="form-control centrar" required type="text" name="apellido_p" value="" placeholder="Apellido Paterno de Cliente">
                    </div>
                    <div class="col">
                        <span class="span">*</span><label>Apellido Materno</label>
                        <input class="form-control centrar" required type="text" name="apellido_m" value="" placeholder="Apellido Materno de Cliente">
                    </div>
                </div>
                <div class="row my-5">
                    <div class="col">
                        <label>Dirección</label>
                        <input class="form-control centrar" required type="text" name="direccion" value="" placeholder="Dirección del Cliente">
                    </div>
                    <div class="col">
                        <label>Número de Teléfono</label>
                        <input class="form-control centrar" required type="text" name="telefono" value="" placeholder="Número Teléfonico del Cliente" onkeypress="return solonumeros(event)" maxlength="10" minlenght="10">
                    </div>
                    <div class="col">
                        <span class="span">*</span><label>Correo</label>
                        <input class="form-control centrar" required type="email" name="correo" value="" placeholder="Dirección del Correo Electronico">
                    </div>
                </div>
                <div class="row my-5">
                    <div class="col">
                        <label>Negocio</label>
                        <input class="form-control centrar" type="text" name="negocio" value="" placeholder="Negocio del Cliente">
                    </div>
                    <div class="col">
                        <span class="span">*</span><label>Factura</label><br>
                        <label for="facturasi">Si</label>
                        <input class="margenizquierdo" required type="radio" name="factura" id="facturasi" value="1">
                        <label for="facturano"> No</label>
                        <input class="margenizquierdo" required type="radio" checked name="factura" id="facturano" value="0">
                    </div>
                    <div class="col">
                        <span class="span">*</span><label>Tipo de cliente</label>
                        <select class="form-control centrar" required name="tipo_id" id="tipo_id">
                            <option value="">Escoge una Opción</option>
                            <?php 
                                $rescomi = mysqli_query($conexion, "SELECT * FROM tipo");
                                while($rowcomi = mysqli_fetch_array($rescomi)){
                                    ?>
                                <option value="<?php echo $rowcomi['id']; ?>"><?php echo $rowcomi['tipo_cliente']." con ".$rowcomi['descuento']."% de descuento"; ?></option>
                            <?php 
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row my-5">
                    <div class="col"></div>
                    <div class="col">
                        <input class="btn btn-success btn-large" id="registrar_cliente" type="submit" value="Registrar Nuevo Cliente">
                    </div>
                    <div class="col"></div>
                </div>
            </form>
        </div>

    </div>
    <!-- scripts del Documento -->
    <script src="../js/nuevoCliente.js"></script>

    <!-- scripts -->
    <script src="../js/fecha.js"></script>
    <script src="../js/sidebar.js"></script>

    <!-- scripts Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- footer -->
    <?php include("../plantillas/footer.php"); ?>
</body>
</html>