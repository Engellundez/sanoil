<?php
    include ("../conexion/conexion.php");
    session_start();
    $id = $_SESSION['id'];
    $user = $_SESSION['usuario'];
    $correo = $_SESSION['email'];
    $variable = $_SESSION['usuario'];

    if($variable == null || $variable = '')
    {
        header("location:../registros/login.php");
        die();
    }
    
    date_default_timezone_set("America/Mexico_City");
    $fecha = date('Y-m-d');


    if(!empty($_POST)){
        $action = $_POST['action'];
        if($action == 'agregar_Producto'){
            $id_producto = $_POST['producto_id'];
            $canti_form = $_POST['cantidad'];
            
            $query_c_venta = mysqli_query($conexion, "SELECT COUNT(id) AS c_ventas FROM venta_empleado WHERE vendedor_id = '$id'");
            $row_cantidad_ventas = mysqli_fetch_assoc($query_c_venta);
            $canti_venta = $row_cantidad_ventas['c_ventas'];
            $codigo_venta = "$id/venta/$canti_venta/registro";
            // echo $codigo_venta;

            $consulta_query = mysqli_query($conexion, "SELECT * FROM productos WHERE id = '$id_producto' AND mostrar = '1'");
            $data = mysqli_fetch_assoc($consulta_query);
            $cantidad = $data['cantidad'];
            $precio_total = number_format($data['precio'], 2, ".", "") * $canti_form;

            if($cantidad < $canti_form){
                echo 'Cantidad Insuficiente';
                exit;
            }elseif($canti_form <= 0){
                echo 'Cantidad Negativa';
                exit;
            }else{
                $query_producto = mysqli_query($conexion, "SELECT * FROM productos WHERE mostrar = '1' AND id = '$id_producto'");
                $resultado_producto = mysqli_fetch_assoc($query_producto);
                $cantidad_actual = $resultado_producto['cantidad'];
                $nueva_cantidad = $cantidad_actual - $canti_form;                
                
                $registrar_venta_cuenta = mysqli_query($conexion, "INSERT INTO producto_venta (id, codigo_venta, vendedor_id, producto_id, cantidad, precio_total) VALUES (NULL,'$codigo_venta', '$id', '$id_producto', '$canti_form', '$precio_total');");

                if($registrar_venta_cuenta){
                    $query_upd = mysqli_query($conexion, "UPDATE productos SET cantidad = '$nueva_cantidad' WHERE id = '$id_producto'");
                    if($query_upd){
                        echo "success";
                        exit;
                    }else{
                        echo "error al actualizar";
                        exit;
                    }
                }else{
                    echo "error al agregar";
                    exit;
                }
            }
        }elseif($action == 'eliminar'){
            $id_producto_venta = $_POST['id_venta_cuenta'];
            $cantidad = $_POST['cantidad'];
            $total = $_POST['total'];
            $id_producto = $_POST['id_producto'];

            $query_eliminar_cuenta = mysqli_query($conexion, "DELETE FROM producto_venta WHERE id = '$id_producto_venta' AND vendedor_id = '$id'");
            if($query_eliminar_cuenta){
                $query_devolver_cantidad = mysqli_query($conexion, "SELECT * FROM productos WHERE id = '$id_producto' AND mostrar = '1'");
                $row_productos = mysqli_fetch_assoc($query_devolver_cantidad);
                $cantidad_actual = $row_productos['cantidad'];
                $cantidad_nueva = $cantidad_actual + $cantidad;

                $upd_producto = mysqli_query($conexion, "UPDATE productos SET cantidad = '$cantidad_nueva' WHERE id = '$id_producto'");
                if($upd_producto){
                    echo "success";
                    exit;
                }else{
                    echo "error no actualiza producto";
                    exit;
                }
            }
        }elseif($action == 'agregar un nuevo cliente'){
            $nombre = $_POST['nombre'];
            $apellido_p = $_POST['apellido_p'];
            $apellido_m = $_POST['apellido_m'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $negocio = $_POST['negocio'];
            $comision = $_POST['comision'];

            if($nombre != '' && $correo != '' && $apellido_p != '' && $apellido_m != ''){
                $query_correo = mysqli_query($conexion, "SELECT * FROM clientes WHERE correo = '$correo'");
                $fila_correo = mysqli_num_rows($query_correo);

                if($fila_correo > 0){
                    echo "el correo ya existe";
                }else{
                    $query_nuevo_cliente = mysqli_query($conexion, "INSERT INTO clientes (id, nombre, apellido_p, apellido_m, direccion, telefono, correo, negocio, tipo_id, fecha) VALUES (NULL, '$nombre', '$apellido_p', '$apellido_m', '$direccion', '$telefono', '$correo', '$negocio', '$comision', '$fecha')");

                    if($query_nuevo_cliente){
                        echo "success";
                        exit;
                    }else{
                        echo "no se registro";
                        exit;
                    }
                }
            }else{
                echo "vacio";
            }
        }elseif($action == 'registrar venta'){
            $total = $_POST['total'];
            $usuario = $_POST['user'];
            $cliente = $_POST['cliente_id'];
            $descripcion = $_POST['descripcion'];
            $factura = $_POST['factura'];

            $query_descuento = mysqli_query($conexion, "SELECT t.descuento from clientes AS c INNER JOIN tipo AS t WHERE c.id = '$cliente' AND c.tipo_id = t.id");
            $row_descuento = mysqli_fetch_assoc($query_descuento);
            $descuento = $row_descuento['descuento'];

            $desgloce_descuento = ($total * $descuento) / 100;

            $total_con_descuento = number_format($total - $desgloce_descuento, 2, ".", "");

            $query_c_venta = mysqli_query($conexion, "SELECT COUNT(id) AS c_ventas FROM venta_empleado WHERE vendedor_id = '$id'");
            $row_cantidad_ventas = mysqli_fetch_assoc($query_c_venta);
            $canti_venta = $row_cantidad_ventas['c_ventas'];
            $codigo_venta = "$id/venta/$canti_venta/registro";
            
            if($total != '' && $usuario != '' && $cliente != '' && $factura !='' ){
                $query_agregar_venta = mysqli_query($conexion, "INSERT INTO ventas(id, codigo_venta, observacion, total_venta, descuento, vendedor_id, cliente_id, factura, fecha) VALUES (NULL, '$codigo_venta', '$descripcion', '$total_con_descuento', '$descuento', '$usuario', '$cliente', '$factura', '$fecha')");

                $query_ultima_venta = mysqli_query($conexion, "SELECT * FROM ventas WHERE total_venta = '$total_con_descuento' AND vendedor_id = '$usuario' AND cliente_id = '$cliente' AND observacion = '$descripcion' AND codigo_venta = '$codigo_venta'");
                $row_venta = mysqli_fetch_assoc($query_ultima_venta);
                $id_venta = $row_venta['id'];
                $fila_ventas = mysqli_num_rows($query_ultima_venta);

                if($fila_ventas > 0 || $fila_ventas != NULL){
                    $query_venta_empleado = mysqli_query($conexion, "INSERT INTO venta_empleado (id, codigo_venta, venta_id, vendedor_id, total_venta) VALUES (NULL, '$codigo_venta', '$id_venta', '$usuario', '$total_con_descuento')");

                    if($query_venta_empleado){
                        echo $id_venta;
                        exit;
                    }else{
                        echo 'error';
                        exit;
                    }
                }else{
                    echo ' error';
                    exit;
                }
            }else{
                echo "datos vacios";
                exit;
            }
        }elseif($action == 'restar producto'){
            $id_producto_venta = $_POST['id_cuenta'];
            $query_cuenta = mysqli_query($conexion, "SELECT * FROM producto_venta WHERE id = '$id_producto_venta'");
            $row_cuenta = mysqli_fetch_assoc($query_cuenta);
            $cantidad = $row_cuenta['cantidad'];
            $new_cantidad = $cantidad - 1;
            $id_producto = $row_cuenta['producto_id'];
            $precio_cuenta = $row_cuenta['precio_total'];

            $query_producto = mysqli_query($conexion, "SELECT * FROM productos WHERE id = '$id_producto' AND mostrar = '1'");
            $row_producto = mysqli_fetch_assoc($query_producto);
            $cantidad_producto = $row_producto['cantidad'];
            $precio_producto = $row_producto['precio'];
            $new_cantidad_producto = $cantidad_producto + 1;

            $upd_producto = mysqli_query($conexion, "UPDATE productos SET cantidad = '$new_cantidad_producto' WHERE id = '$id_producto'");

            $new_total = $precio_cuenta - $precio_producto;
            if($new_cantidad == 0){
                $upd_cuenta = mysqli_query($conexion, "DELETE FROM producto_venta WHERE id = '$id_producto_venta'");

                if($upd_cuenta){
                    echo "success";
                    exit;
                }else{
                    echo "algo salio mal al guardar venta cuentas";
                    exit;
                }
            }else{
                $upd_cuenta = mysqli_query($conexion, "UPDATE producto_venta SET cantidad = '$new_cantidad', precio_total = '$new_total' WHERE id = '$id_producto_venta'");

                if($upd_cuenta){
                    echo "success";
                    exit;
                }else{
                    echo "algo salio mal al guardar venta cuentas";
                    exit;
                }
            }
        }elseif($action == 'sumar producto'){
            $id_producto_venta = $_POST['id_cuenta'];
            $query_cuenta = mysqli_query($conexion, "SELECT * FROM producto_venta WHERE id = '$id_producto_venta'");
            $row_cuenta = mysqli_fetch_assoc($query_cuenta);
            $cantidad = $row_cuenta['cantidad'];
            $new_cantidad = $cantidad + 1;
            $id_producto = $row_cuenta['producto_id'];
            $precio_cuenta = $row_cuenta['precio_total'];

            $query_producto = mysqli_query($conexion, "SELECT * FROM productos WHERE id = '$id_producto' AND mostrar = '1'");
            $row_producto = mysqli_fetch_assoc($query_producto);
            $cantidad_producto = $row_producto['cantidad'];
            $new_cantidad_producto = $cantidad_producto - 1;
            $precio_producto = $row_producto['precio'];

            if($new_cantidad_producto < 0){
                echo "cantidad insuficiente";
                exit;
            }else{
                $new_total = $precio_cuenta + $precio_producto;
                $upd_cuenta = mysqli_query($conexion, "UPDATE producto_venta SET cantidad = '$new_cantidad', precio_total = '$new_total' WHERE id = '$id_producto_venta'");

                if($upd_cuenta){
                    $upd_producto = mysqli_query($conexion, "UPDATE productos SET cantidad = '$new_cantidad_producto' WHERE id = '$id_producto'");
                    if($upd_producto){
                        echo "success";
                        exit;
                    }else{
                        echo "no se actualizo";
                        exit;
                    }
                }else{
                    echo "salio un error";
                    exit;
                }
            }
        }elseif($action == 'Recuperar datos de cliente'){
            $id_cliente = $_POST['id_cliente'];

            $query_cliente = mysqli_query($conexion, "SELECT * FROM clientes WHERE id = '$id_cliente'");
            $data = mysqli_fetch_assoc($query_cliente);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            exit;
        }else{
            echo 'error';
            exit;
        }
    }else{
        echo 'error';
        exit;
    }

?>