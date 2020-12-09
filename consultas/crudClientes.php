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

    if(!empty($_POST))
    {
        $action = $_POST['action'];

        if($action == 'agregar nuevo cliente'){
            $nombre = $_POST['nombre'];
            $apellido_p = $_POST['apellido_p'];
            $apellido_m = $_POST['apellido_m'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $negocio = $_POST['negocio'];
            $factura = $_POST['factura'];
            $tipo_id = $_POST['tipo_id'];

            $query_buscar_correo = mysqli_query($conexion, "SELECT * FROM clientes WHERE correo = '$correo'");
            $fila_correo = mysqli_num_rows($query_buscar_correo);
            
            if($fila_correo == NULL){
                $query_nuevo_cliente = mysqli_query($conexion, "INSERT INTO clientes (id, nombre, apellido_p, apellido_m, direccion, telefono, correo, negocio, tipo_id, fecha) VALUES (NULL, '$nombre', '$apellido_p', '$apellido_m', '$direccion', '$telefono', '$correo', '$negocio', '$tipo_id', '$fecha')");

                $query_verificar = mysqli_query($conexion, "SELECT * FROM clientes WHERE nombre = '$nombre' AND correo = '$correo'");
                $fila_verificaca = mysqli_num_rows($query_verificar);

                if($fila_verificaca != NULL){
                    if($factura == 1){
                        $row_cliente = mysqli_fetch_assoc($query_verificar);
                        echo $row_cliente['id'];
                        exit;
                    }else{
                        echo "success";
                        exit;
                    }
                }else{
                    echo "no se registro";
                    exit;
                }
            }else{
                echo "correo registrado";
                exit;
            }
        // }elseif($action == 'registrar factura'){
        //     $query_ultimo_cliente = mysqli_query($conexion, "SELECT * FROM clientes ORDER BY id DESC LIMIT 1");
        //     $ultimo_cliente = mysqli_fetch_assoc($query_ultimo_cliente);

        //     $id_utlimo_cliente = $ultimo_cliente['id'];
        //     $razon_social = $_POST['razon_social'];
        //     $rfc = $_POST['rfc'];
        //     $domicilio_fiscal = $_POST['domicilio_fiscal'];
        //     $correo = $_POST['correo'];
        //     $telefono = $_POST['telefono'];

        //     $query_agregar_factura = mysqli_query($conexion, "INSERT INTO facturacions (id, cliente_id, razon_social, rfc, domicilio_fiscal, correo, telefono) VALUES (NULL, '$id_utlimo_cliente', '$razon_social', '$rfc', '$domicilio_fiscal', '$correo', '$telefono')");

        //     $query_verificar_factura = mysqli_query($conexion, "SELECT * FROM facturacions WHERE cliente_id = '$id_utlimo_cliente' AND razon_social = '$razon_social' AND rfc = '$rfc' AND domicilio_fiscal = '$domicilio_fiscal' AND correo = '$correo' AND telefono = '$telefono'");
        //     $fila_factura = mysqli_num_rows($query_verificar_factura);

        //     if($fila_factura > 0){
        //         echo "factura registrada";
        //         exit;
        //     }else{
        //         echo "factura no registrada";
        //         exit;
        //     }
        }elseif($action == 'registrar nueva factura'){

            $razon_social = $_POST['razon_social'];
            $rfc = $_POST['rfc'];
            $domicilio_fiscal = $_POST['domicilio_fiscal'];
            $correo = $_POST['correo'];
            $telefono = $_POST['telefono'];
            $id_cliente = $_POST['id_cliente'];

            $query_agregar_factura = mysqli_query($conexion, "INSERT INTO facturacion (id, cliente_id, razon_social, rfc, domicilio_fiscal, correo, telefono) VALUES (NULL, '$id_cliente', '$razon_social', '$rfc', '$domicilio_fiscal', '$correo', '$telefono')");

            if($query_agregar_factura){
                echo "success";
                exit;
            }else{
                echo "no se pudo registrar";
                exit;
            }
        }elseif($action == 'visualizar factura'){
            $id_cliente = $_POST['id_cliente'];
            
            $query_ver_factura = mysqli_query($conexion, "SELECT * FROM clientes AS cliente INNER JOIN facturacion AS fac WHERE fac.cliente_id = '$id_cliente' AND cliente.id = '$id_cliente'");
            $data = mysqli_fetch_assoc($query_ver_factura);

            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            exit;
        }elseif($action == 'editar cliente'){
            $id_cliente = $_POST['id_cliente'];
            $nombre     = $_POST['nombre'];
            $apellido_p     = $_POST['apellido_p'];
            $apellido_m     = $_POST['apellido_m'];
            $direccion  = $_POST['direccion'];
            $telefono   = $_POST['telefono'];
            $correo     = $_POST['correo'];
            $negocio    = $_POST['negocio'];
            if($id_cliente != '' && $nombre != '' && $correo != ''){
                $query_editar_cliente = mysqli_query($conexion, "UPDATE clientes SET nombre= '$nombre', apellido_p = '$apellido_p', apellido_m = '$apellido_m', direccion= '$direccion', telefono='$telefono', correo='$correo', negocio='$negocio' WHERE id = '$id_cliente'");
                if($query_editar_cliente){
                    echo "success",
                    exit;
                }else{
                    echo "no se edito";
                    exit;
                }
            }else{
                echo "vacio";
                exit;
            }
        }else{
            echo 'error';
            exit;
        }
    }else{
        echo 'error viene vacio';
        exit;
    }
?>