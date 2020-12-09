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

$indicador = $_GET['indicador'];

require('../libreria/fpdf/fpdf.php');
include('../conexion/conexion.php');

$query_productos = mysqli_query($conexion, "SELECT pg.fecha, pg.reporte_de, pg.pdf, p.nombre, p.rol FROM pdfs_guardados AS pg INNER JOIN pdfs AS p WHERE '$indicador' = p.indicador AND '$indicador' = pg.indicador LIMIT 1");
$producto = mysqli_fetch_assoc($query_productos);

$reporte_de = $producto['pdf'];
$reporte_new = explode(",", $reporte_de);
$fecha_sh  = $producto['fecha'];
$fecha_1 = explode(" ", $fecha_sh);

$fecha_s = $fecha_1['0'];
$fecha_separada = explode("-", $fecha_s);

$dia = $fecha_separada['2'];
$mes = $fecha_separada['1'];
$anio = $fecha_separada['0'];
if($mes == "01"){
    $mes = "Enero";
    }elseif($mes == "02"){
        $mes = "Febrero";
    }elseif($mes == "03"){
        $mes = "Marzo";
    }elseif($mes == "04"){
        $mes = "Abril";
    }elseif($mes == "05"){
        $mes = "Mayo";
    }elseif($mes == "06"){
        $mes = "Junio";
    }elseif($mes == "07"){
        $mes = "Julio";
    }elseif($mes == "08"){
        $mes = "Agosto";
    }elseif($mes == "09"){
        $mes = "Septiembre";
    }elseif($mes == "10"){
        $mes = "Octubre";
    }elseif($mes == "11"){
        $mes = "Noviembre";
    }elseif($mes == "12"){
        $mes = "Diciembre";
}
$fecha = $dia." de ".$mes." del ".$anio;

$query_ajustes = mysqli_query($conexion, "SELECT * FROM ajustes WHERE id = 1");
$ajustes = mysqli_fetch_assoc($query_ajustes);

