<?php
include("conexiones/Conexiones.php");
include('pdf_plantilla.php');

if (isset($_POST["rd_comprobantes"])) { //Valor del rd_comprobante. Tipo de factura, nota o cheque
   $rd_comprobante = $_POST["rd_comprobantes"];
}
$fecha1 = $_POST["fecha1"];
$fecha2 = $_POST["fecha2"];
$fecha1 = str_replace("-","",$fecha1);
$fecha2 = str_replace("-","",$fecha2);
$comprobante = $_POST["txt_comprobante"]; //Búsqueda por número de comprobate

$pdf = new PDF();
$pdf->AddPage('L'); // Use L to landscape position
$pdf->AliasNbPages();

$width_cell=array(50,32,20,12,20,18,20,22,22,62); // Array con el ancho de columnas


if (empty($comprobante)) {
   if (!empty($fecha1) && !empty($fecha2) && !empty($rd_comprobante)) {
      //OPCION 1. Tengo rd, fecha 1 y fecha 2. El numero de comprobante esta vacio.
      //call busca_comprobantes($opc, $tipo_comprobante, '$fecha1', '$fecha2', $nro_comprobante)
      if ($rd_comprobante == 1) {
         $query = "call busca_comprobantes(1, $rd_comprobante, '$fecha1', '$fecha2', 0);";
         $respuesta = mysqli_query($conexion, $query);
         
         $pdf->Ln(5);
         $pdf->SetFont('Arial','B',8);
      
         $pdf->Cell($width_cell[0],8,'RAZON', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[1],8,'NRO.COMPROBANTE', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[2],8,'FECHA', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[3],8,'TIPO', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[4],8,'IMPORTE', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[5],8,'IVA', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[6],8,'OPC. PAGO', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[7],8,'PAGO', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[8],8,'SALDO', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[9],8,'OBSERVACIONES', 1, 1, 'C', 0);
         
         $pdf->SetFont('Arial','',8);
         
         while ($fila = mysqli_fetch_array($respuesta)) {
            $pdf->Cell($width_cell[0],8,$fila['nombre'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[1],8,$fila['nro_comprobante'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[2],8,$fila['fecha'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[3],8,$fila['tipo_factura'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[4],8,$fila['importe'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[5],8,$fila['iva'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[6],8,$fila['opc_cobro_pago'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[7],8,$fila['tipo_pago'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[8],8,$fila['saldo'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[9],8,$fila['observaciones'], 1, 1, 'C', 0);
         }
      }
      
      if ($rd_comprobante == 2) {
         $query = "call busca_comprobantes(1, $rd_comprobante, '$fecha1', '$fecha2', 0);";
         $respuesta = mysqli_query($conexion, $query);
         
         $pdf->Ln(5);
         $pdf->SetFont('Arial','B',8);
      
         $pdf->Cell($width_cell[0],8,'PROVEEDOR', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[1],8,'NRO.COMPROBANTE', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[2],8,'FECHA', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[3],8,'TIPO', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[4],8,'IMPORTE', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[5],8,'IVA', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[6],8,'OPC. PAGO', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[9],8,'OBSERVACIONES', 1, 1, 'C', 0);
         
         $pdf->SetFont('Arial','',8);
         
         while ($fila = mysqli_fetch_array($respuesta)) {
            $pdf->Cell($width_cell[0],8,$fila['nombre'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[1],8,$fila['nro_comprobante'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[2],8,$fila['fecha'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[3],8,$fila['tipo_factura'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[4],8,$fila['importe'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[5],8,$fila['iva'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[6],8,$fila['opc_cobro_pago'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[9],8,$fila['observaciones'], 1, 1, 'C', 0);
         }
      }
      
      if ($rd_comprobante == 3) {
         $width_cell=array(25,25,50,25,25,60,62);
         
         $query = "call busca_comprobantes(1, $rd_comprobante, '$fecha1', '$fecha2', 0);";
         $respuesta = mysqli_query($conexion, $query);
         
         $pdf->Ln(5);
         $pdf->SetFont('Arial','B',8);
      
         $pdf->Cell($width_cell[0],8,'FECHA EMISION', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[1],8,'NRO.CHEQUE', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[2],8,'BANCO', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[3],8,'FECHA PAGO', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[4],8,'IMPORTE', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[5],8,'DESTINATARIO', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[6],8,'OBSERVACIONES', 1, 1, 'C', 0);
         
         $pdf->SetFont('Arial','',8);
         
         while ($fila = mysqli_fetch_array($respuesta)) {
            $pdf->Cell($width_cell[0],8,$fila['fecha_emision'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[1],8,$fila['nro_cheque'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[2],8,$fila['nombre_banco'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[3],8,$fila['fecha_pago'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[4],8,$fila['importe'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[5],8,$fila['destinatario'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[6],8,$fila['observaciones'], 1, 1, 'C', 0);
         }
      }
      
      $pdf->Output();
   }
   else {
      echo 'Falta completar alguna fecha o seleccionar el tipo de comprobante';
   }
}
else {
   if (!empty($comprobante)) {
      //OPCION 2. Consulta por numero de comprobante
      if ($rd_comprobante == 1) {
         $query = "call busca_comprobantes(2, $rd_comprobante, '20000101', '20000101', $comprobante);";
         $respuesta = mysqli_query($conexion, $query);
         
         $pdf->Ln(5);
         $pdf->SetFont('Arial','B',8);
      
         $pdf->Cell($width_cell[0],8,'RAZON', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[1],8,'NRO.COMPROBANTE', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[2],8,'FECHA', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[3],8,'TIPO', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[4],8,'IMPORTE', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[5],8,'IVA', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[6],8,'OPC. PAGO', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[7],8,'PAGO', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[8],8,'SALDO', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[9],8,'OBSERVACIONES', 1, 1, 'C', 0);
         
         $pdf->SetFont('Arial','',8);
         
         while ($fila = mysqli_fetch_array($respuesta)) {
            $pdf->Cell($width_cell[0],8,$fila['nombre'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[1],8,$fila['nro_comprobante'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[2],8,$fila['fecha'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[3],8,$fila['tipo_factura'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[4],8,$fila['importe'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[5],8,$fila['iva'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[6],8,$fila['opc_cobro_pago'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[7],8,$fila['tipo_pago'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[8],8,$fila['saldo'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[9],8,$fila['observaciones'], 1, 1, 'C', 0);
         }
      }
      
      if ($rd_comprobante == 2) {
         $query = "call busca_comprobantes(2, $rd_comprobante, '20000101', '20000101', $comprobante);";
         $respuesta = mysqli_query($conexion, $query);
         
         $pdf->Ln(5);
         $pdf->SetFont('Arial','B',8);
      
         $pdf->Cell($width_cell[0],8,'PROVEEDOR', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[1],8,'NRO.COMPROBANTE', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[2],8,'FECHA', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[3],8,'TIPO', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[4],8,'IMPORTE', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[5],8,'IVA', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[6],8,'OPC. PAGO', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[9],8,'OBSERVACIONES', 1, 1, 'C', 0);
         
         $pdf->SetFont('Arial','',8);
         
         while ($fila = mysqli_fetch_array($respuesta)) {
            $pdf->Cell($width_cell[0],8,$fila['nombre'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[1],8,$fila['nro_comprobante'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[2],8,$fila['fecha'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[3],8,$fila['tipo_factura'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[4],8,$fila['importe'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[5],8,$fila['iva'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[6],8,$fila['opc_cobro_pago'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[9],8,$fila['observaciones'], 1, 1, 'C', 0);
         }
      }
      
      if ($rd_comprobante == 3) {
         $query = "call busca_comprobantes(2, $rd_comprobante, '20000101', '20000101', $comprobante);";
         $respuesta = mysqli_query($conexion, $query);
         
         $width_cell=array(25,25,50,25,25,60,62);
         
         $pdf->Ln(5);
         $pdf->SetFont('Arial','B',8);
      
         $pdf->Cell($width_cell[0],8,'FECHA EMISION', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[1],8,'NRO.CHEQUE', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[2],8,'BANCO', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[3],8,'FECHA PAGO', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[4],8,'IMPORTE', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[5],8,'DESTINATARIO', 1, 0, 'C', 0);
         $pdf->Cell($width_cell[6],8,'OBSERVACIONES', 1, 1, 'C', 0);
         
         $pdf->SetFont('Arial','',8);
         
         while ($fila = mysqli_fetch_array($respuesta)) {
            $pdf->Cell($width_cell[0],8,$fila['fecha_emision'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[1],8,$fila['nro_cheque'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[2],8,$fila['nombre_banco'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[3],8,$fila['fecha_pago'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[4],8,$fila['importe'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[5],8,$fila['destinatario'], 1, 0, 'C', 0);
            $pdf->Cell($width_cell[6],8,$fila['observaciones'], 1, 1, 'C', 0);
         }
      }
      
      $pdf->Output();
   }
   else {
      echo 'Debe completar los campos';
   }
}
?>