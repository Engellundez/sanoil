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
    date_default_timezone_set("America/Mexico_City");
    $fecha = date('d-m-Y');
?>
<!doctype html>
<html>

<head>
    <?php include ("../plantillas/head.php"); ?>
    <title>Sanoil | Nueva Venta</title>
</head>

<body>
    <?php include ("../plantillas/sidebar.php"); ?>
    <?php include ("../plantillas/encabezado.php"); ?>
    <div class="contenido">

        <div class="container separacion">
            <div>
                <span>Campos Obligatorios<span class="span">*</span></span>
                <form action="" method="post" id="agregar_producto">

                    <input type="hidden" name="action" value="agregar_Producto">
                    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                    <div class="row">
                        <div class="col">
                            <label>Código del producto<span class="span">*</span></label>
                            <select name="producto_id" id="producto_id" required class="form-control busqueda">
                                <option value="">Escoge Alguna Opción</option>
                                <?php
                                    $query_productos = mysqli_query($conexion ,"SELECT * FROM productos WHERE mostrar = '1' ORDER BY nombre_producto ASC");
                                    while($producto = mysqli_fetch_array($query_productos)){
                                        if($producto['cantidad'] >= 1){
                                ?>
                                    <option value="<?php echo $producto['id']; ?>"><?php echo $producto['codigo_producto']." - ".$producto['nombre_producto']." - $".number_format($producto['precio'], 2, ".", ",")." - ".$producto['cantidad']; ?></option>
                                <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="">Cantidad<span class="span">*</span></label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control" required autocomplete="off" placeholder="Cantidad" onpaste="return false">
                        </div>
                        <div class="col">
                            <label style="color: #EAEAEA;">Boton</label>
                            <button type="submit" id="agregarart" class="btn btn-success form-control">Agergar al Carrito</button>
                        </div>
                    </div>
                </form>
                <div class="container my-2" id="Tabla_productos">
                    <?php
                        $query_c_venta = mysqli_query($conexion, "SELECT COUNT(id) AS c_ventas FROM venta_empleado WHERE vendedor_id = '$id'");
                        $row_cantidad_ventas = mysqli_fetch_assoc($query_c_venta);
                        $canti_venta = $row_cantidad_ventas['c_ventas'];
                        $codigo_venta = "$id/venta/$canti_venta/registro";
                        // echo $codigo_venta;
                    ?>
                    <table class="table" style="text-align:center;">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Productos</th>
                                <th scope="col">Precio Unitario</th>
                                <th scope="col">Total</th>
                                <th scope="col" colspan="3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query_venta_cuenta = mysqli_query($conexion, "SELECT * FROM producto_venta WHERE vendedor_id = '$id' AND codigo_venta = '$codigo_venta'");
                                while($cuenta = mysqli_fetch_array($query_venta_cuenta)){
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $cuenta['cantidad']; ?></th>
                                    <td>
                                        <?php
                                            $query_producto_cuenta = mysqli_query($conexion, "SELECT * FROM productos WHERE id =".$cuenta['producto_id']);
                                            $row_producto_cuenta = mysqli_fetch_array($query_producto_cuenta);
                                            echo $row_producto_cuenta['nombre_producto'];
                                        ?>
                                    </td>
                                    <td style="color:#32b418;">$<?php echo $row_producto_cuenta['precio']; ?></td>
                                    <td style="color:#32b418;">
                                    <?php 
                                        echo "$".$cuenta['precio_total'];
                                    ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary restar_cantidad" id_cuenta="<?php echo $cuenta['id']; ?>">-1</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-success sumar_cantidad" id_cuenta="<?php echo $cuenta['id']; ?>">+1</button>
                                    </td>
                                    <td>
                                        <button type="submit" nombre_producto="<?php echo $row_producto_cuenta['nombre_producto']; ?>" id_cuenta="<?php echo $cuenta['id']; ?>" cantidad_producto="<?php echo $cuenta['cantidad']; ?>" total="<?php echo $cuenta['precio_total']; ?>" id_producto="<?php echo $cuenta['producto_id'] ?>" id="botton<?php echo $row_producto_cuenta['id']; ?>" class="btn btn-danger boton_eliminar_cuenta">Eliminar</button>
                                    </td>
                                </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <?php
                    $query_add_product_ventas = mysqli_query($conexion, "SELECT SUM(precio_total) AS total FROM producto_venta WHERE vendedor_id = '$id' AND codigo_venta = '$codigo_venta'");
                    $row_total = mysqli_fetch_assoc($query_add_product_ventas);
                    $total_cuenta = $row_total['total'];
                    if($total_cuenta == NULL){
                        $total_cuenta = 0;
                    }
                ?>

                <form action="" method="post" class="agregar_nueva_venta">
                    <input type="hidden" name="action" value="registrar venta">
                    <div class="row my-2">
                        <div class="col"></div>
                        <div class="col" style="color:#32b418; text-align:center;">
                            <label>Total de Venta</label>
                            <input type="text" style="color:#32b418; text-align:center;" disabled value="$<?php echo number_format($total_cuenta, 2, ".", ","); ?>" class="form-control">

                            <input type="hidden" name="total" value="<?php echo number_format($total_cuenta, 2, ".", ""); ?>">
                            <input type="hidden" name="user" value="<?php echo $id; ?>">
                        </div>
                        <div class="col"></div>
                    </div>
                    <div class="row my-2">
                        <div class="col">
                            <label>Fecha: <span class="span">*</span></label>
                            <input type="text" required class="form-control" disabled value="<?php echo $fecha; ?>">
                        </div>
                        <div class="col">
                            <label>Cliente <span class="span">*</span></label>
                            <select name="cliente_id" required id="cliente_id" class="form-control">
                                <option value="">Escoge un Cliente</option>
                                <?php 
                                    $query_clientes = mysqli_query($conexion, "SELECT * FROM clientes");
                                    while($row_cliente = mysqli_fetch_array($query_clientes)){
                                ?>
                                <option value="<?php echo $row_cliente['id']; ?>"><?php echo $row_cliente['nombre']." ".$row_cliente['apellido_p']." ".$row_cliente['apellido_m']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <label>Registrar Nuevo Cliente</label>
                            <br>
                            <button class="my-1 btn btn-primary" id="agregar_nuevo_cliente">Agregar Cliente</button>
                        </div>
                    </div>                        
                    <div class="row">
                        <div class="col">
                            <label>Observaciones</label>
                            <input type="text" name="descripcion" placeholder="Observaciones" class="form-control">
                        </div>
                        <div class="col">
                            <label>Requier Factura <span class="span">*</span></label>
                            <select name="factura" required id="factura" class="form-control">
                                    <option value="0">NO</option>
                                    <option value="1">SI</option>
                            </select>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col"></div>
                        <div class="col">
                            <button class="btn btn-success btn-lg btn-block" id="completar_venta">Realizar Venta</button>
                        </div>
                        <div class="col"></div>
                    </div>
                </form>
                <br><br><br>
            </div>
        </div>

    </div>
    <!-- scripts del Documento -->
    <script src="../js/nVenta.js"></script>

    <!-- scripts -->
    <script src="../js/fecha.js"></script>
    <script src="../js/sidebar.js"></script>

    <!-- scripts Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- footer -->
    <?php include("../plantillas/footer.php"); ?>
</body>
</html>