$cantidad = count($reporte_new);
$conteo = 0;

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        $user = $_SESSION['usuario'];
        include('../conexion/conexion.php');
        $query_ajustes = mysqli_query($conexion, "SELECT * FROM ajustes");
        $ajustes = mysqli_fetch_assoc($query_ajustes);

        $indicador = $_GET['indicador'];

        $query_productos = mysqli_query($conexion, "SELECT pg.fecha, pg.reporte_de, pg.pdf, p.nombre, p.rol FROM pdfs_guardados AS pg INNER JOIN pdfs AS p WHERE '$indicador' = p.indicador AND '$indicador' = pg.indicador LIMIT 1");
        $producto = mysqli_fetch_assoc($query_productos);

        $fecha_sh  = $producto['fecha'];
        $fecha_1 = explode(" ", $fecha_sh);

        $fecha_s = $fecha_1['0'];
        $fecha_separada = explode("-", $fecha_s);

        $dia = $fecha_separada['2'];
        $mes = $fecha_separada['1'];
        $anio = $fecha_separada['0'];
        if($mes == "01"){
            $mes = "Enero";
            }elseif($mes == "02"){
                $mes = "Febrero";
            }elseif($mes == "03"){
                $mes = "Marzo";
            }elseif($mes == "04"){
                $mes = "Abril";
            }elseif($mes == "05"){
                $mes = "Mayo";
            }elseif($mes == "06"){
                $mes = "Junio";
            }elseif($mes == "07"){
                $mes = "Julio";
            }elseif($mes == "08"){
                $mes = "Agosto";
            }elseif($mes == "09"){
                $mes = "Septiembre";
            }elseif($mes == "10"){
                $mes = "Octubre";
            }elseif($mes == "11"){
                $mes = "Noviembre";
            }elseif($mes == "12"){
                $mes = "Diciembre";
        }
        $fecha = $dia." de ".$mes." del ".$anio;

        // Logo
        if($ajustes['logo'] == 1){
            $this->Image('../img/logo.png',10,8,33);
        }
        // Arial bold 15
        $this->SetFont('Arial','B',18);
        // Movernos a la derecha
        $this->Cell(60);
        // Título
        if($ajustes['orientacion_hoja'] == 0){
            $this->Cell(75,10,'Reporte de '.$producto['reporte_de'],0,0,'C');
        }else{
            $this->Cell(142,10,'Reporte de '.$producto['reporte_de'],0,0,'C');
        }
        // Salto de línea
        $this->Ln(20);
        if($ajustes['align_fecha'] == 0){
            $aling_fecha = 'L';
        }elseif($ajustes['align_fecha'] == 1){
            $aling_fecha = 'C';
        }elseif($ajustes['align_fecha'] == 2){
            $aling_fecha = 'R';
        }elseif($ajustes['align_fecha'] == 3){
            $aling_fecha = 'J';
        }
        if($ajustes['fecha'] == 1){
            $this->SetFont('Arial','B',$ajustes['size_fecha']);
            $this->Cell(0,7,utf8_decode('Fecha: '.$fecha),0,1,$aling_fecha);
        }
        if($ajustes['nombre_imprimio'] == 1){
            $this->Cell(0,7,utf8_decode($producto['nombre']." [".$producto['rol']."]"),0,1,$aling_fecha);
        }
        $this->Ln(7);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
}
// ajustes
    // orden
    if($ajustes['orden_tabla'] == 0){
        $orden = 'codigo_producto';
    }elseif($ajustes['orden_tabla']  == 1){
        $orden = 'producto';
    }elseif($ajustes['orden_tabla']  == 2){
        $orden = 'precio';
    }elseif($ajustes['orden_tabla']  == 3){
        $orden = 'cantidad';
    }

    // acendente o decendente
    if($ajustes['acomodo_tabla'] == 0){
        $acomodo = 'ASC';
    }elseif($ajustes['acomodo_tabla'] == 1){
        $acomodo = 'DESC';
    }

    // orientacion
    if($ajustes['orientacion_hoja'] == 0){
        $orientation = 'P';
    }else{
        $orientation = 'L';
    }

    //tipo de hoja
    if($ajustes['tipo_hoja'] == 0){
        $tipo = 'A3';
    }elseif($ajustes['tipo_hoja'] == 1){
        $tipo = "A4";
    }elseif($ajustes['tipo_hoja'] == 2){
        $tipo = "A5";
    }elseif($ajustes['tipo_hoja'] == 3){
        $tipo = "Letter";
    }elseif($ajustes['tipo_hoja'] == 4){
        $tipo = "Legal";
    }

    // alineacion
    if($ajustes['align'] == 0){
        $aling = 'L';
    }elseif($ajustes['align'] == 1){
        $aling = 'C';
    }elseif($ajustes['align'] == 2){
        $aling = 'R';
    }elseif($ajustes['align'] == 3){
        $aling = 'J';
    }
//fin ajustes
$pdf = new PDF();
$pdf->__construct($orientation,'mm',$tipo);
$pdf->AliasNbPages();
if($reporte_new[0] != 'Productos'){
    if($ajustes['hoja_tabla'] != 1){
        $pdf->AddPage();
    }
}

