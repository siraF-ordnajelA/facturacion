<?php
   session_start();
   
   if (isset($_SESSION['loggedin']) && isset($_SESSION['id_empleado']) && $_SESSION['loggedin'] == true) {
      $id_usuario = $_SESSION['id_empleado'];
   }
   else {
      header ('Location: acceso_denegado.html');
      exit;
   }
   
   $ahora = time();
   
   if ($ahora > $_SESSION['expire']) {
      session_destroy();
      echo "Su sesion a finalzado!.";
      echo "<a href='ingreso.php' target='_top'>[Volver a ingresar]</a>";
      exit;
   }

   include("conexiones/Conexiones.php");
   include("cabecera.php");

   //$fecha = date("Y") . date("m") . "01";
   
   $respuesta = mysqli_query($conexion, "call select_clientes(1)") or die(mysqli_error());
   $total = mysqli_num_rows($respuesta);
   $total2 = 0;
   $total3 = 0;
   $temporal = 0;
   $sw = 0;

   if(isset($_POST["cbo_clientes"]) and !isset($_POST["btn_busca"])){
      $id_cliente = $_POST['cbo_clientes'];
      $respuesta2 = mysqli_query($conexion2, "call select_estado_clientes($id_cliente, 1);") or die(mysqli_error());
      $total2 = mysqli_num_rows($respuesta2);
      $sw_color = 0;
      $sw = 0;
   }
   
   if(isset($_POST["btn_busca"])){
      $fecha1 = $_POST['fecha1'];
      $fecha2 = $_POST['fecha2'];
      $respuesta3 = mysqli_query($conexion3, "call busca_fecha_caja('$fecha1', '$fecha2', 1);") or die(mysqli_error());
      $total3 = mysqli_num_rows($respuesta3);
      $sw_color = 0;
      $sw = 1;
   }
?>
<html>
<head>
   <title>Estado de cuentas</title>
</head>

<script type="text/javascript">
   $(document).ready(function () {
      //combo_mes();
   });
   
   function combo_mes(){
      //var cbo_fecha = $('#cbo_mes');
      /*
      $.ajax({
         url: "conexiones/selecciona_mes.php",
         method: 'POST',
         dataType: "json",
         success: function (datos) {
               cbo_fecha.empty();
               cbo_fecha.append("<option value='0'>--Seleccione mes--</option>");
               $(datos).each(function (index, item) {
                  cbo_fecha.append($('<option/>', { value: item.fecha + '-01', text: item.fecha }));
               });
         },
         error: function () {
               alert("Hubo un error en la carga del mes!.");
         }
      });*/
   }
</script>

