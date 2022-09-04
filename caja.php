<?php
   session_start();
   
   if (isset($_SESSION['loggedin']) && isset($_SESSION['id_empleado']) && $_SESSION['loggedin'] == true) {
      $id_usuario = $_SESSION['id_empleado'];
      $id_permiso = $_SESSION['id_permiso'];
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

   $fecha = date("Y") . date("m") . "01";
   
   $respuesta = mysqli_query($conexion, "call select_caja('$fecha')") or die(mysqli_error());
   $respuesta2 = mysqli_query($conexion2, "call select_admin_clientes(1)") or die(mysqli_error());
   //$respuesta3 = mysqli_query($conexion3, "call select_comprobantes") or die(mysqli_error());
   $total = mysqli_num_rows($respuesta);
   $sw_color = 0;
   $sw = 0;
   
   if(isset($_POST["cbo_mes"])){
      $mes_raw = $_POST["cbo_mes"];
      $mes = str_replace("-","" ,$mes_raw);
      //echo '<label>'. $mes .'</label>';
      $respuesta = mysqli_query($conexion3, "call select_caja('$mes')") or die(mysqli_error());
      $total = mysqli_num_rows($respuesta);
      $sw = 1;
   }
?>
<html>
<head>
   <title>Caja</title>
</head>

<script type="text/javascript">
   $(document).ready(function () {
      combo_mes();
   });
   
   function combo_mes(){
      var cbo_fecha = $('#cbo_mes');
      
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
      });
   }
</script>

