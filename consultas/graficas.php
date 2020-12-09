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
    $year = date('Y');
    $mes = date('m');
    $inicio_mes = "$year-$mes-01";

    if(!empty($_POST)){
        $action = $_POST['action'];
        if($action == 'GraficaLineal'){
            $queryVenta= mysqli_query($conexion, "SELECT fecha, SUM(total_venta) AS total FROM ventas GROUP BY fecha ORDER BY fecha ASC");
            $lineaX = array(); //fecha
            $lineaY = array(); //monto
        
            $lineaX[] = $inicio_mes;
            $lineaY[] = 0;
            while($rowVenta = mysqli_fetch_array($queryVenta)){
                $lineaX[] = $rowVenta['fecha'];
                $lineaY[] = $rowVenta['total'];
            }
        
            echo json_encode($lineaX)." ".json_encode($lineaY);
            exit;
        }elseif($action == 'GraficaBarras'){
            $queryProducto= mysqli_query($conexion, "SELECT p.codigo_producto, SUM(pv.cantidad) AS cantidad FROM producto_venta AS pv INNER JOIN productos AS p WHERE pv.producto_id = p.id GROUP BY producto_id ORDER BY producto_id ASC");
            $productoX = array(); //producto
            $productoY = array(); //cantidad
        
            while($rowProducto = mysqli_fetch_array($queryProducto)){
                $productoX[] = $rowProducto['codigo_producto'];
                $productoY[] = $rowProducto['cantidad'];
            }
        
            echo json_encode($productoX)." ".json_encode($productoY);
            exit;
        }
    }else{
        echo "error";
        exit;
    }
?>