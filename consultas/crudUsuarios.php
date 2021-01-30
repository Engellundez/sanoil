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
        // if($action == 'registar empleado'){
        //     $nombre = $_POST['nombre'];
        //     $correo = $_POST['correo'];
        //     $password1 = hash('whirlpool', $_POST['password1']);
        //     $password2 = hash('whirlpool', $_POST['password2']);
        //     $rol = $_POST['rol'];

        //     if($password1 == $password2){
        //         $query_correo = mysqli_query($conexion, "SELECT * FROM users WHERE email = '$correo'");
        //         $fila_correo = mysqli_num_rows($query_correo);
        //         if($fila_correo > 0){
        //             echo "correo ya registrado";
        //         }else{
        //             $query_nuevo_usuario = mysqli_query($conexion, "INSERT INTO users(id, name, email, email_verified_at, password, remember_token,mostrar) VALUES (NULL,'$nombre','$correo',NULL,'$password1',NULL,1)");

        //             $query_buscar = mysqli_query($conexion, "SELECT * FROM users WHERE name = '$nombre' AND email = '$correo' AND password = '$password2'");
        //             $fila_buscar = mysqli_num_rows($query_buscar);
        //             if($fila_buscar > 0){
        //                 $user = mysqli_fetch_assoc($query_buscar);
        //                 $user_id = $user['id'];

        //                 $query_asignar_rol = mysqli_query($conexion, "INSERT INTO rol_users (id, user_id, rol_id) VALUES (NULL, '$user_id', '$rol')");

        //                 $query_rol = mysqli_query($conexion, "SELECT * FROM rol_users WHERE user_id = '$user_id' AND rol_id = '$rol'");
        //                 $fila_rol = mysqli_num_rows($query_rol);
        //                 if($fila_rol > 0){
        //                     echo "registro correctamente";
        //                     exit;
        //                 }else{
        //                     echo "algo salio mal";
        //                 }
        //             }else{
        //                 echo "no se registro";
        //             }
        //         }
        //     exit;
        //     }else{
        //         echo 'La contraseña es Incorrecta';
        //         exit;
        //     }
        // }else
        if($action == 'actualizar contrasena'){
            if(!empty($_POST['contrasenia']) && !empty($_POST['nueva_contrasenia']) && !empty($_POST['repite_nueva_contrasenia'])){
                $query = mysqli_query($conexion, "SELECT * FROM so_usuarios WHERE id = '$id'");
                $row_user = mysqli_fetch_assoc($query);
                $pass = $row_user['password'];
                $apass = hash('whirlpool', $_POST['contrasenia']);
                if($pass == $apass){
                    $npass = $_POST['nueva_contrasenia'];
                    $rnpass = $_POST['repite_nueva_contrasenia'];
                    if($npass == $rnpass){
                        $anpass = hash('whirlpool', $npass);
                        if($apass == $anpass){
                            echo "son iguales";
                            exit;
                        }else{
                            $upd_query = mysqli_query($conexion, "UPDATE so_usuarios SET password = '$anpass' WHERE id = '$id'");
                            if($upd_query){
                                echo "success";
                                exit;
                            }else{
                                echo "no registro";
                                exit;
                            }
                        }
                    }else{
                        echo "no son iguales";
                        exit;
                    }
                }else{
                    echo "la contraseña no es correcta";
                    exit;
                }
            }else{
                echo "vacio";
                exit;
            }
        // }elseif($action == 'eliminar usuario'){
        //     $id_user = $_POST['id_user'];

        //     $query_eliminar = mysqli_query($conexion, "UPDATE users SET mostrar = '0' WHERE id = '$id_user'");
        //     if($query_eliminar){
        //         echo "success";
        //         exit;
        //     }else{
        //         echo "no se actualizo";
        //         exit;
        //     }
        // }elseif($action == 'recontratar un usuario'){
        //     $id_user = $_POST['id_user'];

        //     $query_recontratar = mysqli_query($conexion, "UPDATE users SET mostrar = '1' WHERE id = '$id_user'");
        //     if($query_recontratar){
        //         echo "success";
        //         exit;
        //     }else{
        //         echo "no se actualizo";
        //         exit;
        //     }
        // }elseif($action == 'contraseña para editar'){
        //     $pass = $_POST['pass'];
        //     if($pass == ''){
        //         echo "vacio";
        //         exit;
        //     }
        //     $contra = hash('whirlpool', $pass);
        //     $query_contra = mysqli_query($conexion, "SELECT * FROM users WHERE id = '$id'");
        //     $user = mysqli_fetch_assoc($query_contra);
        //     $u_pass = $user['password'];
        //     if($contra == $u_pass){
        //         $id_user = $_POST['id_user'];
        //         $query_edit = mysqli_query($conexion, "SELECT u.id,u.name,u.email,r.id AS rol_id, r.rol FROM users AS u INNER JOIN rol_users AS ru INNER JOIN rols AS r WHERE u.id = '$id_user' AND ru.user_id = u.id AND ru.rol_id = r.id");
        //         $data = mysqli_fetch_assoc($query_edit);
        //         echo json_encode($data, JSON_UNESCAPED_UNICODE);
        //         exit;
        //     }else{
        //         echo "contraseña mal";
        //         exit;
        //     }
        // }elseif($action == 'editar al usuario'){
        //     $id_usuario = $_POST['id_usuario'];
        //     $nombre = $_POST['nombre'];
        //     $correo = $_POST['correo'];
        //     $contrasenia = $_POST['password'];
        //     $rol_actual = $_POST['rol_actual'];
        //     $nuevo_rol = '';
        //     if(!empty($_POST['s_nuevo_rol'])){
        //         $nuevo_rol = $_POST['nuevo_rol'];
        //     }

        //     if($contrasenia == ''){
        //         if($nuevo_rol == ''){
        //             $query_s_contra_s_rol = mysqli_query($conexion, "UPDATE users SET name = '$nombre', email = '$correo' WHERE id = '$id_usuario'");
        //             if($query_s_contra_s_rol){
        //                 echo "success";
        //                 exit;
        //             }else{
        //                 echo "paso algo en la seccion sin contra y sin rol";
        //                 exit;
        //             }
        //         }else{
        //             $query_s_contra_c_rol = mysqli_query($conexion, "UPDATE users SET name = '$nombre', email = '$correo' WHERE id = '$id_usuario'");
        //             if($query_s_contra_c_rol){
        //                 $query_c_rol = mysqli_query($conexion, "UPDATE rol_users SET rol_id = '$nuevo_rol' WHERE user_id = '$id_usuario' AND rol_id = '$rol_actual'");
        //                 if($query_c_rol){
        //                     echo "success";
        //                     exit;
        //                 }else{
        //                     echo "paso algo en la seccion sin contra y con rol";
        //                     exit;
        //                 }
        //             }else{
        //                 echo "paso algo en la seccion sin contra y con rol";
        //                 exit;
        //             }
        //         }
        //     }else{
        //         if($nuevo_rol == ''){
        //             $contrasena = hash('whirlpool', $contrasenia);
        //             $query_c_contra_s_rol = mysqli_query($conexion, "UPDATE users SET name = '$nombre', email = '$correo', password = '$contrasena' WHERE id = '$id_usuario'");
        //             if($query_c_contra_s_rol){
        //                 echo "success";
        //                 exit;
        //             }else{
        //                 echo "paso algo en la seccion con contra y sin rol";
        //                 exit;
        //             }
        //         }else{
        //             $contrasena = hash('whirlpool', $contrasenia);
        //             $query_c_contra_c_rol = mysqli_query($conexion, "UPDATE users SET name = '$nombre', email = '$correo', password = '$contrasena' WHERE id = '$id_usuario'");
        //             if($query_c_contra_c_rol){
        //                 $query_c_rol = mysqli_query($conexion, "UPDATE rol_users SET rol_id = '$nuevo_rol' WHERE user_id = '$id_usuario' AND rol_id = '$rol_actual'");
        //                 if($query_c_rol){
        //                     echo "success";
        //                     exit;
        //                 }else{
        //                     echo "paso algo en la seccion con contra y con rol";
        //                     exit;
        //                 }
        //             }else{
        //                 echo "paso algo en la seccion con contra y con rol";
        //                 exit;
        //             }
        //         }
        //     }
        }else{
            echo 'error';
            exit;
        }
    }else{
        echo 'error';
        exit;
    }
?>