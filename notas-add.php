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
   
   include("cabecera.php");
?>
<html>
<head>
   <title>Notas Emitidas</title>
</head>

<script type="text/javascript">
   $(document).ready(function () {
      select_comprobante_nota();
   });
</script>

<body class="principal">
   <form method="post" action="">
      <a href="notas.php" class="boton" style="width: 90px">Volver</a>
      <br>
      <div class="contenedor_transp">
         <div class="form-row">
            <div class="titulo form-group col-md-12">
               <center><label>NOTAS DE CR&Eacute;DITO</label></center>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="txt_detalle">Detalle:</label>
               <input type="text" class="propio form-control" id="txt_detalle" name="txt_detalle" maxlength="250" />
            </div>
            <div class="form-group col-md-6">
               <label for="txt_importe">Importe*:</label>
               <input type="number" class="propio form-control" id="txt_importe" name="txt_importe" maxlength="9" />
            </div>
         </div>
         <div class="form-row">
            <!--<div class="form-group col-md-6">
               <label for="cbo_tipo">Tipo de nota*:</label>
               <select id="cbo_tipo" class="propio form-control" onclick="select_comprobante_nota();">
                  <option value="0">--Seleccione--</option>
                  <option value="1">D&eacute;bito</option>
                  <option value="2">C&eacute;dito</option>
               </select>
            </div>-->
            <div class="form-group col-md-12">
               <label for="cbo_facturas">Facturas Emitidas*:</label>
               <select id="cbo_facturas" class="propio form-control"></select>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">
               <br>
               <center><button type="button" class="boton" onclick="nota_agrega();" class="boton">Agregar</button>&nbsp;&nbsp;<input type="submit" class="boton" id="btn_limpiar" name="btn_limpiar" value="Limpiar" /></center>
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