<body class="principal">
   <form id="form_caja" method="post" action="">
      <?php 
         if ($total > 0) {
            echo '<div class="contenedor_transp">';
            echo '<div class="form-row"><div class="form-group col-md-6">';
            echo '<label for="cbo_clientes">Seleccione cliente a visualizar:&nbsp;&nbsp;</label>';
            echo '<select class="propio form-control select2" id="cbo_clientes" name="cbo_clientes" onchange="this.form.submit()">';
            echo '<option>--Seleccione cliente--</option>';
            while ($fila = mysqli_fetch_array($respuesta)) {
               echo '<option value="' .$fila['id_cliente']. '">' .$fila['razon']. '</option>';
            }
            echo '</select>';
            echo '</div></div>';
         }
         else {
            echo '<div class="contenedor_transp">';
            echo '<br>A&uacute;n no existen clientes cargados en sistema o no existen movimientos de caja.';
            echo '</div>';
         }
         mysqli_close($conexion);
      ?>
      
         <div class="form-row">
            <div class="form-group col-md-12">
               <label>O consulte entre fechas:&nbsp;</label>
               <input type="date" class="propio" id="fecha1" name="fecha1" />&nbsp;<input type="date" class="propio" id="fecha2" name="fecha2" />
               &nbsp;&nbsp;<input type="submit" class="boton" id="btn_busca" name="btn_busca" value="Buscar" />
            </div>
         </div>
      </div>
      
      <?php
         $total_importe = 0;
         $total_iva = 0;
         $total_facturado = 0;
         $total_cobrado = 0;
         $saldo_final = 0;
         $deuda_total = 0;
         $tmp_nro_comprobante = 0;
      
         // BUSCA POR CLIENTE DEL COMBO DESPLEGABLE
         if ($total2 > 0) {
            echo '<table id="clientes" class="propio">';
            echo '<caption><center><label>ESTADO DE CUENTA</center></label></caption>';
            echo '<thead>';
            echo '<tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">RAZON</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">PTO. VENTA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">NRO. COMPROBANTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA FACTURA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA DE PAGO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">TIPO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IMPORTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IVA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">MONTO FACTURADO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">Ret./Pers. Seg. Social</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">Ret./Pers IVA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">SI.CO.RE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">Ret. de loc. de obra y/o servicios</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">Retenci&oacute;n por IIBB</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">COBRADO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">SALDO FACTURA</td></tr>';
            echo '</thead>';
            echo '<tbody>';
            while ($fila2 = mysqli_fetch_array($respuesta2)) {
               if ($sw_color == 0) {
                  echo '<tr>';
                  $razon = $fila2['razon'];
                  echo '<td align="center" class="propio1">' .$fila2['razon']. '</td>';
                  echo '<td align="center" class="propio1">00001</td>';
                  echo '<td align="center" class="propio1">' .$fila2['nro_comprobante']. '</td>';
                  echo '<td align="center" class="propio1">' .$fila2['fecha_factura']. '</td>';
                  echo '<td align="center" class="propio1">' .$fila2['fecha_pago']. '</td>';
                  echo '<td align="center" class="propio1">';
                     if ($fila2['id_tipo'] == 1) {echo 'A';}
                     if ($fila2['id_tipo'] == 2) {echo 'B';}
                     if ($fila2['id_tipo'] == 3) {echo 'C';}
                  echo '</td>';
                  echo '<td align="center" class="propio1">' .number_format($fila2['importe'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio1">' .number_format($fila2['iva'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio1">' .number_format($fila2['monto_facturado'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio1">' .number_format($fila2['carga1'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio1">' .number_format($fila2['carga2'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio1">' .number_format($fila2['carga3'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio1">' .number_format($fila2['carga4'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio1">' .number_format($fila2['carga5'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio1">' .number_format($fila2['cobrado_caja'], 2, ",", "."). '</td>';
                  if ($fila2['saldo_factura'] < 0) { echo '<td align="center" style="background-color:rgba(41, 217, 17, 0.6);">' .number_format($fila2['saldo_factura'], 2, ",", "."). '</td>';}
                  if ($fila2['saldo_factura'] == 0) { echo '<td align="center" class="propio1">' .number_format($fila2['saldo_factura'], 2, ",", "."). '</td>';}
                  if ($fila2['saldo_factura'] > 0) { echo '<td align="center" style="background-color:rgba(224, 0, 0, 0.6);">' .number_format($fila2['saldo_factura'], 2, ",", "."). '</td>';}
                  echo '</tr>';
                  if ($tmp_nro_comprobante != $fila2['nro_comprobante']) {
                     $total_importe = $total_importe + $fila2['importe'];
                     $total_iva = $total_iva + $fila2['iva'];
                     $total_facturado = $total_facturado + $fila2['importe'] + $fila2['iva'];
                     $deuda_total = $deuda_total + $fila2['saldo_factura'];
                  }
                  $total_cobrado = $total_cobrado + $fila2['cobrado_caja'];
                  //$total_cobrado = $total_cobrado + $fila2['cobrado_caja'];saldo_factura
                  //$saldo_final = $fila2['saldo_final'];
                  $sw_color = 1;
               }
               else {
                  echo '<tr>';
                  $razon = $fila2['razon'];
                  echo '<td align="center" class="propio2">' .$fila2['razon']. '</td>';
                  echo '<td align="center" class="propio2">00001</td>';
                  echo '<td align="center" class="propio2">' .$fila2['nro_comprobante']. '</td>';
                  echo '<td align="center" class="propio2">' .$fila2['fecha_factura']. '</td>';
                  echo '<td align="center" class="propio2">' .$fila2['fecha_pago']. '</td>';
                  echo '<td align="center" class="propio2">';
                     if ($fila2['id_tipo'] == 1) {echo 'A';}
                     if ($fila2['id_tipo'] == 2) {echo 'B';}
                     if ($fila2['id_tipo'] == 3) {echo 'C';}
                  echo '</td>';
                  echo '<td align="center" class="propio2">' .number_format($fila2['importe'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio2">' .number_format($fila2['iva'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio2">' .number_format($fila2['monto_facturado'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio2">' .number_format($fila2['carga1'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio2">' .number_format($fila2['carga2'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio2">' .number_format($fila2['carga3'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio2">' .number_format($fila2['carga4'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio2">' .number_format($fila2['carga5'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio2">' .number_format($fila2['cobrado_caja'], 2, ",", "."). '</td>';
                  if ($fila2['saldo_factura'] < 0) { echo '<td align="center" style="background-color:rgba(41, 217, 17, 0.6);">' .number_format($fila2['saldo_factura'], 2, ",", "."). '</td>';}
                  if ($fila2['saldo_factura'] == 0) { echo '<td align="center" class="propio2">' .number_format($fila2['saldo_factura'], 2, ",", "."). '</td>';}
                  if ($fila2['saldo_factura'] > 0) { echo '<td align="center" style="background-color:rgba(224, 0, 0, 0.6);">' .number_format($fila2['saldo_factura'], 2, ",", "."). '</td>';}
                  echo '</tr>';
                  if ($tmp_nro_comprobante != $fila2['nro_comprobante']) {
                     $total_importe = $total_importe + $fila2['importe'];
                     $total_iva = $total_iva + $fila2['iva'];
                     $total_facturado = $total_facturado + $fila2['importe'] + $fila2['iva'];
                     $deuda_total = $deuda_total + $fila2['saldo_factura'];
                  }
                  $total_cobrado = $total_cobrado + $fila2['cobrado_caja'];
                  $sw_color = 0;
               }
               $tmp_nro_comprobante = $fila2['nro_comprobante'];
            }
            echo '<tr><td colspan="9">&nbsp;</td></tr>';
            if ($total2 > 9) {
               echo '<tr><td colspan="5">&nbsp;</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IMPORTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IVA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">MONTO FACTURADO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">COBRADO</td></tr>';
            }
            echo '</tr>';
            echo '<td class="propio2" align="right"><b>SUBTOTALES</td></b><td colspan="4" class="propio2">&nbsp;</td><td class="propio2" align="center"><b>$' . number_format($total_importe, 2, ",", ".") . '</b></td><td class="propio2" align="center"><b>$' . number_format($total_iva, 2, ",", ".") . '</b></td><td class="propio2" align="center"><b>$' . number_format($total_facturado, 2, ",", ".") . '</b></td><td class="propio2" align="center"><b>$' . number_format($total_cobrado, 2, ",", ".") . '</b></td>';
            echo '</tr>';

            echo '</tbody>';
            echo '</table>';
            
            //$saldo_final = $total_facturado - $total_cobrado;
            
            if ($deuda_total < 0) {
               echo '<div class="titulo_verde"><b>DEUDA:&nbsp; $'. number_format($deuda_total, 2, ",", ".") .'</b></div>';
            }
            if ($deuda_total == 0) {
               echo '<div class="titulo_neutro"><b>DEUDA:&nbsp; $'. number_format($deuda_total, 2, ",", ".") .'</b></div>';
            }
            if ($deuda_total > 0) {
               echo '<div class="titulo"><b>DEUDA:&nbsp; $'. number_format($deuda_total, 2, ",", ".") .'</b></div>';
            }
            
            //echo '<div class="titulo"><b>DEUDA:&nbsp; $'. number_format($deuda_total, 2, ",", ".") .'</b></div>';
            echo '<br><br>';
            //Paso la rezón e Id de cliente y exporto PDF
            echo '<a class="boton" href="pdf_estado_cuenta.php?razon=' . $razon . '&id=' . $id_cliente . '&f1=0&f2=0 " target="_blank">Exportar a PDF</a>';
            echo '<br>';
            mysqli_close($conexion2);
         }
         else {
            if ($sw == 0) {
               echo '<h3>No existen movimientos.</h3>';
               mysqli_close($conexion2);
            }
         }
         
         // BUSQUEDA POR ENTRE FECHAS
         if ($total3 > 0) {
            $total_importe = 0;
            $total_iva = 0;
            $total_facturado = 0;
            $total_cobrado = 0;
            $saldo_final = 0;
            $tmp_nro_comprobante = 0;
            
            echo '<table id="clientes" class="propio">';
            echo '<caption><center><label>ESTADO DE CUENTA</center></label></caption>';
            echo '<thead>';
            echo '<tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">RAZON</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">PTO. VENTA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">NRO. COMPROBANTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA FACTURA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA DE PAGO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IMPORTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IVA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">MONTO FACTURADO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">COBRADO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">SALDO FACTURA</td></tr>';
            echo '</thead>';
            echo '<tbody>'; 
            while ($fila3 = mysqli_fetch_array($respuesta3)) {
               if ($sw_color == 0) {
                  echo '<tr>';
                  echo '<td align="center" class="propio1">' .$fila3['razon']. '</td>';
                  echo '<td align="center" class="propio1">00001</td>';
                  echo '<td align="center" class="propio1">' .$fila3['nro_comprobante']. '</td>';
                  echo '<td align="center" class="propio1">' .$fila3['fecha_factura']. '</td>';
                  echo '<td align="center" class="propio1">' .$fila3['fecha_pago']. '</td>';
                  echo '<td align="center" class="propio1">';
                     if ($fila3['id_tipo'] == 1) {echo 'A';}
                     if ($fila3['id_tipo'] == 2) {echo 'B';}
                     if ($fila3['id_tipo'] == 3) {echo 'C';}
                  echo '</td>';
                  echo '<td align="center" class="propio1">' .number_format($fila3['importe'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio1">' .number_format($fila3['iva'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio1">' .number_format($fila3['monto_facturado'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio1">' .number_format($fila3['cobrado_caja'], 2, ",", "."). '</td>';
                  //echo '<td align="center" class="propio1">' .number_format($fila3['saldo_factura'], 2, ",", "."). '</td>';
                  if ($fila3['saldo_factura'] < 0) { echo '<td align="center" style="background-color:rgba(41, 217, 17, 0.6);">' .number_format($fila3['saldo_factura'], 2, ",", "."). '</td>';}
                  if ($fila3['saldo_factura'] == 0) { echo '<td align="center" class="propio1">' .number_format($fila3['saldo_factura'], 2, ",", "."). '</td>';}
                  if ($fila3['saldo_factura'] > 0) { echo '<td align="center" style="background-color:rgba(224, 0, 0, 0.6);">' .number_format($fila3['saldo_factura'], 2, ",", "."). '</td>';}
                  echo '</tr>';
                  if ($tmp_nro_comprobante != $fila3['nro_comprobante']) {
                     $total_importe = $total_importe + $fila3['importe'];
                     $total_iva = $total_iva + $fila3['iva'];
                     $total_facturado = $total_facturado + $fila3['importe'] + $fila3['iva'];
                     $deuda_total = $deuda_total + $fila3['saldo_factura'];
                  }
                  $total_cobrado = $total_cobrado + $fila3['cobrado_caja'];
                  $sw_color = 1;
               }
               else {
                  echo '<tr>';
                  echo '<td align="center" class="propio2">' .$fila3['razon']. '</td>';
                  echo '<td align="center" class="propio2">00001</td>';
                  echo '<td align="center" class="propio2">' .$fila3['nro_comprobante']. '</td>';
                  echo '<td align="center" class="propio2">' .$fila3['fecha_factura']. '</td>';
                  echo '<td align="center" class="propio2">' .$fila3['fecha_pago']. '</td>';
                  echo '<td align="center" class="propio2">';
                     if ($fila3['id_tipo'] == 1) {echo 'A';}
                     if ($fila3['id_tipo'] == 2) {echo 'B';}
                     if ($fila3['id_tipo'] == 3) {echo 'C';}
                  echo '</td>';
                  echo '<td align="center" class="propio2">' .number_format($fila3['importe'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio2">' .number_format($fila3['iva'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio2">' .number_format($fila3['monto_facturado'], 2, ",", "."). '</td>';
                  echo '<td align="center" class="propio2">' .number_format($fila3['cobrado_caja'], 2, ",", "."). '</td>';
                  //echo '<td align="center" class="propio2">' .number_format($fila3['saldo_factura']. '</td>';
                  if ($fila3['saldo_factura'] < 0) { echo '<td align="center" style="background-color:rgba(41, 217, 17, 0.6);">' .number_format($fila3['saldo_factura'], 2, ",", "."). '</td>';}
                  if ($fila3['saldo_factura'] == 0) { echo '<td align="center" class="propio2">' .number_format($fila3['saldo_factura'], 2, ",", "."). '</td>';}
                  if ($fila3['saldo_factura'] > 0) { echo '<td align="center" style="background-color:rgba(224, 0, 0, 0.6);">' .number_format($fila3['saldo_factura'], 2, ",", "."). '</td>';}
                  echo '</tr>';
                  if ($tmp_nro_comprobante != $fila3['nro_comprobante']) {
                     $total_importe = $total_importe + $fila3['importe'];
                     $total_iva = $total_iva + $fila3['iva'];
                     $total_facturado = $total_facturado + $fila3['importe'] + $fila3['iva'];
                     $deuda_total = $deuda_total + $fila3['saldo_factura'];
                  }
                  $total_cobrado = $total_cobrado + $fila3['cobrado_caja'];
                  $sw_color = 0;
               }
               //$temporal = $fila3['saldo_final'];
               $tmp_nro_comprobante = $fila3['nro_comprobante'];
            }
            
            echo '<tr><td colspan="9">&nbsp;</td></tr>';
            
            if ($total3 > 9) {
               echo '<tr><td colspan="4">&nbsp;</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IMPORTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IVA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">MONTO FACTURADO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">COBRADO</td></tr>';
            }
            echo '</tr>';
            echo '<td class="propio2" align="right"><b>SUBTOTALES</td></b><td colspan="4" class="propio2">&nbsp;</td><td class="propio2" align="center"><b>$' . number_format($total_importe, 2, ",", ".") . '</b></td><td class="propio2" align="center"><b>$' . number_format($total_iva, 2, ",", ".") . '</b></td><td class="propio2" align="center"><b>$' . number_format($total_facturado, 2, ",", ".") . '</b></td><td class="propio2" align="center"><b>$' . number_format($total_cobrado, 2, ",", ".") . '</b></td>';
            echo '</tr>';

            echo '</tbody>';
            echo '</table>';
            
            //$saldo_final = $total_facturado - $total_cobrado;
            
            if ($deuda_total < 0) {
               echo '<div class="titulo_verde"><b>DEUDA:&nbsp; $'. number_format($deuda_total, 2, ",", ".") .'</b></div>';
            }
            if ($deuda_total == 0) {
               echo '<div class="titulo_neutro"><b>DEUDA:&nbsp; $'. number_format($deuda_total, 2, ",", ".") .'</b></div>';
            }
            if ($deuda_total > 0) {
               echo '<div class="titulo"><b>DEUDA:&nbsp; $'. number_format($deuda_total, 2, ",", ".") .'</b></div>';
            }
            //echo '<div class="titulo"><b>SALDO:&nbsp; $'. number_format($deuda_total, 2, ",", ".") .'</b></div>';
            echo '<br><br>';
            //Paso los datos de las fechas y exporto PDF
            echo '<a class="boton" href="pdf_estado_cuenta.php?id=0&razon=0&f1=' . $fecha1 . '&f2=' . $fecha2 . ' " target="_blank">Exportar a PDF</a>';
            echo '<br>';
            mysqli_close($conexion3);
         }
         else {
            if ($sw == 1){
               echo '<h3>No existen movimientos.</h3>';
               mysqli_close($conexion3);
            }
         }
      ?>
      <br>
   </form>
</body>