for ($i=$conteo; $i < $cantidad; $i++) { 
    if($reporte_new[$i] == 'Productos'){
        $pdf->AddPage();
        $pdf->SetFont('Arial','',$ajustes['size_text']);
        $pdf->MultiCell(0,5,utf8_decode($ajustes['texto_superior_productos']),0,$aling);
        $pdf->Ln(7);
        $pdf->SetFont('Arial','B',$ajustes['size_head']);


        $pdf->Cell(0,10,'Productos',0,1,'C');
        if($orientation == 'P'){
            $pdf->Cell(20, 7, utf8_decode('Codigo'),1,0,'C',0);
            $pdf->Cell(30, 7, utf8_decode('Cantidad'),1,0,'C',0);
            $pdf->Cell(30, 7, utf8_decode('Precio'),1,0,'C',0);
            $pdf->Cell(0, 7, utf8_decode('Producto'),1,1,'C',0);
        }else{
            $pdf->Cell(20, 7, utf8_decode('Codigo'),1,0,'C',0);
            $pdf->Cell(30, 7, utf8_decode('Cantidad'),1,0,'C',0);
            $pdf->Cell(30, 7, utf8_decode('Precio'),1,0,'C',0);
            $pdf->Cell(90, 7, utf8_decode('Descripcion'),1,0,'C',0);
            $pdf->Cell(0, 7, utf8_decode('Producto'),1,1,'C',0);
        }


        $pdf->SetFont('Arial','',$ajustes['size_body']);
        $query_productos = mysqli_query($conexion, "SELECT pg.pdf, p.fecha_venta, p.total_venta, p.cliente, p.codigo_producto, p.producto, p.descripcion, p.precio, p.cantidad FROM pdfs_guardados AS pg INNER JOIN pdfs AS p WHERE '$indicador' = p.indicador AND pg.indicador = '$indicador' AND tabla = 'Productos' ORDER BY $orden $acomodo");

        if($orientation == 'P'){
            while($row_productos = mysqli_fetch_array($query_productos)){
                $pdf->Cell(20, 7, utf8_decode($row_productos['codigo_producto']),1,0,'C',0);
                $pdf->Cell(30, 7, utf8_decode($row_productos['cantidad']),1,0,'C',0);
                $pdf->Cell(30, 7, utf8_decode("$".$row_productos['precio']),1,0,'C',0);
                $pdf->Cell(0, 7, utf8_decode($row_productos['producto']),1,1,'C',0);
            }
        }else{
            while($row_productos = mysqli_fetch_array($query_productos)){
                $pdf->Cell(20, 7, utf8_decode($row_productos['codigo_producto']),1,0,'C',0);
                $pdf->Cell(30, 7, utf8_decode($row_productos['cantidad']),1,0,'C',0);
                $pdf->Cell(30, 7, utf8_decode("$".$row_productos['precio']),1,0,'C',0);
                $pdf->Cell(90, 7, utf8_decode($row_productos['descripcion']),1,0,'C',0);
                $pdf->Cell(0, 7, utf8_decode($row_productos['producto']),1,1,'C',0);
            }
        }

        $pdf->Ln(7);
        $pdf->SetFont('Arial','',$ajustes['size_text']);
        $pdf->MultiCell(0,5,utf8_decode($ajustes['texto_inferior_productos']),0,$aling);
    }
}
for ($i=$conteo; $i < $cantidad; $i++) { 
    if($reporte_new[$i] == 'Envasados'){
        if($ajustes['hoja_tabla'] == 1){
            $pdf->AddPage();
        }else{
            $pdf->Ln(10);
        }
        
        $pdf->SetFont('Arial','',$ajustes['size_text']);
        $pdf->MultiCell(0,5,utf8_decode($ajustes['texto_superior_envasados']),0,$aling);
        $pdf->Ln(7);
        $pdf->SetFont('Arial','B',$ajustes['size_head']);
        
        
        $pdf->Cell(0,10,'Envasados',0,1,'C');
        if($orientation == 'P'){
            $pdf->Cell(20, 7, utf8_decode('Codigo'),1,0,'C',0);
            $pdf->Cell(30, 7, utf8_decode('Litros'),1,0,'C',0);
            $pdf->Cell(30, 7, utf8_decode('Precio'),1,0,'C',0);
            $pdf->Cell(0, 7, utf8_decode('Producto'),1,1,'C',0);
        }else{
            $pdf->Cell(20, 7, utf8_decode('Codigo'),1,0,'C',0);
            $pdf->Cell(30, 7, utf8_decode('Litros'),1,0,'C',0);
            $pdf->Cell(30, 7, utf8_decode('Precio'),1,0,'C',0);
            $pdf->Cell(90, 7, utf8_decode('Descripcion'),1,0,'C',0);
            $pdf->Cell(0, 7, utf8_decode('Producto'),1,1,'C',0);
        }
        
        
        $pdf->SetFont('Arial','',$ajustes['size_body']);
        $query_productos = mysqli_query($conexion, "SELECT pg.pdf, p.fecha_venta, p.total_venta, p.cliente, p.codigo_producto, p.producto, p.descripcion, p.precio, p.cantidad FROM pdfs_guardados AS pg INNER JOIN pdfs AS p WHERE '$indicador' = p.indicador AND pg.indicador = '$indicador' AND tabla = 'Envasados' ORDER BY $orden $acomodo");
        
        if($orientation == 'P'){
            while($row_productos = mysqli_fetch_array($query_productos)){
                $pdf->Cell(20, 7, utf8_decode($row_productos['codigo_producto']),1,0,'C',0);
                $pdf->Cell(30, 7, utf8_decode($row_productos['cantidad']." Lts."),1,0,'C',0);
                $pdf->Cell(30, 7, utf8_decode("$".$row_productos['precio']),1,0,'C',0);
                $pdf->Cell(0, 7, utf8_decode($row_productos['producto']),1,1,'C',0);
            }
        }else{
            while($row_productos = mysqli_fetch_array($query_productos)){
                $pdf->Cell(20, 7, utf8_decode($row_productos['codigo_producto']),1,0,'C',0);
                $pdf->Cell(30, 7, utf8_decode($row_productos['cantidad']." Lts."),1,0,'C',0);
                $pdf->Cell(30, 7, utf8_decode("$".$row_productos['precio']),1,0,'C',0);
                $pdf->Cell(90, 7, utf8_decode($row_productos['descripcion']),1,0,'C',0);
                $pdf->Cell(0, 7, utf8_decode($row_productos['producto']),1,1,'C',0);
            }
        }
        
        $pdf->Ln(7);
        $pdf->SetFont('Arial','',$ajustes['size_text']);
        $pdf->MultiCell(0,5,utf8_decode($ajustes['texto_inferior_envasados']),0,$aling);
    }
}
for ($i=$conteo; $i < $cantidad; $i++) { 
    if($reporte_new[$i] == 'Ventas'){
        if($ajustes['hoja_tabla'] == 1){
            $pdf->AddPage();
        }else{
            $pdf->Ln(10);
        }
        
        $pdf->SetFont('Arial','',$ajustes['size_text']);
        $pdf->MultiCell(0,5,utf8_decode($ajustes['texto_superior_ventas']),0,$aling);
        $pdf->Ln(7);
        $pdf->SetFont('Arial','B',$ajustes['size_head']);
        
        
        $pdf->Cell(0,10,'Ventas',0,1,'C');
        if($orientation == 'P'){
            $pdf->Cell(40, 7, utf8_decode('Fecha de Venta'),1,0,'C',0);
            $pdf->Cell(30, 7, utf8_decode('Total'),1,0,'C',0);
            $pdf->Cell(0, 7, utf8_decode('Cliente'),1,1,'C',0);
        }else{
            $pdf->Cell(40, 7, utf8_decode('Fecha de Venta'),1,0,'C',0);
            $pdf->Cell(30, 7, utf8_decode('Total'),1,0,'C',0);
            $pdf->Cell(0, 7, utf8_decode('Cliente'),1,1,'C',0);
        }
        
        
        $pdf->SetFont('Arial','',$ajustes['size_body']);
        $query_productos = mysqli_query($conexion, "SELECT pg.pdf, p.fecha_venta, p.total_venta, p.cliente, p.codigo_producto, p.producto, p.descripcion, p.precio, p.cantidad FROM pdfs_guardados AS pg INNER JOIN pdfs AS p WHERE '$indicador' = p.indicador AND pg.indicador = '$indicador' AND tabla = 'Venta' ORDER BY fecha_venta $acomodo");
        
        if($orientation == 'P'){
            while($row_productos = mysqli_fetch_array($query_productos)){
                $pdf->Cell(40, 7, utf8_decode($row_productos['fecha_venta']),1,0,'C',0);
                $pdf->Cell(30, 7, utf8_decode("$".$row_productos['total_venta']),1,0,'C',0);
                $pdf->Cell(0, 7, utf8_decode($row_productos['cliente']),1,1,'C',0);
            }
        }else{
            while($row_productos = mysqli_fetch_array($query_productos)){
                $pdf->Cell(40, 7, utf8_decode($row_productos['fecha_venta']),1,0,'C',0);
                $pdf->Cell(30, 7, utf8_decode("$".$row_productos['total_venta']),1,0,'C',0);
                $pdf->Cell(0, 7, utf8_decode($row_productos['cliente']),1,1,'C',0);
            }
        }
        
        $pdf->Ln(7);
        $pdf->SetFont('Arial','',$ajustes['size_text']);
        $pdf->MultiCell(0,5,utf8_decode($ajustes['texto_inferior_ventas']),0,$aling);
    }
}
for ($i=$conteo; $i < $cantidad; $i++) { 
    if($reporte_new[$i] == 'Trabajadores'){
        if($ajustes['hoja_tabla'] == 1){
            $pdf->AddPage();
        }else{
            $pdf->Ln(10);
        }
        
        $pdf->SetFont('Arial','',$ajustes['size_text']);
        $pdf->MultiCell(0,5,utf8_decode($ajustes['texto_superior_trabajador']),0,$aling);
        $pdf->Ln(7);
        $pdf->SetFont('Arial','B',$ajustes['size_head']);
        
        
        $pdf->Cell(0,10,'Trabajadores',0,1,'C');
        if($orientation == 'P'){
            $pdf->Cell(30, 7, utf8_decode('Rol'),1,0,'C',0);
            $pdf->Cell(33, 7, utf8_decode('Ventas Totales'),1,0,'C',0);
            $pdf->Cell(33, 7, utf8_decode('Identificador'),1,0,'C',0);
            $pdf->Cell(0, 7, utf8_decode('Nombre'),1,1,'C',0);
        }else{
            $pdf->Cell(30, 7, utf8_decode('Rol'),1,0,'C',0);
            $pdf->Cell(33, 7, utf8_decode('Ventas Totales'),1,0,'C',0);
            $pdf->Cell(33, 7, utf8_decode('Identificador'),1,0,'C',0);
            $pdf->Cell(75, 7, utf8_decode('Correo'),1,0,'C',0);
            $pdf->Cell(0, 7, utf8_decode('Nombre'),1,1,'C',0);
        }
        
        
        $pdf->SetFont('Arial','',$ajustes['size_body']);
        $query_productos = mysqli_query($conexion, "SELECT pg.pdf, p.fecha_venta, p.total_venta, p.cliente, p.codigo_producto, p.producto, p.descripcion, p.precio, p.cantidad FROM pdfs_guardados AS pg INNER JOIN pdfs AS p WHERE '$indicador' = p.indicador AND pg.indicador = '$indicador' AND tabla = 'Trabajadores' ORDER BY $orden $acomodo");
        
        if($orientation == 'P'){
            while($row_productos = mysqli_fetch_array($query_productos)){
                $pdf->Cell(30, 7, utf8_decode($row_productos['codigo_producto']),1,0,'C',0);
                $pdf->Cell(33, 7, utf8_decode($row_productos['cantidad']." ventas"),1,0,'C',0);
                $pdf->Cell(33, 7, utf8_decode($row_productos['precio']),1,0,'C',0);
                $pdf->Cell(0, 7, utf8_decode($row_productos['producto']),1,1,'C',0);
            }
        }else{
            while($row_productos = mysqli_fetch_array($query_productos)){
                $pdf->Cell(30, 7, utf8_decode($row_productos['codigo_producto']),1,0,'C',0);
                $pdf->Cell(33, 7, utf8_decode($row_productos['cantidad']." ventas"),1,0,'C',0);
                $pdf->Cell(33, 7, utf8_decode($row_productos['precio']),1,0,'C',0);
                $pdf->Cell(75, 7, utf8_decode($row_productos['descripcion']),1,0,'C',0);
                $pdf->Cell(0, 7, utf8_decode($row_productos['producto']),1,1,'C',0);
            }
        }
        
        $pdf->Ln(7);
        $pdf->SetFont('Arial','',$ajustes['size_text']);
        $pdf->MultiCell(0,5,utf8_decode($ajustes['texto_inferior_trabajador']),0,$aling);
    }
}
$pdf->Output();
?>