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

$id_venta = $_GET['id'];
$indicador_venta = $_GET['indicador'];

require('../libreria/fpdf/fpdf.php');
include('../conexion/conexion.php');

$query_venta = mysqli_query($conexion, "SELECT * FROM ventas WHERE id = '$id_venta'");
$venta = mysqli_fetch_assoc($query_venta);

$fecha_s = $venta['fecha'];
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

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        $id_venta = $_GET['id'];
        include('../conexion/conexion.php');
        $query_venta = mysqli_query($conexion, "SELECT * FROM ventas WHERE id = '$id_venta'");
        $venta = mysqli_fetch_assoc($query_venta);

        $fecha_s = $venta['fecha'];
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
            $this->Image('../img/logo.png',10,8,33);
        // Arial bold 15
        $this->SetFont('Arial','B',18);
        // Movernos a la derecha
        $this->Cell(60);
        // Título
        $this->Cell(75,10,'Factura de venta',0,0,'C');
        // Salto de línea
        $this->Ln(20);
        $aling_fecha = 'R';
        $this->SetFont('Arial','B','12');
        $this->Cell(0,7,utf8_decode('Fecha: '.$fecha),0,1,$aling_fecha);
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
$query_venta = mysqli_query($conexion, "SELECT v.fecha, v.total, v.autorizauser_id, u.name, c.nombre, c.correo, v.factura, v.comision_id, v.fpago_id, v.CVyFP, v.descripcion, v.devoluciones FROM ventas AS v INNER JOIN clientes AS c INNER JOIN users AS u WHERE v.id = '$id_venta' AND v.cliente_id = c.id AND v.user_id = u.id");
$row_venta = mysqli_fetch_assoc($query_venta);
$cliente = $row_venta['nombre'];
$correo = $row_venta['correo'];
$descripcion = $row_venta['descripcion'];

$pdf = new PDF();
$pdf->__construct('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','','15');
$pdf->SetTextColor(255,0,0);
$pdf->Cell(0,10,'No. de Venta: '.$id_venta,1,1,'R',0);
$pdf->SetFont('Arial','','13');
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0,10,'Cliente: '.$cliente,1,1,'L',0);
$pdf->Cell(0,10,'Correo: '.$correo,1,1,'L',0);
$pdf->Ln(3);

$pdf->SetFont('Arial','B','12');
$pdf->Cell(30,10,'Cantidad',1,0,'C',0);
$pdf->Cell(100,10,'Concepto/Producto',1,0,'C',0);
$pdf->Cell(28,10,'Precio',1,0,'C',0);
$pdf->Cell(0,10,'Importe',1,1,'C',0);
$pdf->SetFont('Arial','','12');
$query_productos = mysqli_query($conexion, "SELECT v.cantidad, p.producto, v.total, v.vendedor_id, p.precio, p.descripcion, p.codigo_producto FROM venta_cuentas AS v INNER JOIN productos AS p WHERE v.indicador_venta = '$indicador_venta' AND v.producto_id = p.id");
while($row_productos = mysqli_fetch_array($query_productos)){
    $pdf->Cell(30,10,utf8_decode($row_productos['cantidad']),1,0,'C',0);
    $pdf->Cell(100,10,utf8_decode($row_productos['producto']),1,0,'C',0);
    $pdf->Cell(28,10,'$'.utf8_decode($row_productos['precio']),1,0,'C',0);
    $pdf->Cell(0,10,'$'.utf8_decode($row_productos['total']),1,1,'C',0);
}
$query_total = mysqli_query($conexion, "SELECT SUM(total) AS total FROM venta_cuentas WHERE indicador_venta = '$indicador_venta'");
$row_total = mysqli_fetch_assoc($query_total);
$pdf->Cell(143,10,'Observaciones: '.utf8_decode($descripcion),1,0,'L',0);
$pdf->Cell(15,10,'Total',1,0,'C',0);
$pdf->Cell(0,10,'$'.utf8_decode($row_total['total']),1,1,'C',0);;
$pdf->Output();
?>