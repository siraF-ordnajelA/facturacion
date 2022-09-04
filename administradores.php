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

   $respuesta = mysqli_query($conexion, "call select_administradores") or die(mysqli_error());
   $total = mysqli_num_rows($respuesta);
   $sw_color = 0;
?>
<html>
<head>
   <title>Administradores</title>
</head>

<script language="JavaScript" type="text/javascript" src="Jawas/jquery-3.5.1.min.js"></script>

<form id="form_empleados" method="post" action="">
   <body class="principal">
      <div id="container">
         <a href="administradores-add.php" class="boton" style="width: 195px">Agregar Administrador</a>
         <a href="relacion_administradores.php" class="boton" style="width: 160px">Agregar Relaci&oacute;n</a>
         <div id="status"></div>
         <?php 
            if ($total > 0) {
               echo '<table id="administradores" class="propio">';
               echo '<caption><label>Administradores</label></caption>';
               echo '<thead>';
               echo '<tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">#</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">ACTUALIZADO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">RAZON</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">NOMBRE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">DIRECCION</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">C.P.</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">LOCALIDAD</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">PROVINCIA</td><td align="center" width="100px" style="background-color:rgba(230, 52, 74, 0.8);">CUIT</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">PORCENTAJE(%)</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">&nbsp;</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">OBSERVACIONES</td><td colspan="2" style="background-color:rgba(230, 52, 74, 0.8);">&nbsp;</td></tr>';
               echo '</thead>';
               echo '<tbody>';
               $total = 0;
               while ($fila = mysqli_fetch_array($respuesta)) {
                  $total = $total + 1;
                  if ($sw_color == 0) {
                     //echo '<td align="center">' .$fila['id_administrador']. '</td>';
                     echo '<td align="center" class="propio1">' .$total. '</td>';
                     echo '<td align="center" class="propio1">' .$fila['fecha_actualizacion']. '</td>';
                     echo '<td align="center" id="txt_razon_' .$fila['id_cliente']. '" contenteditable="true" class="propio1">' .$fila['razon']. '</td>';
                     echo '<td align="center" id="txt_nombre_' .$fila['id_cliente']. '" contenteditable="true" class="propio1">' .$fila['nombre']. '</td>';
                     echo '<td align="center" id="txt_direccion_' .$fila['id_cliente']. '" contenteditable="true" class="propio1">' .$fila['direccion']. '</td>';
                     echo '<td align="center" id="txt_cp_' .$fila['id_cliente']. '" contenteditable="true" class="propio1">' .$fila['cp']. '</td>';
                     echo '<td align="center" id="txt_localidad_' .$fila['id_cliente']. '" contenteditable="true" class="propio1">' .$fila['localidad']. '</td>';
                     echo '<td align="center" class="propio1"><select class="propio" id="cbo_provincia_' .$fila['id_cliente']. '">';
                        if ($fila['provincia'] == 1){echo '<option value="1" selected>Buenos Aires</option>';} else {echo '<option value="1">Buenos Aires</option>';}
                        if ($fila['provincia'] == 24){echo '<option value="24" selected>Capital Federal</option>';} else {echo '<option value="24">Capital Federal</option>';}
                        if ($fila['provincia'] == 2){echo '<option value="2" selected>Catamarca</option>';} else {echo '<option value="2">Catamarca</option>';}
                        if ($fila['provincia'] == 3){echo '<option value="3" selected>Chaco</option>';} else {echo '<option value="3">Chaco</option>';}
                        if ($fila['provincia'] == 4){echo '<option value="4" selected>Chubut</option>';} else {echo '<option value="4">Chubut</option>';}
                        if ($fila['provincia'] == 5){echo '<option value="5" selected>Cordoba</option>';} else {echo '<option value="5">Cordoba</option>';}
                        if ($fila['provincia'] == 6){echo '<option value="6" selected>Corrientes</option>';} else {echo '<option value="6">Corrientes</option>';}
                        if ($fila['provincia'] == 7){echo '<option value="7" selected>Entre Rios</option>';} else {echo '<option value="7">Entre Rios</option>';}
                        if ($fila['provincia'] == 8){echo '<option value="8" selected>Formosa</option>';} else {echo '<option value="8">Formosa</option>';}
                        if ($fila['provincia'] == 9){echo '<option value="9" selected>Jujuy</option>';} else {echo '<option value="9">Jujuy</option>';}
                        if ($fila['provincia'] == 10){echo '<option value="10" selected>La Pampa</option>';} else {echo '<option value="10">La Pampa</option>';}
                        if ($fila['provincia'] == 11){echo '<option value="11" selected>La Rioja</option>';} else {echo '<option value="11">La Rioja</option>';}
                        if ($fila['provincia'] == 12){echo '<option value="12" selected>Mendoza</option>';} else {echo '<option value="12">Mendoza</option>';}
                        if ($fila['provincia'] == 13){echo '<option value="13" selected>Misiones</option>';} else {echo '<option value="13">Misiones</option>';}
                        if ($fila['provincia'] == 14){echo '<option value="14" selected>Neuquen</option>';} else {echo '<option value="14">Neuquen</option>';}
                        if ($fila['provincia'] == 15){echo '<option value="15" selected>Rio Negro</option>';} else {echo '<option value="15">Rio Negro</option>';}
                        if ($fila['provincia'] == 16){echo '<option value="16" selected>Salta</option>';} else {echo '<option value="16">Salta</option>';}
                        if ($fila['provincia'] == 17){echo '<option value="17" selected>San Juan</option>';} else {echo '<option value="17">San Juan</option>';}
                        if ($fila['provincia'] == 18){echo '<option value="18" selected>San Luis</option>';} else {echo '<option value="18">San Luis</option>';}
                        if ($fila['provincia'] == 19){echo '<option value="19" selected>Santa Cruz</option>';} else {echo '<option value="19">Santa Cruz</option>';}
                        if ($fila['provincia'] == 20){echo '<option value="20" selected>Santa Fe</option>';} else {echo '<option value="20">Santa Fe</option>';}
                        if ($fila['provincia'] == 21){echo '<option value="21" selected>Sgo. del Estero</option>';} else {echo '<option value="21">Sgo. del Estero</option>';}
                        if ($fila['provincia'] == 22){echo '<option value="22" selected>Tierra del Fuego</option>';} else {echo '<option value="22">Tierra del Fuego</option>';}
                        if ($fila['provincia'] == 23){echo '<option value="23" selected>Tucuman</option>';} else {echo '<option value="23">Tucuman</option>';}
                     echo '</select></td>';
                     echo '<td align="center" id="txt_cuit_' .$fila['id_cliente']. '" contenteditable="true" class="propio1">' .$fila['cuit']. '</td>';
                     echo '<td align="center" id="txt_abono_' .$fila['id_cliente']. '" contenteditable="true" class="propio1">' .$fila['abono']. '</td>';
                     echo '<td align="center" class="propio1"><a href="contactos.php?id=' .$fila['id_cliente']. '">Ver Contactos</a></td>';
                     echo '<td align="center" id="txt_observaciones_' .$fila['id_cliente']. '" contenteditable="true" class="propio1">' .$fila['observaciones']. '</td>';
                     echo '<td align="center" style="width: 50px;" class="propio1"><img src="imagenes/small_modify_icon.png" style="cursor:hand;" onclick="administrador_edita('. $fila['id_cliente'] .');" /></td>';
                     echo '<td align="center" style="width: 50px;" class="propio1"><img src="imagenes/small_delete_icon.png" style="cursor:hand;" onclick="administrador_elimina('. $fila['id_cliente'] .');" /></td></tr>';
                     //echo '<td align="center" style="width: 50px;" class="propio1"><a href="" id="btn_guarda" onclick="administrador_edita('. $fila['id_cliente'] .');"><img src="imagenes/small_modify_icon.png" /></a></td>';
                     //echo '<td align="center" style="width: 50px;" class="propio1"><a href="" id="btn_elimina" onclick="administrador_elimina('. $fila['id_cliente'] .');"><img src="imagenes/small_delete_icon.png" /></a></td></tr>';
                     $sw_color = 1;
                  }
                  else {
                     echo '<td align="center" class="propio2">' .$total. '</td>';
                     echo '<td align="center" class="propio2">' .$fila['fecha_actualizacion']. '</td>';
                     echo '<td align="center" id="txt_razon_' .$fila['id_cliente']. '" contenteditable="true" class="propio2">' .$fila['razon']. '</td>';
                     echo '<td align="center" id="txt_nombre_' .$fila['id_cliente']. '" contenteditable="true" class="propio2">' .$fila['nombre']. '</td>';
                     echo '<td align="center" id="txt_direccion_' .$fila['id_cliente']. '" contenteditable="true" class="propio2">' .$fila['direccion']. '</td>';
                     echo '<td align="center" id="txt_cp_' .$fila['id_cliente']. '" contenteditable="true" class="propio2">' .$fila['cp']. '</td>';
                     echo '<td align="center" id="txt_localidad_' .$fila['id_cliente']. '" contenteditable="true" class="propio2">' .$fila['localidad']. '</td>';
                     echo '<td align="center" class="propio2"><select class="propio" id="cbo_provincia_' .$fila['id_cliente']. '">';
                        if ($fila['provincia'] == 1){echo '<option value="1" selected>Buenos Aires</option>';} else {echo '<option value="1">Buenos Aires</option>';}
                        if ($fila['provincia'] == 2){echo '<option value="2" selected>Catamarca</option>';} else {echo '<option value="2">Catamarca</option>';}
                        if ($fila['provincia'] == 3){echo '<option value="3" selected>Chaco</option>';} else {echo '<option value="3">Chaco</option>';}
                        if ($fila['provincia'] == 4){echo '<option value="4" selected>Chubut</option>';} else {echo '<option value="4">Chubut</option>';}
                        if ($fila['provincia'] == 5){echo '<option value="5" selected>Cordoba</option>';} else {echo '<option value="5">Cordoba</option>';}
                        if ($fila['provincia'] == 6){echo '<option value="6" selected>Corrientes</option>';} else {echo '<option value="6">Corrientes</option>';}
                        if ($fila['provincia'] == 7){echo '<option value="7" selected>Entre Rios</option>';} else {echo '<option value="7">Entre Rios</option>';}
                        if ($fila['provincia'] == 8){echo '<option value="8" selected>Formosa</option>';} else {echo '<option value="8">Formosa</option>';}
                        if ($fila['provincia'] == 9){echo '<option value="9" selected>Jujuy</option>';} else {echo '<option value="9">Jujuy</option>';}
                        if ($fila['provincia'] == 10){echo '<option value="10" selected>La Pampa</option>';} else {echo '<option value="10">La Pampa</option>';}
                        if ($fila['provincia'] == 11){echo '<option value="11" selected>La Rioja</option>';} else {echo '<option value="11">La Rioja</option>';}
                        if ($fila['provincia'] == 12){echo '<option value="12" selected>Mendoza</option>';} else {echo '<option value="12">Mendoza</option>';}
                        if ($fila['provincia'] == 13){echo '<option value="13" selected>Misiones</option>';} else {echo '<option value="13">Misiones</option>';}
                        if ($fila['provincia'] == 14){echo '<option value="14" selected>Neuquen</option>';} else {echo '<option value="14">Neuquen</option>';}
                        if ($fila['provincia'] == 15){echo '<option value="15" selected>Rio Negro</option>';} else {echo '<option value="15">Rio Negro</option>';}
                        if ($fila['provincia'] == 16){echo '<option value="16" selected>Salta</option>';} else {echo '<option value="16">Salta</option>';}
                        if ($fila['provincia'] == 17){echo '<option value="17" selected>San Juan</option>';} else {echo '<option value="17">San Juan</option>';}
                        if ($fila['provincia'] == 18){echo '<option value="18" selected>San Luis</option>';} else {echo '<option value="18">San Luis</option>';}
                        if ($fila['provincia'] == 19){echo '<option value="19" selected>Santa Cruz</option>';} else {echo '<option value="19">Santa Cruz</option>';}
                        if ($fila['provincia'] == 20){echo '<option value="20" selected>Santa Fe</option>';} else {echo '<option value="20">Santa Fe</option>';}
                        if ($fila['provincia'] == 21){echo '<option value="21" selected>Sgo. del Estero</option>';} else {echo '<option value="21">Sgo. del Estero</option>';}
                        if ($fila['provincia'] == 22){echo '<option value="22" selected>Tierra del Fuego</option>';} else {echo '<option value="22">Tierra del Fuego</option>';}
                        if ($fila['provincia'] == 23){echo '<option value="23" selected>Tucuman</option>';} else {echo '<option value="23">Tucuman</option>';}
                     echo '</select></td>';
                     echo '<td align="center" id="txt_cuit_' .$fila['id_cliente']. '" contenteditable="true" class="propio2">' .$fila['cuit']. '</td>';
                     echo '<td align="center" id="txt_abono_' .$fila['id_cliente']. '" contenteditable="true" class="propio2">' .$fila['abono']. '</td>';
                     echo '<td align="center" class="propio2"><a href="contactos.php?id=' .$fila['id_cliente']. '">Ver Contactos</a></td>';
                     echo '<td align="center" id="txt_observaciones_' .$fila['id_cliente']. '" contenteditable="true" class="propio2">' .$fila['observaciones']. '</td>';
                     //echo '<td style="background-color:rgba(41, 97, 132, 0.6);"><input type="button" class="boton" id="btn_guarda" onclick="administrador_edita('. $fila['id_cliente'] .');" value="Guardar"</td>';
                     //echo '<td style="background-color:rgba(41, 97, 132, 0.6);"><input type="button" class="boton" id="btn_elimina" onclick="administrador_elimina('. $fila['id_cliente'] .');" value="Borrar"</td></tr>';
                     echo '<td align="center" style="width: 50px;" class="propio2"><a href="" id="btn_guarda" onclick="administrador_edita('. $fila['id_cliente'] .');"><img src="imagenes/small_modify_icon.png" /></a></td>';
                     echo '<td align="center" style="width: 50px;" class="propio2"><a href="" id="btn_elimina" onclick="administrador_elimina('. $fila['id_cliente'] .');"><img src="imagenes/small_delete_icon.png" /></a></td></tr>';
                     $sw_color = 0;
                  }
               }
               echo '</tbody>';
               echo '</table>';
               echo '<br>';
            }
            else {
               echo '<label>A&uacute;n no existen Administradores cargados</label>';
            }
         ?>
         <br>
      </div>
   </body>
</form>