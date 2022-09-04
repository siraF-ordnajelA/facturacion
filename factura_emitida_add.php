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
   
   $respuesta = mysqli_query($conexion, "call select_admin_clientes(1)") or die(mysqli_error());
?>
<html>
<head>
   <title>Agregar Factura Emitida</title>
</head>

<body class="principal">
   <form method="post" action="">
      <a href="facturas_emitidas.php" class="boton" style="width: 90px">Volver</a>
      <br>
      <div class="contenedor_transp">
         <div class="form-row">
            <div class="titulo form-group col-md-12">
               <center>AGREGAR FACTURA EMITIDA</center>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">
               <label for="cbo_clientes">Cliente*:</label>
               <select id="cbo_clientes" class="propio form-control">
                  <?php
                     echo '<option value="0">--Seleccione cliente--</option>';
                     while ($fila = mysqli_fetch_array($respuesta)) {
                        echo '<option value="'. $fila['id_cliente'] .'">'. $fila['razon_cliente'] .'</option>';
                     }
                  ?>
               </select>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="cal_date">Fecha*:</label>
               <input type="date" class="propio form-control" id="cal_date" name="cal_date" />
            </div>
            <div class="form-group col-md-2">
               <label>Punto venta</label>
               <input type="number" class="propio form-control" value="00001" readonly disabled />
            </div>
            <div class="form-group col-md-4">
               <label for="txt_comprobante">N&uacute;mero de comprobante*:</label>
               <input type="number" class="propio form-control" id="txt_comprobante" name="txt_comprbante" maxlength="8" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="cbo_tipo">Tipo*:</label>
               <select id="cbo_tipo" class="propio form-control" onchange="tipo_factura(0,0);">
                  <option value="0">--Seleccione tipo factura--</option>
                  <option value="1">A</option>
                  <option value="2">B</option>
                  <option value="3">C</option>
               </select>
            </div>
            <div class="form-group col-md-6">
               <label for="cbo_iva">IVA*:</label>
               <select id="cbo_iva" class="propio form-control" disabled>
                  <option value="0">--Seleccione tipo de factura</option>
               </select>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="txt_importe">Importe a facturar*:</label>
               <input type="number" class="propio form-control" id="txt_importe" name="txt_importe" maxlength="9" />
            </div>
            <div class="form-group col-md-6">
               <label>&nbsp;</label>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">
               <label for="txt_obs" colspan="4">Observaciones:</label>
               <textarea id="txt_obs" class="propio form-control" maxlength="250" rows="4" cols="50"></textarea>
            </div>
         </div>
         <center><button type="button" class="boton" onclick="facturae_agrega();" class="boton">Agregar</button>&nbsp;&nbsp;<input type="submit" class="boton" id="btn_limpiar" name="btn_limpiar" value="Limpiar" /></center>
         <label>* Campos obligatorios</label>
      </div>
      <br>
   </form>
</body>