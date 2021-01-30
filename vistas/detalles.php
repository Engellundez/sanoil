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
    <title>Sanoil | Detalles</title>
</head>

<body>
    <?php include ("../plantillas/sidebar.php"); ?>
    <?php include ("../plantillas/encabezado.php"); ?>
    <div class="contenido">
        <div class="container separacion">
            <div style="text-align:center;">
                <?php $id=$_REQUEST['id']; ?>
                <h1>Detalles de la venta con folio de venta <span class="span"><?php echo $id; ?></span></h1>
                <?php
                include("../conexion/conexion.php");
                $resventa = mysqli_query($conexion, "SELECT * FROM so_ventas WHERE id = ".$id);
                $rowventa = mysqli_fetch_array($resventa);
            ?>
                <table class="table table-striped table-dark">
                    <tbody>
                        <tr>
                            <td>
                                Fecha en que se realizó la venta
                            </td>
                            <td>
                                <?php
                            echo $rowventa['fecha'];
                        ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Número de folio
                            </td>
                            <td style="color: red;">
                                <?php
                                echo $rowventa['id'];
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Productos
                            </td>
                            <td>
                                <ul>
                                    <?php
                                    $resventacuenta = mysqli_query($conexion, "SELECT * FROM so_producto_venta where codigo_venta = '".$rowventa['codigo_venta']."'");
                                    while($rowventacuenta = mysqli_fetch_array($resventacuenta)){
                                ?>
                                    <li>
                                        <?php 
                                            $productos = "SELECT * FROM so_productos where id = '".$rowventacuenta['producto_id']."'";
                                            $resproducto = mysqli_query($conexion, $productos);
                                            $rowproducto = mysqli_fetch_array($resproducto);
                                            echo $rowproducto['nombre_producto'].", Codigo: ";
                                        ?>
                                        <p style="color: #1ca2d4; display: inline;">
                                            <?php echo $rowproducto['codigo_producto']; ?>
                                        </p>
                                        <p style="display: inline;">, Precio por Unidad </p>
                                        <p style="display: inline; color: #3ed626;">
                                            <?php echo "$".$rowproducto['precio'] ?>
                                        </p>
                                    </li>
                                    <?php
                                    }
                                ?>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Precio y Cantidad
                            </td>
                            <td>
                                <ul>
                                    <?php
                                    $resventacuenta2 = mysqli_query($conexion, "SELECT * FROM so_producto_venta where codigo_venta = '".$rowventa['codigo_venta']."'");
                                    while($rowventacuenta2 = mysqli_fetch_array($resventacuenta2)){
                                ?>
                                    <li>
                                        <p style="color: #3ed626; display: inline;">
                                            $<?php echo $rowventacuenta2['precio_total']; ?>
                                        </p>
                                        <?php
                                            $productos2 = "SELECT * FROM so_productos where id = '".$rowventacuenta2['producto_id']."'";
                                            $resproducto2 = mysqli_query($conexion, $productos2);
                                            while($rowproducto2 = mysqli_fetch_array($resproducto2)){
                                        ?>
                                        <p style="display: inline;">
                                            <?php echo " cantidad: ".$rowventacuenta2['cantidad']; ?></p>
                                    </li>
                                    <?php
                                        }
                                    }
                                ?>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                TOTAL
                            </td>
                            <?php 
                            if($rowventa['total_venta'] >= 1){
                        ?>
                            <td style="color: #109F0C;">
                                <?php echo "$".$rowventa['total_venta'] ?>
                            </td>
                            <?php
                            }elseif($rowventa['total_venta'] <= -1){
                        ?>
                            <td style="color: red;">
                                <?php echo "$".$rowventa['total_venta'] ?>
                            </td>
                            <?php
                            }elseif($rowventa['total_venta'] == 0){
                        ?>
                            <td style="color: yellow;">
                                <?php echo "$".$rowventa['total_venta'] ?>
                            </td>
                            <?php
                            }
                        ?>
                        </tr>
                        <tr>
                            <td>
                                lo vendió
                            </td>
                            <td>
                                <?php
                                $vendio = "SELECT * FROM so_usuarios where id = '".$rowventa['vendedor_id']."'";
                                $resvendio = mysqli_query($conexion, $vendio);
                                $rowvendio = mysqli_fetch_array($resvendio);

                                echo $rowvendio['nombre']." ".$rowvendio['apellido_p']." ".$rowvendio['apellido_m'];
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Compro
                            </td>
                            <td>
                                <?php
                                $cliente = "SELECT * FROM so_clientes where id = '".$rowventa['cliente_id']."'";
                                $rescliente = mysqli_query($conexion, $cliente);
                                $rowcliente = mysqli_fetch_array($rescliente);
                            ?>
                                <ul>
                                    <li>
                                        <p style="color: #B4B4B4; display: inline">Nombre: </p>
                                        <?php echo $rowcliente['nombre']." ".$rowcliente['apellido_p']." ".$rowcliente['apellido_m']; ?>
                                    </li>
                                    <li>
                                        <p style="color: #B4B4B4; display: inline">Telefono: </p>
                                        <?php echo $rowcliente['telefono']; ?>
                                    </li>
                                    <li>
                                        <p style="color: #B4B4B4; display: inline">Dirección: </p>
                                        <?php echo $rowcliente['direccion']; ?>
                                    </li>
                                    <li>
                                        <p style="color: #B4B4B4; display: inline">Negocio: </p>
                                        <?php echo $rowcliente['negocio']; ?>
                                    </li>
                                    <li>
                                        <p style="color: #B4B4B4; display: inline">Correo: </p>
                                        <?php echo $rowcliente['correo']; ?>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Tipo de cliente
                            </td>
                            <td>
                                <?php
                                $comision = "SELECT * FROM so_clientes AS c INNER JOIN so_tipo AS t WHERE c.id = '".$rowventa['cliente_id']."'";
                                $rescomision = mysqli_query($conexion, $comision);
                                $rowcomision = mysqli_fetch_array($rescomision);
                            ?>
                                <ul>
                                    <li><?php echo $rowcomision['tipo_cliente']; ?></li>
                                    <li><?php echo $rowcomision['descuento']."% de descuento"; ?></li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Ocupa factura
                            </td>
                            <td>
                                <?php
                                if($rowventa['factura'] == 0){
                                    echo "No ocupa Factura";
                                }elseif($rowventa['factura']){
                                    $factura = "SELECT id FROM so_facturacion WHERE cliente_id = '".$rowventa['cliente_id']."'";
                                    $resfactura = mysqli_query($conexion, $factura);
                                    $rowfactura = mysqli_fetch_array($resfactura);
                                    if($rowfactura == NULL){
                                        echo "Si ocupa Factura";
                                    ?>
                                <br><button class="btn btn-warning btn-sm registrar_factura" nombre_cliente="<?php echo $rowcliente['nombre']; ?>" id_cliente="<?php echo $rowventa['cliente_id']; ?>">
                                    Registra la Factura
                                </button>
                                <?php
                                    }else{
                                        echo "Si ocupa Factura";
                                    ?>
                                <br><button class="btn btn-success btn-sm revisar_factura" id_cliente="<?php echo $rowventa['cliente_id']; ?>">Revisar la Factura </button>
                                <?php
                                    }
                                }
                            ?>
                            </td>
                        </tr>
                        <?php
                        if($rowventa['observacion'] != NULL ){
                    ?>
                        <tr>
                            <td>
                                Observaciones
                            </td>
                            <td>
                                <?php
                                    echo $rowventa['observacion'];
                                ?>
                            </td>
                        </tr>
                        <?php
                        }
                    ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col">
                        <a href="ventas.php"><button class="btn btn-primary btn-block my-3">Regresar al listado</button></a>
                    </div>
                    <div class="col">
                        <a href="../PDFs/factura.php?id=<?php echo $id_venta; ?>&indicador=<?php echo $indicador_venta; ?>" target="_blank"><button class="btn btn-success btn-block my-3">Imprimir Factura</button></a>
                    </div>
                </div>
            </div>
            <br><br><br>
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