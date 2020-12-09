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
    <title>Mezcal | Productos</title>
</head>

<body>
    <?php include ("../plantillas/sidebar.php"); ?>
    <?php include ("../plantillas/encabezado.php"); ?>
    <div class="contenido">
        <div class="container separacion" id="tablacontenido">
           
            <a class="agregar_producto" href="#">
                <button class="btn btn-success btn-block">
                    <img src="../img/icons/plus-white.png" class="icon">
                    Nuevo Producto
                </button>
            </a>
            <table class="table my-3" style="text-align:center;">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Codígo de Producto</th>
                        <th scope="col">Nombre del Producto</th>
                        <th scope="col">Descripción del Producto</th>
                        <th scope="col">Precio del Producto</th>
                        <th scope="col">Cantidad del Producto</th>
                        <th scope="col">Mililitros del producto</th>
                        <th scope="col" colspan="3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $pruductos_query_total = mysqli_query($conexion, "SELECT * FROM productos WHERE mostrar = '1' ORDER BY nombre_producto");
                        $filas = mysqli_num_rows($pruductos_query_total);
                        $mostrarFilas = 4;
                        $conteo = $filas/$mostrarFilas;
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

                        $inicio = ($page-1) * $mostrarFilas;

                        $pruductos_query = mysqli_query($conexion, "SELECT * FROM productos WHERE mostrar = '1' ORDER BY nombre_producto ASC LIMIT $inicio,$mostrarFilas");
                        
                        if($pruductos_query != NULL){
                            while($producto = mysqli_fetch_array($pruductos_query)){
                    ?>
                    <tr class="row<?php echo $producto['id']; ?>">
                        <td class="celCodigo"><?php echo $producto['codigo_producto']; ?></td>
                        <td class="celProducto"><?php echo $producto['nombre_producto']; ?></td>
                        <td class="celDescripcion"><?php echo $producto['descripcion']; ?></td>
                        <td class="celPrecio">$<?php echo number_format($producto['precio'], 2, ".", ","); ?></td>
                        <td class="celCantidad"><?php echo $producto['cantidad']; ?></td>
                        <td class="celCantidad"><?php echo $producto['mililitros'] <= 1 ? number_format($producto['mililitros'], 3, ".", "").'ml' : number_format($producto['mililitros'], 3, ".", "").'L'; ?></td>
                        <td>
                            <button class="btn btn-success btn-sm agregar_cantidad" id_producto="<?php echo $producto['id']; ?>" nombre_producto="<?php echo $producto['nombre_producto']; ?>">Agregar Cantidad</button>
                        </td>
                        <td>
                            <a class="editar_producto" href="#" nombre_producto="<?php echo $producto['nombre_producto']; ?>" id_producto="<?php echo $producto['id']; ?>">
                                <button class="btn btn-warning btn-sm">Editar Producto</button>
                            </a>
                        </td>
                        <td>
                            <a class="eliminar_Producto" href="#" id_producto="<?php echo $producto['id']; ?>" nombre_producto="<?php echo $producto['nombre_producto']; ?>">
                                <button class="btn btn-danger btn-sm">Eliminar Producto</button>
                            </a>
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
                        <a class="page-link disabled" href="productos.php?page=<?php echo $page-1; ?>">
                            Anterior
                        </a>
                    </li>
                    <?php for($i=0; $i<$paginas; $i++){ ?>
                    <li class="page-item <?php if($page == ($i+1)){ echo 'active'; } ?>">
                        <a class="page-link" href="productos.php?page=<?php echo $i+1; ?>">
                            <?php echo $i+1; ?>
                        </a>
                    </li>
                    <?php } ?>
                    <li class="page-item <?php echo $page>=$paginas ? 'disabled' : '' ?>">
                        <a class="page-link" href="productos.php?page=<?php echo $page+1; ?>">
                            Siguiente
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>
    <!-- scripts del Documento -->
    <script src="../js/productos.js"></script>

    <!-- scripts -->
    <script src="../js/fecha.js"></script>
    <script src="../js/sidebar.js"></script>

    <!-- scripts Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- footer -->
    <?php include("../plantillas/footer.php"); ?>
</body>

</html>