<?php
include("conexiones/Conexiones.php");
include('pdf_plantilla.php');

$id_cliente = $_GET['id'];
$razon = $_GET['razon'];
$fecha1 = $_GET['f1'];
$fecha2 = $_GET['f2'];

$tmp_nro_comprobante = 0;
$subtotal_importe = 0;
$subtotal_iva = 0;
$subtotal_facturado = 0;
$subtotal_cobrado = 0;
$deuda_total = 0;
//$saldo = 0;

$pdf = new PDF();
$pdf->AddPage('L'); // Use L to landscape position
$pdf->AliasNbPages();

//$pdf->SetFillColor(230, 52, 74, 0.8); // Background color of header
//$pdf->SetTextColor(255, 255, 255); // Text color

if ($id_cliente > 0) {
   $respuesta = mysqli_query($conexion, "call select_estado_clientes($id_cliente, 1);") or die(mysqli_error());
   
   $width_cell=array(45,32,27,30,20,18,32,18,22,30,35); // Array con el ancho de columnas
   $pdf->SetFont('Arial','B',12);
   
   $pdf->Ln(5);
   $pdf->Cell(0, 0, $razon, 0, 1, 'C', 0);
   $pdf->Ln(10);

   $pdf->SetFont('Arial','B',8);

   $pdf->Cell(10,8,'', 0, 0, 'C', 0);
   $pdf->Cell($width_cell[1],8,'NRO.COMPROBANTE', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[2],8,'FECHA FACTURA', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[3],8,'FECHA PAGO', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[4],8,'IMPORTE', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[5],8,'IVA', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[6],8,'MONTO FACTURADO', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[7],8,'COBRADO', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[8],8,'SALDO FACT.', 1, 1, 'C', 0);
   //$pdf->Cell($width_cell[9],8,'SALDO CLIENTE', 1, 0, 'C', 0);
   //$pdf->Cell($width_cell[10],8,'SALDO CAJA', 1, 1, 'C', 0);

   $pdf->SetFont('Arial','',8);
   while ($fila = mysqli_fetch_array($respuesta)) {
      $pdf->Cell(10,8,'', 0, 0, 'C', 0);
      $pdf->Cell($width_cell[1],8,$fila['nro_comprobante'], 1, 0, 'C', 0);
      $pdf->Cell($width_cell[2],8,$fila['fecha_factura'], 1, 0, 'C', 0);
      $pdf->Cell($width_cell[3],8,$fila['fecha_pago'], 1, 0, 'C', 0);
      $pdf->Cell($width_cell[4],8,number_format($fila['importe'], 2, ",", "."), 1, 0, 'C', 0);
      if ($tmp_nro_comprobante != $fila['nro_comprobante']) { $subtotal_importe = $subtotal_importe + $fila['importe']; }
      $pdf->Cell($width_cell[5],8,number_format($fila['iva'], 2, ",", "."), 1, 0, 'C', 0);
      if ($tmp_nro_comprobante != $fila['nro_comprobante']) { $subtotal_iva = $subtotal_iva + $fila['iva']; }
      $pdf->Cell($width_cell[6],8,number_format($fila['monto_facturado'], 2, ",", "."), 1, 0, 'C', 0);
      if ($tmp_nro_comprobante != $fila['nro_comprobante']) { $subtotal_facturado = $subtotal_facturado + $fila['monto_facturado']; }
      $pdf->Cell($width_cell[7],8,number_format($fila['cobrado_caja'], 2, ",", "."), 1, 0, 'C', 0);
      if ($tmp_nro_comprobante != $fila['nro_comprobante']) { $deuda_total = $deuda_total + $fila['saldo_factura']; }
      $subtotal_cobrado = $subtotal_cobrado + $fila['cobrado_caja'];
      $pdf->Cell($width_cell[8],8,number_format($fila['saldo_factura'], 2, ",", "."), 1, 1, 'C', 0);
      
      $tmp_nro_comprobante = $fila['nro_comprobante'];
      /*
      if ($fila['saldo_cliente'] < 0) { $pdf->Cell($width_cell[9],8,$fila['saldo_cliente'], 1, 0, 'C', 0); }
      if ($fila['saldo_cliente'] == 0) { $pdf->Cell($width_cell[9],8,$fila['saldo_cliente'], 1, 0, 'C', 0); }
      if ($fila['saldo_cliente'] > 0) { $pdf->Cell($width_cell[9],8,$fila['saldo_cliente'], 1, 0, 'C', 0); }
      $pdf->Cell($width_cell[10],8,$fila['saldo_final'], 1, 1, 'C', 0);
      */
   }
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(10,8,'', 0, 0, 'C', 0);
   $pdf->Cell($width_cell[1],8,'', 0, 0, 'C', 0);
   $pdf->Cell($width_cell[2],8,'', 0, 0, 'C', 0);
   $pdf->Cell($width_cell[3],8,'SUBTOTAL:', 0, 0, 'C', 0);
   $pdf->Cell($width_cell[4],8,number_format($subtotal_importe, 2, ",", "."), 1, 0, 'C', 0);
   $pdf->Cell($width_cell[5],8,number_format($subtotal_iva, 2, ",", "."), 1, 0, 'C', 0);
   $pdf->Cell($width_cell[6],8,number_format($subtotal_facturado, 2, ",", "."), 1, 0, 'C', 0);
   $pdf->Cell($width_cell[7],8,number_format($subtotal_cobrado, 2, ",", "."), 1, 0, 'C', 0);
   $pdf->Cell($width_cell[8],8,'', 0, 1, 'C', 0);
}
else {
   $fecha1 = str_replace("-","",$fecha1);
   $fecha2 = str_replace("-","",$fecha2);
   $respuesta = mysqli_query($conexion, "call busca_fecha_caja('$fecha1', '$fecha2', 1);") or die(mysqli_error());
   
   $width_cell=array(72,32,27,30,22,20,32,18,22,25,22); // Array con el ancho de columnas
   $pdf->Ln(5);
   $pdf->SetFont('Arial','B',8);
   
   $pdf->Cell($width_cell[0],8,'RAZON', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[1],8,'NRO.COMPROBANTE', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[2],8,'FECHA FACTURA', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[3],8,'FECHA PAGO', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[4],8,'IMPORTE', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[5],8,'IVA', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[6],8,'MONTO FACTURADO', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[7],8,'COBRADO', 1, 0, 'C', 0);
   $pdf->Cell($width_cell[8],8,'SALDO FACT.', 1, 1, 'C', 0);
   //$pdf->Cell($width_cell[9],8,'SALDO CLIENTE', 1, 0, 'C', 0);
   //$pdf->Cell($width_cell[10],8,'SALDO CAJA', 1, 1, 'C', 0);

   $pdf->SetFont('Arial','',8);
   
   while ($fila = mysqli_fetch_array($respuesta)) {
      $pdf->Cell($width_cell[0],8,substr($fila['razon'], 0, 40), 1, 0, 'C', 0);
      $pdf->Cell($width_cell[1],8,$fila['nro_comprobante'], 1, 0, 'C', 0);
      $pdf->Cell($width_cell[2],8,$fila['fecha_factura'], 1, 0, 'C', 0);
      $pdf->Cell($width_cell[3],8,$fila['fecha_pago'], 1, 0, 'C', 0);
      $pdf->Cell($width_cell[4],8,number_format($fila['importe'], 2, ",", "."), 1, 0, 'C', 0);
      if ($tmp_nro_comprobante != $fila['nro_comprobante']) { $subtotal_importe = $subtotal_importe + $fila['importe']; }
      $pdf->Cell($width_cell[5],8,number_format($fila['iva'], 2, ",", "."), 1, 0, 'C', 0);
      if ($tmp_nro_comprobante != $fila['nro_comprobante']) { $subtotal_iva = $subtotal_iva + $fila['iva']; }
      $pdf->Cell($width_cell[6],8,number_format($fila['monto_facturado'], 2, ",", "."), 1, 0, 'C', 0);
      if ($tmp_nro_comprobante != $fila['nro_comprobante']) { $subtotal_facturado = $subtotal_facturado + $fila['monto_facturado']; }
      $pdf->Cell($width_cell[7],8,number_format($fila['cobrado_caja'], 2, ",", "."), 1, 0, 'C', 0);
      if ($tmp_nro_comprobante != $fila['nro_comprobante']) { $deuda_total = $deuda_total + $fila['saldo_factura']; }
      $subtotal_cobrado = $subtotal_cobrado + $fila['cobrado_caja'];
      $pdf->Cell($width_cell[8],8,number_format($fila['saldo_factura'], 2, ",", "."), 1, 1, 'C', 0);
      //$pdf->Cell($width_cell[9],8,$fila['saldo_cliente'], 1, 0, 'C', 0);
      //$pdf->Cell($width_cell[10],8,$fila['saldo_final'], 1, 1, 'C', 0);
      
      $tmp_nro_comprobante = $fila['nro_comprobante'];
   }
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell($width_cell[0],8,'', 0, 0, 'C', 0);
   $pdf->Cell($width_cell[1],8,'', 0, 0, 'C', 0);
   $pdf->Cell($width_cell[2],8,'', 0, 0, 'C', 0);
   $pdf->Cell($width_cell[3],8,'SUBTOTAL:', 0, 0, 'C', 0);
   $pdf->Cell($width_cell[4],8,number_format($subtotal_importe, 2, ",", "."), 1, 0, 'C', 0);
   $pdf->Cell($width_cell[5],8,number_format($subtotal_iva, 2, ",", "."), 1, 0, 'C', 0);
   $pdf->Cell($width_cell[6],8,number_format($subtotal_facturado, 2, ",", "."), 1, 0, 'C', 0);
   $pdf->Cell($width_cell[7],8,number_format($subtotal_cobrado, 2, ",", "."), 1, 0, 'C', 0);
   $pdf->Cell($width_cell[8],8,'', 0, 1, 'C', 0);
}

if ($id_cliente > 0 OR $fecha1 != "") {
   //$saldo = $subtotal_facturado - $subtotal_cobrado;

   $pdf->Ln(15);
   $pdf->SetFont('Arial','B',14);
   $pdf->Cell(0, 0, 'DEUDA: $' . number_format($deuda_total, 2, ",", "."), 0, 1, 'L', 0);
}

$pdf->Output();
?>