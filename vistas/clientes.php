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
    $page = 1;
    if(!empty($_GET)){
        $page = $_GET['page'];
    }
?>
<!doctype html>
<html>

<head>
    <?php include ("../plantillas/head.php"); ?>
    <title>Sanoil | Clientes</title>
</head>

<body>
    <?php include ("../plantillas/sidebar.php"); ?>
    <?php include ("../plantillas/encabezado.php"); ?>
    <div class="contenido">

        <div class="container separacion">
            <table class="table table-striped table-dark">
                <thead align="center">
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Negocio</th>
                        <th scope="col">Factura</th>
                        <th scope="col">Tipo de Cliente</th>
                        <th scope="col">Editar</th>
                    </tr>
                </thead>
                <tbody align="center">
                    <?php 
                        $paginado = mysqli_query($conexion, "SELECT * FROM so_clientes ORDER BY nombre ASC");
                        $filas = mysqli_num_rows($paginado);
                        $numfilas = 10;
                        $conteo = $filas/$numfilas;
                        $paginas = ceil($conteo);

                        if($page > $paginas){
                            $page = $paginas;
                        }elseif($page < 1){
                            $page = 1;
                        }elseif($page > 1){
                            $page = $_GET['page'];
                        }else{
                            $page = 1;
                        }

                        $inicio = ($page - 1) * $numfilas;

                        $rescliente = mysqli_query($conexion, "SELECT * FROM so_clientes ORDER BY nombre ASC LIMIT $inicio,$numfilas");
                        if($rescliente != NULL){
                            while($rowcliente = mysqli_fetch_array($rescliente)){
                    ?>
                    <tr>
                        <th style="color:black;"><?php echo $rowcliente['nombre']." ".$rowcliente['apellido_p']." ".$rowcliente['apellido_m']; ?></th>
                        <td><?php echo $rowcliente['direccion']=='' ? 'No proporcionada' : $rowcliente['direccion']; ?></td>
                        <td><?php echo $rowcliente['telefono']=='' ? 'No proporcionado' : $rowcliente['telefono']; ?></td>
                        <td><?php echo $rowcliente['correo']; ?></td>
                        <td><?php echo $rowcliente['negocio']=='' ? 'No proporcionado' : $rowcliente['negocio']; ?></td>
                        <?php                
                            $resfactura = mysqli_query($conexion, "SELECT * FROM so_facturacion WHERE cliente_id = ".$rowcliente['id']);
                            $rowfactura = mysqli_fetch_array($resfactura);
                            if($rowfactura == NULL){
                        ?>
                        <td>
                            <button href="#" class="btn btn-warning btn-sm registrar_factura" id_cliente="<?php echo $rowcliente['id']; ?>" nombre_cliente="<?php echo $rowcliente['nombre']." ".$rowcliente['apellido_p']." ".$rowcliente['apellido_m']; ?>">Registar la factura</button>
                        </td>
                        <?php
                            }else{
                        ?>
                        <td>
                            <button class="btn btn-success btn-sm revisar_factura" id_cliente="<?php echo $rowcliente['id']; ?>">Revisar la factura</button>
                        </td>
                        <?php
                            }
                            $tipoclien = "SELECT * FROM so_tipo WHERE id = ".$rowcliente['tipo_id'];
                            $restipoclie = mysqli_query($conexion, $tipoclien);
                            $rowtipoclie = mysqli_fetch_array($restipoclie);
                        ?>
                        <td><?php echo $rowtipoclie['tipo_cliente']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm editar_cliente" id_cliente="<?php echo $rowcliente['id']; ?>"><img src="../img/icons/editar.png" class="icon">Editar</button>
                        </td>
                    </tr>
                    <?php
                            }
                        }
                    ?>
                </tbody>
            </table>

            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item <?php echo $page<=1 ? 'disabled' : '' ?>">
                        <a class="page-link disabled" href="clientes.php?page=<?php echo $page-1; ?>">
                            Anterior
                        </a>
                    </li>
                    <?php for($i=0; $i<$paginas; $i++){ ?>
                    <li class="page-item <?php if($page == ($i+1)){ echo 'active'; } ?>">
                        <a class="page-link" href="clientes.php?page=<?php echo $i+1; ?>">
                            <?php echo $i+1; ?>
                        </a>
                    </li>
                    <?php } ?>
                    <li class="page-item <?php echo $page>=$paginas ? 'disabled' : '' ?>">
                        <a class="page-link" href="clientes.php?page=<?php echo $page+1; ?>">
                            Siguiente
                        </a>
                    </li>
                </ul>
            </nav>

        </div>

    </div>
    <!-- scripts del Documento -->
    <script src="../js/ventas.js"></script>

    <!-- scripts -->
    <script src="../js/fecha.js"></script>
    <script src="../js/sidebar.js"></script>

    <!-- scripts Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- footer -->
    <?php include("../plantillas/footer.php"); ?>
</body>

</html>