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
   include("cabecera.html");

   $fecha = date("Y") . date("m") . "01";
   
   $respuesta = mysqli_query($conexion, "call select_caja('$fecha')") or die(mysqli_error());
   $respuesta2 = mysqli_query($conexion2, "call select_admin_clientes") or die(mysqli_error());
   //$respuesta3 = mysqli_query($conexion3, "call select_comprobantes") or die(mysqli_error());
   $total = mysqli_num_rows($respuesta);
   $sw_color = 0;
?>
<html>
<head>
   <title>Caja</title>
</head>

<script language="JavaScript" type="text/javascript" src="Jawas/jawa.js"></script>
<script language="JavaScript" type="text/javascript" src="Jawas/jquery-3.5.1.min.js"></script>

<script type="text/javascript">
   $(document).ready(function () {
      
   });
</script>

<form id="form_caja" method="post" action="">
   <body class="principal">
      <div id="container">
         <h4>Agregar movimiento de Caja</h4>
         <table width="100%" border="0">
            <tr>
               <td align="center" colspan="2">&nbsp;</td>
               <td align="center">INGRESO/EGRESO</td>
               <td align="center">NRO.COMPROBANTE</td>
               <td align="center" colspan="2">&nbsp;</td>
            </tr>
            <tbody>
               <tr>
                  <td align="center" colspan="2">&nbsp;</td>
                  <td align="center">
                     <select id="cbo_tipo" onchange="select_comprobante();">
                        <option value="0">--Seleccione Movimiento--</option>
                        <option value="1">Factura Emitida</option>
                        <option value="2">Factura Recibida</option>
                        <option value="3">Cheque</option>
                        <option value="4">Nota de cr&eacute;dito/d&eacute;bito</option>
                     </select>
                  </td>
                  <td align="center">
                     <select id="cbo_comprobantes" onchange="select_datos_comprobante();" disabled>
                        <option value="0">--Seleccione tipo Ingreso/Egreso--</option>
                     </select>
                  </td>
                  <td align="center" colspan="2">&nbsp;</td>
               </tr>
               <tr>
                  <td colspan="6">&nbsp;</td>
               </tr>
               <tr>
                  <td align="center">
                           <td align="left"><span id="txt_cliente" hidden></span></td>
                           <td align="right"><span id="txt_importe" hidden></span></td>
                           <td align="right"><span id="txt_iva" hidden></span></td>
                           <td align="left"></td>
                           <td align="right"><span id="txt_total" hidden></span></td>
                           <td align="left"></td>
                  </td>
               </tr>
               <tr>
                  <td colspan="6">&nbsp;</td>
               </tr>
               <tr>
                  <td>&nbsp;</td>
                  <td align="right">COBRADO:&nbsp;</td>
                  <td align="left"><input type="number" id="txt_cobrado" maxlength="9" /></td>
                  <td align="right">PAGADO:&nbsp;</td>
                  <td align="left"><input type="number" id="txt_pagado" maxlength="9" /></td>
                  <td>&nbsp;</td>
               </tr>
               <tr>
                  <td colspan="6">&nbsp;</td>
               </tr>
               <tr>
                  <td align="right">SEGURO SOCIAL:&nbsp;</td>
                  <td align="left"><input type="number" id="txt_carga1" maxlength="9" /></td>
                  <td align="right">IVA:&nbsp;</td>
                  <td align="left"><input type="number" id="txt_carga2" maxlength="9" /></td>
                  <td align="right">GANANCIAS:&nbsp;</td>
                  <td align="left"><input type="number" id="txt_carga3" maxlength="9" /></td>
               </tr>
               <tr>
                  <td colspan="6">&nbsp;</td>
               </tr>
               <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="center">MEDIO</td>
                  <td align="center">PAGO</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
               </tr>
               <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="center">
                     <select id="cbo_medio">
                        <option value="0">--Seleccione medio--</option>
                        <option value="1">Transferencia</option>
                        <option value="2">Cheque</option>
                        <option value="3">Efectivo</option>
                     </select>
                  </td>
                  <td align="center">
                     <select id="cbo_pago">
                        <option value="0">--Seleccione pago--</option>
                        <option value="1">Total</option>
                        <option value="2">Parcial</option>
                     </select>
                  </td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
               </tr>
               <tr>
                  <td colspan="8">&nbsp;</td>
               </tr>
               <tr>
                  <td align="center" colspan="8">OBSERVACIONES</td>
               </tr>
                  <td align="center" colspan="8">
                     <textarea id="txt_obs" name="txt_obs" rows="4" cols="70"></textarea>
                  </td>
               </tr>
               <tr>
                  <td colspan="8">&nbsp;</td>
               </tr>
               <tr>
                  <td align="center" colspan="8"><input type="button" class="boton" id="btn_agregar" name="btn_agregar" onclick="guardar_caja(<?php echo $id_usuario; ?>);" value="Agregar" />&nbsp;&nbsp;<input type="submit" class="boton" id="btn_limpiar" name="btn_limpiar" value="Limpiar" /></td>
               </tr>
            </tbody>
         </table>
         <br>
         <div>
         <?php 
            if ($total > 0) {
               echo '<table id="caja">';
               echo '<caption>CAJA MES '. date("m") .'/'. date("Y") .'</caption>';
               echo '<thead>';
               echo '<tr><td align="center" style="background-color:rgba(165, 23, 23, 0.5);">#</td><td align="center" style="background-color:rgba(165, 23, 23, 0.5);">FECHA INGRESO</td><td align="center" style="background-color:rgba(165, 23, 23, 0.5);">USUARIO</td><td align="center" style="background-color:rgba(165, 23, 23, 0.5);">CLIENTE</td><td align="center" style="background-color:rgba(165, 23, 23, 0.5);">MONTO FACTURADO</td><td align="center" style="background-color:rgba(165, 23, 23, 0.5);">COBRADO</td><td align="center" style="background-color:rgba(165, 23, 23, 0.5);">PAGADO</td><td align="center" style="background-color:rgba(165, 23, 23, 0.5);">SALDO</td><td align="center" style="background-color:rgba(165, 23, 23, 0.5);">MEDIO</td><td align="center" style="background-color:rgba(165, 23, 23, 0.5);">SEG.SOCIAL</td><td align="center" style="background-color:rgba(165, 23, 23, 0.5);">IVA</td><td align="center" style="background-color:rgba(165, 23, 23, 0.5);">GANANCIAS</td><td align="center" style="background-color:rgba(165, 23, 23, 0.5);">TOTAL CARGAS</td><td align="center" style="background-color:rgba(165, 23, 23, 0.5);">OBSERVACIONES</td><td align="center" style="background-color:rgba(165, 23, 23, 0.5);">APROBADO</td><td colspan="2" style="background-color:rgba(165, 23, 23, 0.5);">&nbsp;</td></tr>';
               echo '</thead>';
               echo '<tbody>';
               $total = 0;
               while ($fila = mysqli_fetch_array($respuesta)) {
                  $total = $total + 1;
                  if ($sw_color == 0) {
                     echo '<tr>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.3);">' .$total. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.3);">' .$fila['fecha_ingreso']. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.3);">' .$fila['usuario']. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.3);">' .$fila['razon']. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.3);">' .$fila['TOTAL']. '</td>';
                     echo '<td align="center" id="txt_cobrado_' .$fila['id_caja']. '" contenteditable="true" style="background-color:rgba(41, 97, 132, 0.3);">' .$fila['cobrado']. '</td>';
                     echo '<td align="center" id="txt_pagado_' .$fila['id_caja']. '" contenteditable="true" style="background-color:rgba(41, 97, 132, 0.3);">' .$fila['pagado']. '</td>';
                     if ($fila['saldo'] < 0) { echo '<td align="center" id="txt_saldo_' .$fila['id_caja']. '" style="background-color:rgba(41, 217, 17, 0.6);">' .$fila['saldo']. '</td>';}
                     if ($fila['saldo'] == 0) { echo '<td align="center" id="txt_saldo_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.3);">' .$fila['saldo']. '</td>';}
                     if ($fila['saldo'] > 0) { echo '<td align="center" id="txt_saldo_' .$fila['id_caja']. '" style="background-color:rgba(224, 0, 0, 0.6);">' .$fila['saldo']. '</td>';}
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.3);"><select id="cbo_cobro_"' .$fila['id_caja']. '">';
                     if ($fila['medio'] == 1){echo '<option value="1" selected>Transferencia</option>';} else {echo '<option value="1">Transferencia</option>';}
                     if ($fila['medio'] == 2){echo '<option value="2" selected>Cheque</option>';} else {echo '<option value="2">Cheque</option>';}
                     if ($fila['medio'] == 3){echo '<option value="3" selected>Efectivo</option>';} else {echo '<option value="3">Efectivo</option>';}
                     echo '</select></td>';
                     echo '<td align="center" id="txt_carga1_' .$fila['id_caja']. '" contenteditable="true" style="background-color:rgba(41, 97, 132, 0.3);">' .$fila['carga1']. '</td>';
                     echo '<td align="center" id="txt_carga2_' .$fila['id_caja']. '" contenteditable="true" style="background-color:rgba(41, 97, 132, 0.3);">' .$fila['carga2']. '</td>';
                     echo '<td align="center" id="txt_carga3_' .$fila['id_caja']. '" contenteditable="true" style="background-color:rgba(41, 97, 132, 0.3);">' .$fila['carga3']. '</td>';
                     echo '<td align="center" id="txt_total_cargas_' .$fila['id_caja']. '" contenteditable="true" style="background-color:rgba(41, 97, 132, 0.3);">' .$fila['total_cargas']. '</td>';
                     echo '<td align="center" id="txt_observaciones_' .$fila['id_caja']. '" contenteditable="true" style="background-color:rgba(41, 97, 132, 0.3);">' .$fila['observaciones']. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.3);">' .$fila['confirmacion']. '</td>';
                     echo '<td style="background-color:rgba(41, 97, 132, 0.3);"><input type="button" id="btn_modifica" onclick="caja_edita('. $fila['id_caja'] .');" value="Modificar"</td>';
                     //echo '<td><a href="#" id="btn_modifica" onclick="caja_edita('. $fila['id_caja'] .');"><img src="imagenes/small_modify_icon.png" /></a>&nbsp;<a href="#" id="btn_check" onclick="caja_aprueba('. $fila['id_caja'] .');"><img src="imagenes/small_check_green_icon.png" /></a>&nbsp;<a href="#" id="btn_cancel" onclick="caja_desaprueba('. $fila['id_caja'] .');"><img src="imagenes/small_cancel_red_icon.png" /></a></td>';
                     echo '</tr>';
                     $sw_color = 1;
                  }
                  else {
                     //echo '<td align="center">' .$fila['id_administrador']. '</td>';
                     echo '<tr>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);">' .$total. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);">' .$fila['fecha_ingreso']. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);">' .$fila['usuario']. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);">' .$fila['razon']. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);">' .$fila['TOTAL']. '</td>';
                     echo '<td align="center" id="txt_cobrado_' .$fila['id_caja']. '" contenteditable="true" style="background-color:rgba(41, 97, 132, 0.6);">' .$fila['cobrado']. '</td>';
                     echo '<td align="center" id="txt_pagado_' .$fila['id_caja']. '" contenteditable="true" style="background-color:rgba(41, 97, 132, 0.6);">' .$fila['pagado']. '</td>';
                     if ($fila['saldo'] < 0) { echo '<td align="center" id="txt_saldo_' .$fila['id_caja']. '" style="background-color:rgba(41, 217, 17, 0.6);">' .$fila['saldo']. '</td>';}
                     if ($fila['saldo'] == 0) { echo '<td align="center" id="txt_saldo_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.6);">' .$fila['saldo']. '</td>';}
                     if ($fila['saldo'] > 0) { echo '<td align="center" id="txt_saldo_' .$fila['id_caja']. '" style="background-color:rgba(224, 0, 0, 0.6);">' .$fila['saldo']. '</td>';}
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);"><select id="cbo_cobro_"' .$fila['id_caja']. '">';
                     if ($fila['medio'] == 1){echo '<option value="1" selected>Transferencia</option>';} else {echo '<option value="1">Transferencia</option>';}
                     if ($fila['medio'] == 2){echo '<option value="2" selected>Cheque</option>';} else {echo '<option value="2">Cheque</option>';}
                     if ($fila['medio'] == 3){echo '<option value="3" selected>Efectivo</option>';} else {echo '<option value="3">Efectivo</option>';}
                     echo '</select></td>';
                     echo '<td align="center" id="txt_carga1_' .$fila['id_caja']. '" contenteditable="true" style="background-color:rgba(41, 97, 132, 0.6);">' .$fila['carga1']. '</td>';
                     echo '<td align="center" id="txt_carga2_' .$fila['id_caja']. '" contenteditable="true" style="background-color:rgba(41, 97, 132, 0.6);">' .$fila['carga2']. '</td>';
                     echo '<td align="center" id="txt_carga3_' .$fila['id_caja']. '" contenteditable="true" style="background-color:rgba(41, 97, 132, 0.6);">' .$fila['carga3']. '</td>';
                     echo '<td align="center" id="txt_total_cargas_' .$fila['id_caja']. '" contenteditable="true" style="background-color:rgba(41, 97, 132, 0.6);">' .$fila['total_cargas']. '</td>';
                     echo '<td align="center" id="txt_observaciones_' .$fila['id_caja']. '" contenteditable="true" style="background-color:rgba(41, 97, 132, 0.6);">' .$fila['observaciones']. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);">' .$fila['confirmacion']. '</td>';
                     echo '<td style="background-color:rgba(41, 97, 132, 0.6);"><input type="button" id="btn_modifica" onclick="caja_edita('. $fila['id_caja'] .');" value="Modificar"</td>';
                     //echo '<td><a href="#" id="btn_modifica" onclick="caja_edita('. $fila['id_caja'] .');"><img src="imagenes/small_modify_icon.png" /></a>&nbsp;<a href="#" id="btn_check" onclick="caja_aprueba('. $fila['id_caja'] .');"><img src="imagenes/small_check_green_icon.png" /></a>&nbsp;<a href="#" id="btn_cancel" onclick="caja_desaprueba('. $fila['id_caja'] .');"><img src="imagenes/small_cancel_red_icon.png" /></a></td>';
                     echo '</tr>';
                     $sw_color = 0;
                  }
               }
               echo '</tbody>';
               echo '</table>';
               echo '<br>';
            }
            else {
               echo 'No existen registros.';
            }
         mysqli_close($conexion);
         mysqli_close($conexion2);
         //mysqli_close($conexion3);
         ?>
         </div>
         <br>
      </div>
   </body>
</form>