<body class="principal">
   <form id="form_caja" method="post" action="">
      <!--<div class="titulo"><h4>AGREGAR MOVIMIENTO DE CAJA</h4></div>-->
      <div class="contenedor_transp">
         <div class="form-row">
            <div class="titulo form-group col-md-12">
               <center>AGREGAR MOVIMIENTO DE CAJA</center>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="cbo_tipo">Ingreso/Egreso:</label>
               <select id="cbo_tipo" class="propio form-control" onchange="select_comprobante();">
                  <option value="0">--Seleccione Movimiento--</option>
                  <option value="1">Factura Emitida</option>
                  <option value="2">Factura Recibida</option>
                  <!--<option value="3">Cheque</option>
                  <option value="4">Nota de cr&eacute;dito/d&eacute;bito</option>-->
               </select>
            </div>
            <div class="form-group col-md-6">
               <label for="cbo_comprobantes">Nro.Comprobante:</label>
               <select id="cbo_comprobantes" class="propio form-control select2" onchange="select_datos_comprobante();" disabled>
                  <option value="0">--Seleccione el comprobante--</option>
               </select>
               <span id="txt_cliente" hidden></span>
               <span id="txt_importe" hidden></span>
               <span id="txt_iva" hidden></span>
               <span id="txt_total" hidden></span>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">

            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="txt_cobrado">Cobrado:</label>
               <input type="number" class="form-control" id="txt_cobrado" maxlength="9" placeholder="Importe cobrado" />
            </div>
            <div class="form-group col-md-6">
               <label for="txt_pagado">Pagado:</label>
               <input type="number" class="form-control" id="txt_pagado" maxlength="9" placeholder="Importe pagado" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-4">
               <label for="txt_carga1">Ret./Pers. Seg. Social: </label>
               <input type="number" class="form-control" id="txt_carga1" maxlength="9" />
            </div>
            <div class="form-group col-md-4">
               <label for="txt_carga2">Ret./Pers IVA: </label>
               <input type="number" class="form-control" id="txt_carga2" maxlength="9" />
            </div>
            <div class="form-group col-md-4">
               <label for="txt_carga3">SI.CO.RE: </label>
               <input type="number" class="form-control" id="txt_carga3" maxlength="9" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="txt_carga4">Retenci&oacute;n de locaciones de obra y/o servicios: </label>
               <input type="number" class="form-control" id="txt_carga4" maxlength="9" />
            </div>
            <div class="form-group col-md-5">
               <label for="txt_carga5">Retenci&oacute;n por IIBB: </label>
               <input type="number" class="form-control" id="txt_carga5" maxlength="9" />
            </div>
         </div>
         <div class="form_row">
            <div class="form-group col-md-6">
               <label for="cbo_medio">Medio:</label>
               <select id="cbo_medio" class="propio form-control" onchange="caja_cheque(0)">
                  <option value="0">--Seleccione medio--</option>
                  <option value="1">Transferencia</option>
                  <option value="2">Cheque</option>
                  <option value="3">Efectivo</option>
               </select>
            </div>
            <div class="form-group col-md-6">
               <label for="cbo_pago">Pago:</label>
               <select id="cbo_pago" class="propio form-control">
                  <option value="0">--Seleccione pago--</option>
                  <option value="1">Total</option>
                  <option value="2">Parcial</option>
               </select>
            </div>
         </div>
         <div class="form_row">
            <div class="form-group col-md-6">
               <label for="cbo_cheque">Cheque:</label>
               <select id="cbo_cheque" class="propio form-control" disabled>
                  <option value="0">--Seleccione cheque--</option>
               </select>
            </div>
            <div class="form-group col-md-6">
               <label for="cal_pago">Fecha de cobro/pago:</label>
               <input type="date" class="propio form-control" id="cal_pago" name="cal_pago" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">
               <label for="txt_obs">Observaciones:</label>
               <textarea class="propio form-control" id="txt_obs" name="txt_obs" rows="3" cols="70"></textarea>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">
               <center><input type="button" class="boton" id="btn_agregar" name="btn_agregar" onclick="guardar_caja(<?php echo $id_usuario; ?>);" value="Agregar" />&nbsp;&nbsp;<input type="submit" class="boton" id="btn_limpiar" name="btn_limpiar" value="Limpiar" /></center>
            </div>
         </div>
      </div>
      <div>
      <br>
      <div class="contenedor_transp">
         Seleccione desde que mes desea visualizar:&nbsp;
         <select class="propio" id="cbo_mes" name="cbo_mes" onchange="this.form.submit()">
            
         </select>
      </div>
      <br>
         <?php 
            if ($total > 0) {
               echo '<table id="caja" class="propio">';
               if ($sw == 1){
                  echo '<caption><center><label>CAJA MES DESDE EL '. $mes_raw .'</center></label></caption>';
               }
               else {
                  echo '<caption><center><label>CAJA MES '. date("m") .'/'. date("Y") .'</label></center></caption>';
               }
               echo '<thead>';
               //if($id_permiso == 1){
                  echo '<tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA INGRESO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA COBRO/PAGO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">USUARIO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">CLIENTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">MONTO FACTURADO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">COBRADO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">PAGADO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">SALDO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">MEDIO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">RET./PERS. SEG.SOCIAL</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">RET./PERS. IVA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">SI.CO.RE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">RET.LOC. DE OBRA Y/O SERVICIOS</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">RET. POR IIBB</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">TOTAL CARGAS</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">OBSERVACIONES</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">APROBADO</td><td align="center" colspan="3" style="background-color:rgba(230, 52, 74, 0.8);">APROBAR</td></tr>';
               /*}
               else{
                  echo '<tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA INGRESO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">USUARIO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">CLIENTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">MONTO FACTURADO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">COBRADO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">PAGADO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">SALDO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">MEDIO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">SEG.SOCIAL</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IVA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">SI.CO.RE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">TOTAL CARGAS</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">OBSERVACIONES</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">APROBADO</td></tr>';
               }*/
               echo '</thead>';
               echo '<tbody>';
               while ($fila = mysqli_fetch_array($respuesta)) {
                  if ($sw_color == 0) {
                     echo '<tr>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.3);">' .$fila['fecha_ingreso']. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.3);">' .$fila['fecha_pago']. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.3);">' .$fila['usuario']. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.3);">' .$fila['razon']. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.3);">' .number_format($fila['TOTAL'], 2, ",", "."). ' [' .$fila['comprobante']. ']</td>';
                     echo '<td align="center" id="txt_cobrado_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.3);">' .number_format($fila['cobrado'], 2, ",", "."). '</td>';
                     echo '<td align="center" id="txt_pagado_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.3);">' .number_format($fila['pagado'], 2, ",", "."). '</td>';
                     if ($fila['saldo'] < 0) { echo '<td align="center" id="txt_saldo_' .$fila['id_caja']. '" style="background-color:rgba(41, 217, 17, 0.6);">' .number_format($fila['saldo'], 2, ",", "."). '</td>';}
                     if ($fila['saldo'] == 0) { echo '<td align="center" id="txt_saldo_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.3);">' .number_format($fila['saldo'], 2, ",", "."). '</td>';}
                     if ($fila['saldo'] > 0) { echo '<td align="center" id="txt_saldo_' .$fila['id_caja']. '" style="background-color:rgba(224, 0, 0, 0.6);">' .number_format($fila['saldo'], 2, ",", "."). '</td>';}
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.3);"><select id="cbo_cobro_"' .$fila['id_caja']. '" class="propio">';
                     if ($fila['medio'] == 1){echo '<option value="1" selected>Transferencia</option>';} else {echo '<option value="1">Transferencia</option>';}
                     if ($fila['medio'] == 2){echo '<option value="2" selected>Cheque</option>';} else {echo '<option value="2">Cheque</option>';}
                     if ($fila['medio'] == 3){echo '<option value="3" selected>Efectivo</option>';} else {echo '<option value="3">Efectivo</option>';}
                     echo '</select></td>';
                     echo '<td align="center" id="txt_carga1_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.3);">' .number_format($fila['carga1'], 2, ",", "."). '</td>';
                     echo '<td align="center" id="txt_carga2_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.3);">' .number_format($fila['carga2'], 2, ",", "."). '</td>';
                     echo '<td align="center" id="txt_carga3_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.3);">' .number_format($fila['carga3'], 2, ",", "."). '</td>';
                     echo '<td align="center" id="txt_carga3_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.3);">' .number_format($fila['carga4'], 2, ",", "."). '</td>';
                     echo '<td align="center" id="txt_carga3_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.3);">' .number_format($fila['carga5'], 2, ",", "."). '</td>';
                     echo '<td align="center" id="txt_total_cargas_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.3);">' .number_format($fila['total_cargas'], 2, ",", "."). '</td>';
                     echo '<td align="center" id="txt_observaciones_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.3);">' .$fila['observaciones']. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.3);">' .$fila['confirmacion']. '</td>';
                     if($id_permiso == 1) { //&& $fila['Diff'] < 4){
                        //echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.3);"><img src="imagenes/small_modify_icon.png" style="cursor:hand;" data-toggle="tooltip" title="Modificar" /></td>';
                        echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.3);"><img src="imagenes/small_check_green_icon.png" onclick="caja_aprueba('. $fila['id_caja'] .', 1);" style="cursor:hand;" data-toggle="tooltip" title="Aprobar" /></td>';
                        echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.3);"><img src="imagenes/small_cancel_red_icon.png" onclick="caja_aprueba('. $fila['id_caja'] .', 2);" style="cursor:hand;" data-toggle="tooltip" title="Desaprobar" /></td>';
                        echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.3);"><img src="imagenes/small_delete_icon.png" onclick="caja_elimina('. $fila['id_caja'] .', '. $fila['id_tipo_factura'] .', '. $fila['id_factura'] .');" style="cursor:hand;" data-toggle="tooltip" title="Borrar" /></td>';
                     }
                     //echo '<td style="background-color:rgba(41, 97, 132, 0.3);"><input type="button" id="btn_modifica" class="boton" onclick="caja_edita('. $fila['id_caja'] .');" value="Modificar"</td>';
                     //echo '<td><a href="#" id="btn_modifica" onclick="caja_edita('. $fila['id_caja'] .');"><img src="imagenes/small_modify_icon.png" /></a>&nbsp;<a href="#" id="btn_check" onclick="caja_aprueba('. $fila['id_caja'] .');"><img src="imagenes/small_check_green_icon.png" /></a>&nbsp;<a href="#" id="btn_cancel" onclick="caja_desaprueba('. $fila['id_caja'] .');"><img src="imagenes/small_cancel_red_icon.png" /></a></td>';
                     echo '</tr>';
                     $sw_color = 1;
                  }
                  else {
                     //echo '<td align="center">' .$fila['id_administrador']. '</td>';
                     echo '<tr>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);">' .$fila['fecha_ingreso']. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);">' .$fila['fecha_pago']. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);">' .$fila['usuario']. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);">' .$fila['razon']. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);">' .number_format($fila['TOTAL'], 2, ",", "."). ' [' .$fila['comprobante']. ']</td>';
                     echo '<td align="center" id="txt_cobrado_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.6);">' .number_format($fila['cobrado'], 2, ",", "."). '</td>';
                     echo '<td align="center" id="txt_pagado_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.6);">' .number_format($fila['pagado'], 2, ",", "."). '</td>';
                     if ($fila['saldo'] < 0) { echo '<td align="center" id="txt_saldo_' .$fila['id_caja']. '" style="background-color:rgba(41, 217, 17, 0.6);">' .number_format($fila['saldo'], 2, ",", "."). '</td>';}
                     if ($fila['saldo'] == 0) { echo '<td align="center" id="txt_saldo_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.6);">' .number_format($fila['saldo'], 2, ",", "."). '</td>';}
                     if ($fila['saldo'] > 0) { echo '<td align="center" id="txt_saldo_' .$fila['id_caja']. '" style="background-color:rgba(224, 0, 0, 0.6);">' .number_format($fila['saldo'], 2, ",", "."). '</td>';}
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);"><select id="cbo_cobro_"' .$fila['id_caja']. '" class="propio">';
                     if ($fila['medio'] == 1){echo '<option value="1" selected>Transferencia</option>';} else {echo '<option value="1">Transferencia</option>';}
                     if ($fila['medio'] == 2){echo '<option value="2" selected>Cheque</option>';} else {echo '<option value="2">Cheque</option>';}
                     if ($fila['medio'] == 3){echo '<option value="3" selected>Efectivo</option>';} else {echo '<option value="3">Efectivo</option>';}
                     echo '</select></td>';
                     echo '<td align="center" id="txt_carga1_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.6);">' .number_format($fila['carga1'], 2, ",", "."). '</td>';
                     echo '<td align="center" id="txt_carga2_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.6);">' .number_format($fila['carga2'], 2, ",", "."). '</td>';
                     echo '<td align="center" id="txt_carga3_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.6);">' .number_format($fila['carga3'], 2, ",", "."). '</td>';
                     echo '<td align="center" id="txt_carga3_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.6);">' .number_format($fila['carga4'], 2, ",", "."). '</td>';
                     echo '<td align="center" id="txt_carga3_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.6);">' .number_format($fila['carga5'], 2, ",", "."). '</td>';
                     echo '<td align="center" id="txt_total_cargas_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.6);">' .number_format($fila['total_cargas'], 2, ",", "."). '</td>';
                     echo '<td align="center" id="txt_observaciones_' .$fila['id_caja']. '" style="background-color:rgba(41, 97, 132, 0.6);">' .$fila['observaciones']. '</td>';
                     echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);">' .$fila['confirmacion']. '</td>';
                     if($id_permiso == 1) { //&& $fila['Diff'] < 4){
                        //echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);" style="background-color:rgba(41, 97, 132, 0.6);"><img src="imagenes/small_modify_icon.png" style="cursor:hand;" data-toggle="tooltip" title="Modificar" /></td>';
                        echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);" style="background-color:rgba(41, 97, 132, 0.6);"><img src="imagenes/small_check_green_icon.png" onclick="caja_aprueba('. $fila['id_caja'] .', 1);" style="cursor:hand;" data-toggle="tooltip" title="Aprobar" /></td>';
                        echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);" style="background-color:rgba(41, 97, 132, 0.6);"><img src="imagenes/small_cancel_red_icon.png" onclick="caja_aprueba('. $fila['id_caja'] .', 2);" style="cursor:hand;" data-toggle="tooltip" title="Desaprobar" /></td>';
                        echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);"><img src="imagenes/small_delete_icon.png" onclick="caja_elimina('. $fila['id_caja'] .', '. $fila['id_tipo_factura'] .', '. $fila['id_factura'] .');" style="cursor:hand;" data-toggle="tooltip" title="Borrar" /></td>';
                     }
                     //echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);"><input type="button" id="btn_modifica" class="boton" onclick="caja_edita('. $fila['id_caja'] .');" value="Modificar"</td>';
                     //echo '<td align="center" style="background-color:rgba(41, 97, 132, 0.6);"><a href="#" id="btn_modifica" onclick="caja_edita('. $fila['id_caja'] .');"><img src="imagenes/small_modify_icon.png" /></a>&nbsp;<a href="#" id="btn_check" onclick="caja_aprueba('. $fila['id_caja'] .');"><img src="imagenes/small_check_green_icon.png" /></a>&nbsp;<a href="#" id="btn_cancel" onclick="caja_desaprueba('. $fila['id_caja'] .');"><img src="imagenes/small_cancel_red_icon.png" /></a></td>';
                     echo '</tr>';
                     $sw_color = 0;
                  }
               }
               echo '</tbody>';
               echo '</table>';
               echo '<br>';
            }
            else {
               echo '<br>A&uacute;n no existen registros de este mes.';
            }
         mysqli_close($conexion);
         mysqli_close($conexion2);
         
         if ($sw == 1){
            mysqli_close($conexion3);
         }
         ?>
         <br>
      </div>
   </form>
</body>