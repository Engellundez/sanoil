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

require('../libreria/fpdf/fpdf.php');
include('../conexion/conexion.php');
date_default_timezone_set("America/Mexico_City");
$dia = date("d");
$mes = date("m");
$anio = date("Y");
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

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        $user = $_SESSION['usuario'];
        include('../conexion/conexion.php');
        $query_ajustes = mysqli_query($conexion, "SELECT * FROM ajustes");
        $ajustes = mysqli_fetch_assoc($query_ajustes);
        date_default_timezone_set("America/Mexico_City");
        $dia = date("d");
        $mes = date("m");
        $anio = date("Y");
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
            $this->Cell(75,10,'Cabecera no modificable',0,0,'C');
        }else{
            $this->Cell(160,10,'Cabecera no modificable',0,0,'C');
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
            $this->Cell(0,7,utf8_decode('Fecha: '.$fecha),0,3,$aling_fecha);
        }
        if($ajustes['nombre_imprimio'] == 1){
            $this->Cell(0,7,utf8_decode($user),0,1,$aling_fecha);
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
if($ajustes['orden_tabla'] == 0){
    $orden = 'codigo_producto';
}elseif($ajustes['orden_tabla']  == 1){
    $orden = 'producto';
}elseif($ajustes['orden_tabla']  == 2){
    $orden = 'precio';
}elseif($ajustes['orden_tabla']  == 3){
    $orden = 'cantidad';
}

if($ajustes['acomodo_tabla'] == 0){
    $acomodo = 'ASC';
}elseif($ajustes['acomodo_tabla'] == 1){
    $acomodo = 'DESC';
}

if($ajustes['orientacion_hoja'] == 0){
    $orientation = 'P';
}else{
    $orientation = 'L';
}

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
$pdf = new PDF();
$pdf->__construct($orientation,'mm',$tipo);
$pdf->AliasNbPages();
$pdf->AddPage();

if($ajustes['align'] == 0){
    $aling = 'L';
}elseif($ajustes['align'] == 1){
    $aling = 'C';
}elseif($ajustes['align'] == 2){
    $aling = 'R';
}elseif($ajustes['align'] == 3){
    $aling = 'J';
}
$pdf->SetFont('Arial','',$ajustes['size_text']);
$pdf->MultiCell(0,5,utf8_decode($ajustes['texto_superior_productos']),0,$aling);
$pdf->Ln(7);
$pdf->SetFont('Arial','B',$ajustes['size_head']);


$pdf->Cell(0,10,'Productos',0,1,'C');
$pdf->Cell(20, 7, utf8_decode('Codigo'),1,0,'C',0);
$pdf->Cell(30, 7, utf8_decode('Cantidad'),1,0,'C',0);
$pdf->Cell(30, 7, utf8_decode('Precio'),1,0,'C',0);
$pdf->Cell(0, 7, utf8_decode('Producto'),1,1,'C',0);

$pdf->SetFont('Arial','',$ajustes['size_body']);
$query_productos = mysqli_query($conexion, "SELECT * FROM so_productos ORDER BY $orden $acomodo");

// while($row_productos = mysqli_fetch_array($query_productos)){
    $pdf->Cell(20, 7, utf8_decode('COD'),1,0,'C',0);
    $pdf->Cell(30, 7, utf8_decode(1),1,0,'C',0);
    $pdf->Cell(30, 7, utf8_decode("$0"),1,0,'C',0);
    $pdf->Cell(0, 7, utf8_decode('producto'),1,1,'C',0);
// }
$pdf->Ln(7);
$pdf->SetFont('Arial','',$ajustes['size_text']);
$pdf->MultiCell(0,5,utf8_decode($ajustes['texto_inferior_productos']),0,$aling);

if($ajustes['hoja_tabla'] == 1){
    $pdf->AddPage();
}else{
    $pdf->Ln(10);
}

$pdf->SetFont('Arial','',$ajustes['size_text']);
$pdf->MultiCell(0,5,utf8_decode($ajustes['texto_superior_envasados']),0,$aling);
$pdf->Ln(5);
$pdf->SetFont('Arial','B',$ajustes['size_head']);

$pdf->Cell(0,10,'Envasados',0,1,'C');
$pdf->Cell(20, 7, utf8_decode('Codigo'),1,0,'C',0);
$pdf->Cell(30, 7, utf8_decode('Litros'),1,0,'C',0);
$pdf->Cell(30, 7, utf8_decode('Precio'),1,0,'C',0);
$pdf->Cell(0, 7, utf8_decode('Producto'),1,1,'C',0);

if($ajustes['orden_tabla'] == 0){
    $orden = 'codigo_producto';
}elseif($ajustes['orden_tabla']  == 1){
    $orden = 'producto';
}elseif($ajustes['orden_tabla']  == 2){
    $orden = 'precio';
}elseif($ajustes['orden_tabla']  == 3){
    $orden = 'litros';
}

$pdf->SetFont('Arial','',$ajustes['size_body']);
$query_envasados = mysqli_query($conexion, "SELECT * FROM envasados ORDER BY $orden $acomodo");

// while($row_envasado = mysqli_fetch_array($query_envasados)){
    $pdf->Cell(20, 7, utf8_decode('COD'),1,0,'C',0);
    $pdf->Cell(30, 7, utf8_decode(10),1,0,'C',0);
    $pdf->Cell(30, 7, utf8_decode("$0"),1,0,'C',0);
    $pdf->Cell(0, 7, utf8_decode('Envasado'),1,1,'C',0);
// }
$pdf->Ln(7);
$pdf->SetFont('Arial','',$ajustes['size_text']);
$pdf->MultiCell(0,5,utf8_decode($ajustes['texto_inferior_envasados']),0,$aling);

if($ajustes['hoja_tabla'] == 1){
    $pdf->AddPage();
}else{
    $pdf->Ln(10);
}

$pdf->SetFont('Arial','',$ajustes['size_text']);
$pdf->MultiCell(0,5,utf8_decode($ajustes['texto_superior_ventas']),0,$aling);
$pdf->Ln(5);
$pdf->SetFont('Arial','B',$ajustes['size_head']);

$pdf->Cell(0,10,'Ventas',0,1,'C');
$pdf->Cell(30, 7, utf8_decode('Fecha'),1,0,'C',0);
$pdf->Cell(20, 7, utf8_decode('Total'),1,0,'C',0);
if($ajustes['orientacion_hoja'] == 1){
    $pdf->Cell(80, 7, utf8_decode('Forma de pago'),1,0,'C',0);
}
$pdf->Cell(60, 7, utf8_decode('Quien vendio'),1,0,'C',0);
$pdf->Cell(0, 7, utf8_decode('Comprador'),1,1,'C',0);

$pdf->SetFont('Arial','',$ajustes['size_body']);
$query_venta = mysqli_query($conexion, "SELECT v.fecha, v.total,f.descripcion, u.name AS vendedor, c.nombre FROM so_ventas AS v INNER JOIN fpagos AS f INNER JOIN users AS u INNER JOIN so_clientes AS c WHERE v.fpago_id = f.id AND v.user_id = u.id AND v.cliente_id = c.id ORDER BY v.fecha $acomodo");

if($ajustes['orientacion_hoja'] == 1){
    // while($row_venta = mysqli_fetch_array($query_venta)){
        $pdf->Cell(30, 7, utf8_decode('fecha'),1,0,'C',0);
        $pdf->Cell(20, 7, utf8_decode('$total'),1,0,'C',0);
        $pdf->Cell(80, 7, utf8_decode('Forma de pago'),1,0,'C',0);
        $pdf->Cell(60, 7, utf8_decode('vendedor'),1,0,'C',0);
        $pdf->Cell(0, 7, utf8_decode('comprador'),1,1,'C',0);
    // }
}else{
    // while($row_venta = mysqli_fetch_array($query_venta)){
        $pdf->Cell(30, 7, utf8_decode('fecha'),1,0,'C',0);
        $pdf->Cell(20, 7, utf8_decode('$total'),1,0,'C',0);
        $pdf->Cell(60, 7, utf8_decode('vendedor'),1,0,'C',0);
        $pdf->Cell(0, 7, utf8_decode('comprador'),1,1,'C',0);
    // }
}
$pdf->Ln(7);
$pdf->SetFont('Arial','',$ajustes['size_text']);
$pdf->MultiCell(0,5,utf8_decode($ajustes['texto_inferior_ventas']),0,$aling);

if($ajustes['hoja_tabla'] == 1){
    $pdf->AddPage();
}else{
    $pdf->Ln(10);
}

$pdf->SetFont('Arial','',$ajustes['size_text']);
$pdf->MultiCell(0,5,utf8_decode($ajustes['texto_superior_clientes']),0,$aling);
$pdf->Ln(5);
$pdf->SetFont('Arial','B',$ajustes['size_head']);

$pdf->Cell(0,10,'Clientes',0,1,'C');
if($ajustes['orientacion_hoja'] == 1){
    $pdf->Cell(45, 7, utf8_decode('Tipo de Cliente'),1,0,'C',0);
    $pdf->Cell(45, 7, utf8_decode('Telefono'),1,0,'C',0);
    $pdf->Cell(75, 7, utf8_decode('Quien registro'),1,0,'C',0);
    $pdf->Cell(0, 7, utf8_decode('Cliente'),1,1,'C',0);
}else{
    $pdf->Cell(42, 7, utf8_decode('Tipo de Cliente'),1,0,'C',0);
    $pdf->Cell(30, 7, utf8_decode('Telefono'),1,0,'C',0);
    $pdf->Cell(60, 7, utf8_decode('Quien registro'),1,0,'C',0);
    $pdf->Cell(0, 7, utf8_decode('Cliente'),1,1,'C',0);
}

$pdf->SetFont('Arial','',$ajustes['size_body']);
$query_cliente = mysqli_query($conexion, "SELECT c.nombre, c.telefono, a.Tipo_cliente, u.name FROM so_clientes AS c INNER JOIN comicions AS a INNER JOIN users AS u WHERE c.comision_id = a.id AND c.user_id = u.id ORDER BY c.fecha_registro $acomodo");

if($ajustes['orientacion_hoja'] == 1){
    while($row_cliente = mysqli_fetch_array($query_cliente)){
        $pdf->Cell(45, 7, utf8_decode('Nuevo'),1,0,'C',0);
        $pdf->Cell(45, 7, utf8_decode('1234567890'),1,0,'C',0);
        $pdf->Cell(75, 7, utf8_decode('Quien registro'),1,0,'C',0);
        $pdf->Cell(0, 7, utf8_decode('Nombre Cliente'),1,1,'C',0);
    }
}else{
    while($row_cliente = mysqli_fetch_array($query_cliente)){
        $pdf->Cell(42, 7, utf8_decode('Nuevo'),1,0,'C',0);
        $pdf->Cell(30, 7, utf8_decode('1234567890'),1,0,'C',0);
        $pdf->Cell(60, 7, utf8_decode('Quien registro'),1,0,'C',0);
        $pdf->Cell(0, 7, utf8_decode('Nombre Cliente'),1,1,'C',0);
    }
}
$pdf->Ln(7);
$pdf->SetFont('Arial','',$ajustes['size_text']);
$pdf->MultiCell(0,5,utf8_decode($ajustes['texto_inferior_clientes']),0,$aling);

if($ajustes['hoja_tabla'] == 1){
    $pdf->AddPage();
}else{
    $pdf->Ln(10);
}

$pdf->SetFont('Arial','',$ajustes['size_text']);
$pdf->MultiCell(0,5,utf8_decode($ajustes['texto_superior_trabajador']),0,$aling);
$pdf->Ln(5);
$pdf->SetFont('Arial','B',$ajustes['size_head']);

$pdf->Cell(0,10,'Trabajadores',0,1,'C');
if($ajustes['orientacion_hoja'] == 1){
    $pdf->Cell(45, 7, utf8_decode('Tipo de Cliente'),1,0,'C',0);
    $pdf->Cell(45, 7, utf8_decode('Telefono'),1,0,'C',0);
    $pdf->Cell(75, 7, utf8_decode('Quien registro'),1,0,'C',0);
    $pdf->Cell(0, 7, utf8_decode('Cliente'),1,1,'C',0);
}else{
    $pdf->Cell(42, 7, utf8_decode('Tipo de Cliente'),1,0,'C',0);
    $pdf->Cell(30, 7, utf8_decode('Telefono'),1,0,'C',0);
    $pdf->Cell(60, 7, utf8_decode('Quien registro'),1,0,'C',0);
    $pdf->Cell(0, 7, utf8_decode('Cliente'),1,1,'C',0);
}

$pdf->SetFont('Arial','',$ajustes['size_body']);
$query_cliente = mysqli_query($conexion, "SELECT c.nombre, c.telefono, a.Tipo_cliente, u.name FROM so_clientes AS c INNER JOIN comicions AS a INNER JOIN users AS u WHERE c.comision_id = a.id AND c.user_id = u.id ORDER BY c.fecha_registro $acomodo");

if($ajustes['orientacion_hoja'] == 1){
    while($row_cliente = mysqli_fetch_array($query_cliente)){
        $pdf->Cell(45, 7, utf8_decode('Nuevo en crecimiento'),1,0,'C',0);
        $pdf->Cell(45, 7, utf8_decode('1234567890'),1,0,'C',0);
        $pdf->Cell(75, 7, utf8_decode('Quien registro'),1,0,'C',0);
        $pdf->Cell(0, 7, utf8_decode('Nombre Cliente'),1,1,'C',0);
    }
}else{
    while($row_cliente = mysqli_fetch_array($query_cliente)){
        $pdf->Cell(42, 7, utf8_decode('Nuevo en crecimiento'),1,0,'C',0);
        $pdf->Cell(30, 7, utf8_decode('1234567890'),1,0,'C',0);
        $pdf->Cell(60, 7, utf8_decode('Quien registro'),1,0,'C',0);
        $pdf->Cell(0, 7, utf8_decode('Nombre Cliente'),1,1,'C',0);
    }
}
$pdf->Ln(7);
$pdf->SetFont('Arial','',$ajustes['size_text']);
$pdf->MultiCell(0,5,utf8_decode($ajustes['texto_inferior_trabajador']),0,$aling);


$pdf->Output();
?>