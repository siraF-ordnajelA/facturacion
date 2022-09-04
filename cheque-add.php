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
   
   $respuesta = mysqli_query($conexion, "call select_bancos") or die(mysqli_error());
   //$respuesta2 = mysqli_query($conexion2, "call select_admin_clientes(2)") or die(mysqli_error());
   $total = mysqli_num_rows($respuesta);
?>
<html>
<head>
   <title>Cheques</title>
</head>

<body class="principal">
   <form method="post" action="">
      <a href="cheque.php" class="boton" style="width: 90px">Volver</a>
      <br>
      <div class="contenedor_transp">
         <div class="form-row">
            <div class="titulo form-group col-md-12">
               <center><label>CHEQUES</label></center>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="cal_date_emision">Fecha emisi&oacute;n*:</label>
               <input type="date" class="propio form-control" id="cal_date_emision" name="cal_date_emision" />
            </div>
            <div class="form-group col-md-6">
               <label for="cal_date_pago">Fecha pago*:</label>
               <input type="date" class="propio form-control" id="cal_date_pago" name="cal_date_pago" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="txt_banco">Banco*:</label>
               <select id="cbo_bancos" class="propio form-control">
                  <?php 
                     if ($total > 0) {
                        echo '<option value="0">--Selccione banco--</option>';
                        while ($fila = mysqli_fetch_array($respuesta)) {
                           echo '<option value="'. $fila['id_banco'] .'">'. $fila['nombre_banco'] .'</option>';
                        }
                     }
                     else {
                        echo '<option value="0">--No hay bancos ingresados--</option>';
                     }
                     mysqli_close($conexion);
                  ?>
               </select>
            </div>
            <div class="form-group col-md-6">
               <label for="txt_comprobante">N&uacute;mero de cheque*:</label>
               <input type="text" class="propio form-control" id="txt_comprobante" name="txt_comprobante" maxlength="50" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="txt_importe">Importe*:</label>
               <input type="number" class="propio form-control" id="txt_importe" name="txt_importe" maxlength="9" />
            </div>
            <div class="form-group col-md-6">
               <label for="cbo_clientes">Destinatario:</label>
               <select id="cbo_clientes" class="propio form-control" disabled>
                  <option>--Debe seleccionar Emitido/Recibido--</option>
               </select>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-4"></div>
            <div class="form-group col-md-4">
               <center>
               <table id="tabla_radios">
                  <tr>
                     <td align="center"><label>Recibido</label></td>
                     <td align="center">&nbsp; / &nbsp;</td>
                     <td align="center"><label>Emitido</label></td>
                  </tr>
                  <tr>
                     <td align="center"><input type="radio" id="radio_emitido" value="1" name="radio_cheque" onclick="tipo_cheque_select(1,0)" /></td>
                     <td align="center">&nbsp; &nbsp;</td>
                     <td align="center"><input type="radio" id="radio_recibido" value="2" name="radio_cheque" onclick="tipo_cheque_select(1,0)" /></td>
                  </tr>
               </table>
               <!--<select class="propio form-control" id="cbo_emision">
                  <option value="0">--Seleccione opci&oacute;n</option>
                  <option value="1">Emitido</option>
                  <option value="2">Recibido</option>
               </select>--></center>
            </div>
            <div class="form-group col-md-4"></div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">
               <label for="txt_obs">Observaciones:</label>
            </div>
            <div class="form-group col-md-12">
               <textarea class="propio form-control" id="txt_obs" name="txt_obs" rows="3" cols="50" maxlength="250"></textarea>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">
               <center><button type="button" class="boton" onclick="chequee_agrega();" class="boton">Agregar</button>&nbsp;&nbsp;<input type="submit" class="boton" id="btn_limpiar" name="btn_limpiar" value="Limpiar" /></center>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">
               <label>* Campos obligatorios</label>
            </div>
         </div>
      </div>
   </form>
</body>