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
   <title>Agregar Administrador</title>
</head>

<script type="text/javascript">
   function cursor(id_elemento, porcion) {
      //alert(id_elemento.value.length);
      if (porcion = 1) {
         if (id_elemento.value.length >= 2) {
            document.getElementById("txt_cuit2").focus();
         }
      }
      
      if (porcion = 2) {
         if (id_elemento.value.length >= 8) {
            document.getElementById("txt_cuit3").focus();
         }
      }
   }
</script>

<body class="principal">
   <form method="post" action="">
      <a href="administradores.php" class="boton" style="width: 90px">Volver</a>
      <br>
      <div class="contenedor_transp">
         <div class="form-row">
            <div class="titulo form-group col-md-12">
               <center>AGREGAR ADMINISTRADOR</center>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="txt_razon">Raz&oacute;n*:</label>
               <input type="text" class="propio form-control" id="txt_razon" name="txt_razon" maxlength="120" required />
            </div>
            <div class="form-group col-md-6">
               <label for="txt_nombre">Nombre*: </label>
               <input type="text" class="propio form-control" id="txt_nombre" name="txt_nombre" required maxlength="120" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">
               <center><label>DATOS DEL DOMICILIO</label></center>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="txt_domicilio">Domicilio*: </label>
               <input type="text" class="propio form-control" id="txt_domicilio" name="txt_domicilio" maxlength="150" required /></td>
            </div>
            <div class="form-group col-md-6">
               <label for="txt_cp">C&oacute;digo Postal: </label>
               <input type="text" class="propio form-control" id="txt_cp" name="txt_cp" maxlength="15" required />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="txt_loca">Localidad: </label>
               <input type="text" class="propio form-control" id="txt_loca" name="txt_loca" maxlength="150" />
            </div>
            <div class="form-group col-md-6">
               <label for="cbo_provincia">Provincia*: </label>
               <select id="cbo_provincia" class="propio form-control">
                  <option value="0">--Seleccione Provincia--</option>
                  <option value="1">Buenos Aires</option>
                  <option value="24">Capital Federal</option>
                  <option value="2">Catamarca</option>
                  <option value="3">Chaco</option>
                  <option value="4">Chubut</option>
                  <option value="5">Cordoba</option>
                  <option value="6">Corrientes</option>
                  <option value="7">Entre Rios</option>
                  <option value="8">Formosa</option>
                  <option value="9">Jujuy</option>
                  <option value="10">La Pampa</option>
                  <option value="11">La Rioja</option>
                  <option value="12">Mendoza</option>
                  <option value="13">Misiones</option>
                  <option value="14">Neuquen</option>
                  <option value="15">Rio Negro</option>
                  <option value="16">Salta</option>
                  <option value="17">San Juan</option>
                  <option value="18">San Luis</option>
                  <option value="19">Santa Cruz</option>
                  <option value="20">Santa Fe</option>
                  <option value="21">Sgo. del Estero</option>
                  <option value="22">Tierra del Fuego</option>
                  <option value="23">Tucuman</option>
                </select>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">
               <center><label>DATOS COMERCIALES</label></center>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="txt_cuil1">CUIT:</label>
               <input type="tel" class="propio form-control" style="width: 40px" id="txt_cuit1" name="txt_cuit1" maxlength="2" onkeyup="cursor(this, 1);" />
               <label for="txt_cuil2">-</label>
               <input type="tel" class="propio form-control" style="width: 80px" id="txt_cuit2" name="txt_cuit2" maxlength="8" onkeyup="cursor(this, 2);" />
               <label for="txt_cuil3">-</label>
               <input type="tel" class="propio form-control" style="width: 40px" id="txt_cuit3" name="txt_cuit3" maxlength="1" onkeyup="cursor(this, 3);" />
            </div>
            <div class="form-group col-md-6">
               <label>Porcentaje:</label>
               <input type="number" id="txt_abono" name="txt_abono" maxlength="9" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">
               <center><label>DATOS DE CONTACTO</label></center>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-4">
               <label for="txt_nombre_c1">Nombre:</label>
               <input type="text" class="propio form-control" id="txt_nombre_c1" name="txt_nombre_c1" maxlength="80" /></td>
            </div>
            <div class="form-group col-md-4">
               <label for="txt_contacto1">Contacto:</label>
               <input type="number" class="propio form-control" id="txt_contacto1" name="txt_contacto1" maxlength="13" />
            </div>
            <div class="form-group col-md-4">
               <label for="txt_mail1">Mail:</label>
               <input type="email" class="propio form-control" id="txt_mail1" name="txt_mail1" maxlength="80" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-4">
               <label for="txt_nombre_c2">Nombre:</label>
               <input type="text" class="propio form-control" id="txt_nombre_c2" name="txt_nombre_c2" maxlength="80" /></td>
            </div>
            <div class="form-group col-md-4">
               <label for="txt_contacto2">Contacto:</label>
               <input type="number" class="propio form-control" id="txt_contacto2" name="txt_contacto2" maxlength="13" />
            </div>
            <div class="form-group col-md-4">
               <label for="txt_mail2">Mail:</label>
               <input type="email" class="propio form-control" id="txt_mail2" name="txt_mail2" maxlength="80" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-4">
               <label for="txt_nombre_c3">Nombre:</label>
               <input type="text" class="propio form-control" id="txt_nombre_c3" name="txt_nombre_c3" maxlength="80" /></td>
            </div>
            <div class="form-group col-md-4">
               <label for="txt_contacto3">Contacto:</label>
               <input type="number" class="propio form-control" id="txt_contacto3" name="txt_contacto3" maxlength="13" />
            </div>
            <div class="form-group col-md-4">
               <label for="txt_mail3">Mail:</label>
               <input type="email" class="propio form-control" id="txt_mail3" name="txt_mail3" maxlength="80" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-4">
               <label for="txt_nombre_c4">Nombre:</label>
               <input type="text" class="propio form-control" id="txt_nombre_c4" name="txt_nombre_c4" maxlength="80" /></td>
            </div>
            <div class="form-group col-md-4">
               <label for="txt_contacto4">Contacto:</label>
               <input type="number" class="propio form-control" id="txt_contacto4" name="txt_contacto4" maxlength="13" />
            </div>
            <div class="form-group col-md-4">
               <label for="txt_mail4">Mail:</label>
               <input type="email" class="propio form-control" id="txt_mail4" name="txt_mail4" maxlength="80" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-4">
               <label for="txt_nombre_c5">Nombre:</label>
               <input type="text" class="propio form-control" id="txt_nombre_c5" name="txt_nombre_c5" maxlength="80" /></td>
            </div>
            <div class="form-group col-md-4">
               <label for="txt_contacto5">Contacto:</label>
               <input type="number" class="propio form-control" id="txt_contacto5" name="txt_contacto5" maxlength="13" />
            </div>
            <div class="form-group col-md-4">
               <label for="txt_mail5">Mail:</label>
               <input type="email" class="propio form-control" id="txt_mail5" name="txt_mail5" maxlength="80" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-4">
               <label for="txt_nombre_c6">Nombre:</label>
               <input type="text" class="propio form-control" id="txt_nombre_c6" name="txt_nombre_c6" maxlength="80" /></td>
            </div>
            <div class="form-group col-md-4">
               <label for="txt_contacto6">Contacto:</label>
               <input type="number" class="propio form-control" id="txt_contacto6" name="txt_contacto6" maxlength="13" />
            </div>
            <div class="form-group col-md-4">
               <label for="txt_mail6">Mail:</label>
               <input type="email" class="propio form-control" id="txt_mail6" name="txt_mail6" maxlength="80" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-4">
               <label for="txt_nombre_c7">Nombre:</label>
               <input type="text" class="propio form-control" id="txt_nombre_c7" name="txt_nombre_c7" maxlength="80" /></td>
            </div>
            <div class="form-group col-md-4">
               <label for="txt_contacto7">Contacto:</label>
               <input type="number" class="propio form-control" id="txt_contacto7" name="txt_contacto7" maxlength="13" />
            </div>
            <div class="form-group col-md-4">
               <label for="txt_mail7">Mail:</label>
               <input type="email" class="propio form-control" id="txt_mail7" name="txt_mail7" maxlength="80" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-4">
               <label for="txt_nombre_c7">Nombre:</label>
               <input type="text" class="propio form-control" id="txt_nombre_c8" name="txt_nombre_c8" maxlength="80" /></td>
            </div>
            <div class="form-group col-md-4">
               <label for="txt_contacto7">Contacto:</label>
               <input type="number" class="propio form-control" id="txt_contacto8" name="txt_contacto8" maxlength="13" />
            </div>
            <div class="form-group col-md-4">
               <label for="txt_mail8">Mail:</label>
               <input type="email" class="propio form-control" id="txt_mail8" name="txt_mail8" maxlength="80" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-4">
               <label for="txt_nombre_c9">Nombre:</label>
               <input type="text" class="propio form-control" id="txt_nombre_c9" name="txt_nombre_c9" maxlength="80" /></td>
            </div>
            <div class="form-group col-md-4">
               <label for="txt_contacto9">Contacto:</label>
               <input type="number" class="propio form-control" id="txt_contacto9" name="txt_contacto9" maxlength="13" />
            </div>
            <div class="form-group col-md-4">
               <label for="txt_mail9">Mail:</label>
               <input type="email" class="propio form-control" id="txt_mail9" name="txt_mail9" maxlength="80" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-4">
               <label for="txt_nombre_c10">Nombre:</label>
               <input type="text" class="propio form-control" id="txt_nombre_c10" name="txt_nombre_c10" maxlength="80" /></td>
            </div>
            <div class="form-group col-md-4">
               <label for="txt_contacto10">Contacto:</label>
               <input type="number" class="propio form-control" id="txt_contacto10" name="txt_contacto10" maxlength="13" />
            </div>
            <div class="form-group col-md-4">
               <label for="txt_mail10">Mail:</label>
               <input type="email" class="propio form-control" id="txt_mail10" name="txt_mail10" maxlength="80" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">
               <label for="txt_obs">Observaciones: </label>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">
               <textarea id="txt_obs" class="propio form-control" name="txt_obs" rows="4" cols="50" maxlength="250" ></textarea>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">
               <center><button type="button" class="boton" onclick="administrador_agrega();">Agregar</button>&nbsp;&nbsp;<input type="submit" class="boton" id="btn_limpiar" name="btn_limpiar" value="Limpiar" /></center>
            </div>
         </div>
         <label>* Campos obligatorios</label>
      </div>
      
      <br>
   </form>
</body>