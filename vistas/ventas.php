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
    <title>Sanoil | Ventas</title>
</head>

<body>
    <?php include ("../plantillas/sidebar.php"); ?>
    <?php include ("../plantillas/encabezado.php"); ?>
    <div class="contenido">
        <div class="container separacion">
            <table class="table table-dark">
                <thead style="text-align: center;">
                    <tr>
                        <th scope="col">Folio de venta</th>
                        <th scope="col">Productos</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Total Unitaria</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Descuento</th>
                        <th scope="col">Total</th>
                        <th scope="col">Factura</th>
                        <th scope="col" rowspan="3">Opciones</th>
                    </tr>
                </thead>
                <tbody align="center">
                    <?php 
                        $query_ventas_paginado = mysqli_query($conexion, "SELECT * FROM ventas");
                        $filas = mysqli_num_rows($query_ventas_paginado);
                        $numeroFilas = 5;
                        $conteo = $filas/$numeroFilas;
                        $paginas = ceil($conteo);

                        if($page > $paginas){
                            $page=$paginas;
                        }elseif($page < 1){
                            $page = 1;
                        }elseif($page > 1){
                            $page = $_GET['page'];
                        }else{
                            $page = 1;
                        }

                        $inicio = ($page - 1) * $numeroFilas;

                        $query_venta = mysqli_query($conexion, "SELECT * FROM ventas ORDER BY id DESC LIMIT $inicio,$numeroFilas");

                        if($query_venta != NULL){
                            while($row_venta = mysqli_fetch_array($query_venta)){
                    ?>
                    <tr>
                        <th scope="row" style='color:red'><?php echo $row_venta['id']; ?></th>
                        <td>
                            <ul>
                                <?php
                                    $query_venta_cuanta = mysqli_query($conexion, "SELECT * FROM producto_venta WHERE codigo_venta = '".$row_venta['codigo_venta']."'");
                                    while($row_venta_cuenta = mysqli_fetch_array($query_venta_cuanta)){
                                        $query_producto = mysqli_query($conexion, "SELECT * FROM productos WHERE id = '".$row_venta_cuenta['producto_id']."'");
                                        while($row_producto = mysqli_fetch_array($query_producto)){
                                            echo "<li>".$row_producto['nombre_producto']."</li>";
                                        }
                                    }
                                ?>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <?php
                                    $query_venta_cantidad = mysqli_query($conexion, "SELECT * FROM producto_venta WHERE codigo_venta = '".$row_venta['codigo_venta']."'");
                                    while($row_producto_cantidad = mysqli_fetch_array($query_venta_cantidad)){
                                        echo "<li>".$row_producto_cantidad['cantidad']."</li>";
                                    }
                                ?>
                            </ul>
                        </td>
                        <td style="color: #2AB827">
                            <ul>
                                <?php
                                    $query_venta_precio = mysqli_query($conexion, "SELECT * FROM producto_venta WHERE codigo_venta = '".$row_venta['codigo_venta']."'");
                                    while($row_venta_precio = mysqli_fetch_array($query_venta_precio)){
                                        $query_producto_precio = mysqli_query($conexion, "SELECT * FROM productos WHERE id = '".$row_venta_precio['producto_id']."'");
                                        while($row_producto_precio = mysqli_fetch_array($query_producto_precio)){
                                            echo "<li>$".$row_producto_precio['precio']."</li>";
                                        }
                                    }
                                ?>
                            </ul>
                        </td>
                        <td style="color: #2AB827">
                            <ul>
                                <?php
                                    $query_subtotal = mysqli_query($conexion, "SELECT * FROM producto_venta WHERE codigo_venta = '".$row_venta['codigo_venta']."'");
                                    while($row_subtotal = mysqli_fetch_array($query_subtotal)){
                                        echo "<li>$".$row_subtotal['precio_total']."</li>";
                                    }
                                ?>
                            </ul>
                        </td>
                        <td style="color: #2AB827">$<?php echo $row_venta['total_venta']; ?></td>
                        <td>
                            <?php
                                if($row_venta['factura'] == 0){
                                    echo "No ocupa Factura";
                                }else{
                                    echo "Si Ocupa Factura";
                                }
                            ?>
                        </td>
                        <?php
                            $query_factura = mysqli_query($conexion, "SELECT id FROM facturacion WHERE cliente_id = '".$row_venta['cliente_id']."'");
                            $row_factura = mysqli_fetch_array($query_factura);
                            if($row_factura == NULL){
                        ?>
                        <td>
                            <?php
                            $id_cliente = $row_venta['cliente_id'];
                            $query_nombre = mysqli_query($conexion, "SELECT nombre FROM clientes WHERE id = '$id_cliente'");
                            $nombre_cliente = mysqli_fetch_assoc($query_nombre);
                            ?>
                            <button href="#" class="btn btn-warning btn-sm registrar_factura" id_cliente="<?php echo $id_cliente; ?>" nombre_cliente="<?php echo $nombre_cliente['nombre'].' '.$nombre_cliente['apellido_p'].' '.$nombre_cliente['apellido_m']; ?>">Registar factura</button>
                        </td>
                        <?php
                            } else {
                        ?>
                        <td>
                            <button class="btn btn-success btn-sm revisar_factura" id_cliente="<?php echo $row_venta['cliente_id']; ?>">Ver factura</button>
                        </td>
                        <?php
                            }
                        ?>
                        <td>
                            <a href="detalles.php?id=<?php echo $row_venta['id']; ?>" class="btn btn-primary btn-sm">Detalles</a>
                        </td>
                        <!-- <td>
                            <a href="../PDFs/factura.php?id=<?php echo $row_venta['id']; ?>&indicador=<?php echo $row_venta['codigo_venta']; ?>" target="_blank"><button class="btn btn-primary btn-sm">Ver Recibo</button></a>
                        </td> -->
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
                        <a class="page-link disabled" href="ventas.php?page=<?php echo $page-1; ?>">
                            Anterior
                        </a>
                    </li>
                    <?php for($i=0; $i<$paginas; $i++){ ?>
                    <li class="page-item <?php if($page == ($i+1)){ echo 'active'; } ?>">
                        <a class="page-link" href="ventas.php?page=<?php echo $i+1; ?>">
                            <?php echo $i+1; ?>
                        </a>
                    </li>
                    <?php } ?>
                    <li class="page-item <?php echo $page>=$paginas ? 'disabled' : '' ?>">
                        <a class="page-link" href="ventas.php?page=<?php echo $page+1; ?>">
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