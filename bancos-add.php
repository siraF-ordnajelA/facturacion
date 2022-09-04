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

<body class="principal">
   <form method="post" action="">
      <a href="bancos.php" class="boton" style="width: 90px">Volver</a>
      <br>
      <div class="contenedor_transp">
         <div class="form-row">
            <div class="titulo form-group col-md-12">
               <center><label>BANCOS</label></center>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">
               <label for="txt_banco">Nombre del Banco*:</label>
               <input type="text" class="propio form-control" id="txt_banco" name="txt_banco" maxlength="150" required />
            </div>
         </div>
         <br><br><br><br><br>
         <center><button type="button" class="boton" onclick="banco_agrega();" class="boton">Agregar</button>&nbsp;&nbsp;<input type="submit" class="boton" id="btn_limpiar" name="btn_limpiar" value="Limpiar" /></center>
         <br>
         <label>* Campos obligatorios</label>
      </div>
      </br>
   </form>
</body>