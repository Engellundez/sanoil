<?php
    $query = mysqli_query($conexion, "SELECT r.id AS id_rol, r.rol AS rol FROM so_usuarios AS u INNER JOIN so_rol_user AS ru INNER JOIN so_roles AS r WHERE u.id = '$id' AND ru.user_id = '$id' AND ru.rol_id = r.id");
    $row_rol = mysqli_fetch_assoc($query);
    $rol_id = $row_rol['id_rol'];
    $rol_nombre = $row_rol['rol'];
?><div class="sidebar">
<h2>MENÚ</h2>
<ul>
    <li>
        <a href="../vistas/inicio.php"><img class="icon" src="../img/icons/home.png">Inicio</a>
    </li>
    <li>
        <a href="../vistas/productos.php"><img src="../img/icons/productos.png" class="icon">Productos</a>
    </li>
    <li>
        <a href="../vistas/nventa.php"><img src="../img/icons/venta.png" class="icon">Vender</a>
    </li>
    <li>
        <a href="../vistas/agregarcliente.php"><img src="../img/icons/add-admin.png" class="icon">Clientes</a>
    </li>
    <li>
        <a>
            <img class="icon" src="../img/icons/tabla.png">
            Registro de 
        </a>
        <ul>
            <li>
                <a href="../vistas/ventas.php"><img src="../img/icons/venta.png" class="icon">Ventas</a>
            </li>
            <li>
                <a href="../vistas/clientes.php"><img src="../img/logs/usuario.png" class="icon">Clientes</a>
            </li>
        </ul>
    </li>
    <li>
        <a><img class="icon" src="../img/logs/usuario.png"><?php echo $user; ?></a>
        <ul>
            <li>
                <a href="../vistas/infopersonal.php"><img src="../img/icons/info.png" class="icon">Información Personal</a>
            </li>
            <li>
                <?php
                    $mi_revicion_rol = mysqli_query($conexion, "SELECT * FROM so_roles WHERE id = ".$rol_id);
                    $mi_respuesta_rol = mysqli_fetch_array($mi_revicion_rol);
                ?>
                <a><img src="../img/icons/estrella.png" class="icon">Rango: <?php echo $mi_respuesta_rol['rol']; ?></a>
            </li>
        </ul>
    </li>
    <li>
        <a href="../registros/logout.php"><img class="icon" src="../img/icons/apagado.png">Cerrar Sesión</a>
    </li>
</ul>
</div>