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
   <title>Agregar Empleado</title>
</head>

<body class="principal">
   <form method="post" action="">
      <a href="empleados.php" class="boton" style="width: 90px">Vover</a>
      <br>
      <div class="contenedor_transp">
         <div class="form-row">
            <div class="titulo form-group col-md-12">
               <center>AGREGAR EMPLEADO</center>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label>DATOS DEL EMPLEADO</label>
            </div>
            <div class="form-group col-md-6">
               <label>DATOS DEL DOMICILIO</label>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="txt_apellido">Apellido*:</label>
               <input type="text" class="propio form-control" id="txt_apellido" name="txt_apellido" maxlength="150" />
            </div>
            <div class="form-group col-md-6">
               <label for="txt_domicilio">Domicilio*:</label>
               <input type="text" class="propio form-control" id="txt_domicilio" name="txt_domicilio" maxlength="150" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="txt_nombre">Nombre*:</label>
               <input type="text" class="propio form-control" id="txt_nombre" name="txt_nombre" maxlength="80" />
            </div>
            <div class="form-group col-md-6">
               <label for="txt_piso">Piso*:</label>
               <input type="tel" class="propio form-control" id="txt_piso" name="txt_piso" maxlength="3" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="txt_dni">DNI*:</label>
               <input type="tel" class="propio form-control" id="txt_dni" name="txt_dni" maxlength="8" />
            </div>
            <div class="form-group col-md-6">
               <label for="txt_depto">Departamento*:</label>
               <input type="text" class="propio form-control" id="txt_depto" name="txt_depto" maxlength="15" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label>CUIL*:</label>
               <input type="tel" class="propio" id="txt_cuil1" name="txt_cuil1" maxlength="2" style="width: 40px;" /><label>-</label><input type="tel" class="propio" style="width: 80px;" id="txt_cuil2" name="txt_cuil2" maxlength="8" /><label>-</label><input type="tel" class="propio" style="width: 40px;" id="txt_cuil3" name="txt_cuil3" maxlength="1" />
            </div>
            <div class="form-group col-md-6">
               <label for="txt_loca">Localidad*:</label>
               <input type="text" class="propio form-control" id="txt_loca" name="txt_loca" maxlength="150" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label>&nbsp;</label>
            </div>
            <div class="form-group col-md-6">
               <label for="cbo_provincia">Provincia*:</label>
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
            <div class="form-group col-md-6">
               <label>DATOS DE CONTACTO</label>
            </div>
            <div class="form-group col-md-6">
               <label>SUELDO</label>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="txt_mail">Mail:</label>
               <input type="email" class="propio form-control" id="txt_mail" name="txt_mail" />
            </div>
            <div class="form-group col-md-6">
               <label for="txt_sbruto">Bruto*:</label>
               <input type="number" class="propio form-control" id="txt_sbruto" name="txt_sbruto" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="txt_tel1">Tel&eacute;fono:</label>
               <input type="number" class="propio form-control" id="txt_tel1" name="txt_tel1" maxlength="13" />
            </div>
            <div class="form-group col-md-6">
               <label for="txt_carga1">Carga 1*:</label>
               <input type="number" class="propio form-control" id="txt_carga1" name="txt_carga1" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="txt_tel2">Celular:</label>
               <input type="number" class="propio form-control" id="txt_tel2" name="txt_tel2" maxlength="13" />
            </div>
            <div class="form-group col-md-6">
               <label for="txt_carga2">Carga 2*:</label>
               <input type="number" class="propio form-control" id="txt_carga2" name="txt_carga2" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label>&nbsp;</label>
            </div>
            <div class="form-group col-md-6">
               <label for="txt_carga3">Carga 3*:</label>
               <input type="number" class="propio form-control" id="txt_carga3" name="txt_carga3" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label>&nbsp;</label>
            </div>
            <div class="form-group col-md-6">
               <label for="cbo_jornada">Jornada*: </label>
               <select id="cbo_jornada" class="propio form-control">
                  <option value="0">--Seleccione jornada--</option>
                  <option value="1">Media</option>
                  <option value="2">Completa</option>
               </select>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">
               <label for="txt_obs">Observaciones:</label>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">
               <textarea id="txt_obs" class="propio form-control" name="txt_obs" rows="3" cols="70 maxlength="250"></textarea></td>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-6">
               <label for="ddl_permisos">Permisos*:</label>
               <select id="ddl_permisos" class="propio form-control" name="ddl_permisos">
                  <option value='0'>--Seleccione--</option>
                  <option value='1'>Administrador</option>
                  <option value='2'>Usuario</option>
               </select>
            </div>
            <div class="form-group col-md-6">
               <label>&nbsp;</label>
            </div>
         </div>
         <center><button type="button" class="boton" onclick="empleado_agrega();">Agregar</button>&nbsp;&nbsp;<input type="submit" class="boton" id="btn_limpiar" name="btn_limpiar" value="Limpiar" /></center>
         <label>* Campos obligatorios</label>
      </div>
      <br>
   </form>
</body>