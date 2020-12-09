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

    if(!empty($_POST))
    {
        $action = $_POST['action'];
        if($action == 'Guardar_nuevo_producto'){
            $producto       = ucwords($_POST['nombre_producto']);
            $codigo         = strtoupper($_POST['codigo_producto']);
            $descripcion    = ucfirst($_POST['descripcion']);
            $precio         = number_format($_POST['precio'], 2, ".", "");
            $cantidad       = $_POST['cantidad'];
            $mg             = number_format($_POST['mililitros'], 3, ".", "");


            if($producto != '' || $codigo != '' || $descripcion != '' || $precio != '' || $cantidad != '' || $mg != '')
            {
                $query_add_product = mysqli_query($conexion, "INSERT INTO productos (id, codigo_producto, nombre_producto, cantidad, descripcion, precio, mililitros, mostrar) VALUES (NULL, '$codigo', '$producto', '$cantidad', '$descripcion', '$precio', '$mg', '1')");

                if($query_add_product){
                    echo "success";
                }else{
                    echo "Guardar_nuevo_producto fail";
                }
            }else{
                echo "error";
                exit;
            }
        }elseif($action == 'Passwordforeditquery'){
            $producto_id = $_POST['producto_Id'];

            $query_producto = mysqli_query($conexion, "SELECT * FROM productos WHERE id = '$producto_id' AND mostrar = 1");
            $resultado_producto = mysqli_num_rows($query_producto);

            if($resultado_producto > 0){
                $data = mysqli_fetch_assoc($query_producto);
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
                exit;
            }else{
                echo 'error';
                exit;
            }
        }elseif($action == 'EditProductforsustitution'){
            if(!empty($_POST['producto_id']) || !empty($_POST['nombre_producto']) || !empty($_POST['codigo_producto']) || !empty($_POST['descripcion']) || !empty($_POST['precio']) || !empty($_POST['cantidad']) || !empty($_POST['mililitros'])){
                $producto_id    = $_POST['producto_id'];
                $producto       = ucwords($_POST['nombre_producto']);
                $codigo         = strtoupper($_POST['codigo_producto']);
                $descripcion    = ucfirst($_POST['descripcion']);
                $precio         = number_format($_POST['precio'], 2, ".", "");
                $cantidad       = $_POST['cantidad'];
                $mililitros     = number_format($_POST['mililitros'], 3, ".", "");

                $query_edit_product = mysqli_query($conexion, "UPDATE productos SET nombre_producto = '$producto', codigo_producto = '$codigo', descripcion = '$descripcion', precio = '$precio', cantidad = '$cantidad', mililitros = '$mililitros' WHERE id = '$producto_id' AND mostrar = '1'");

                if($query_edit_product){
                    echo "success";
                    exit;
                }else{
                    echo "error";
                    exit;
                }
                mysqli_close($conexion);
            }else{
                echo "error";
                exit;
            }
        }elseif($action == 'Passwordfordeletequery'){
            $id_producto = $_POST['id'];
            $query_delete = mysqli_query($conexion, "UPDATE productos SET mostrar = 0 WHERE id = '$id_producto'");            
            if($query_delete){
                echo "success";
                exit;
            }else{
                echo "error al ejecutar";
                exit;
            }
        }elseif($action == 'Agregar_cantidad'){
            $cantidad_extra = $_POST['cantidad'];
            $id_producto = $_POST['IdProducto'];

            if($cantidad_extra <= 0){
                echo "menor";
                exit;
            }else{
                $query_producto = mysqli_query($conexion, "SELECT * FROM productos WHERE id = '$id_producto'");
                $row_producto = mysqli_fetch_assoc($query_producto);
                $cantidad_actual = $row_producto['cantidad'];
                $cantidad_actualizada = $cantidad_actual + $cantidad_extra;
                
                $query_upd_producto = mysqli_query($conexion, "UPDATE productos SET cantidad = '$cantidad_actualizada' WHERE id = '$id_producto'");
                if($query_upd_producto){
                    echo "success";
                    exit;
                }else{
                    echo "no se guardo";
                    exit;
                }
            }
        }else{
            echo "error";
            exit;
        }
    }else{
        echo "datos vacio";
        exit;
    }
?>