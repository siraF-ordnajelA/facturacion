<?php
include("conexiones/Conexiones.php");
include('pdf_plantilla.php');

$fecha1 = $_GET['f1'];
$fecha2 = $_GET['f2'];
$fecha1 = str_replace("-","",$fecha1);
$fecha2 = str_replace("-","",$fecha2);

//$pdf->SetFillColor(230, 52, 74, 0.8); // Background color of header
//$pdf->SetTextColor(255, 255, 255); // Text color

$respuesta = mysqli_query($conexion, "call busca_estado_caja('$fecha1', '$fecha2');") or die(mysqli_error());
//$fila = mysqli_fetch_array($respuesta);
$total = mysqli_num_rows($respuesta);

if ($total > 0) {
   $pdf = new PDF();
   $pdf->AddPage('L'); // Use L to landscape position
   $pdf->AliasNbPages();
   
   $width_cell=array(40,25,32,32,25,25,25,30,30); // Array con el ancho de columnas
   
   $pdf->Ln(5);

   $pdf->SetFont('Arial','B',8);

   $pdf->Cell(10,8,'', 0, 0, 'C', 0);
   $pdf->Cell($width_cell[0],8,'TOTAL IMPORTE', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[1],8,'IVA', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[2],8,'TOTAL FACTURADO', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[3],8,'TOTAL COBRADO', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[4],8,'SEG. SOCIAL', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[5],8,'CARGAS IVA', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[6],8,'GANANCIAS', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[7],8,'TOTAL CARGAS', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[8],8,'RESTA', 1, 1, 'C', 0);

   $pdf->SetFont('Arial','',11);
   while ($fila = mysqli_fetch_array($respuesta)) {
      $pdf->Cell(10,8,'', 0, 0, 'C', 0);
      $pdf->Cell($width_cell[0],8,$fila['Facturado'], 1, 0, 'C', 0);
      $pdf->Cell($width_cell[1],8,$fila['Iva'], 1, 0, 'C', 0);
      $pdf->Cell($width_cell[2],8,$fila['Total'], 1, 0, 'C', 0);
      $pdf->Cell($width_cell[3],8,$fila['Ganancias'], 1, 0, 'C', 0);
      $pdf->Cell($width_cell[4],8,$fila['cargas1'], 1, 0, 'C', 0);
      $pdf->Cell($width_cell[5],8,$fila['cargas2'], 1, 0, 'C', 0);
      $pdf->Cell($width_cell[6],8,$fila['cargas3'], 1, 0, 'C', 0);
      $pdf->Cell($width_cell[7],8,$fila['total_carga'], 1, 0, 'C', 0);
      $pdf->Cell($width_cell[8],8,$fila['Saldos'], 1, 1, 'C', 0);
   }
   
   $pdf->Output();
}
else {
   echo '<script>alert("No existen registros.");</script>';
}
?>