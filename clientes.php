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

   if(isset($_GET["tipo"])){
      $tipo_cliente = $_GET["tipo"];
      $respuesta = mysqli_query($conexion, "call select_clientes($tipo_cliente)") or die(mysqli_error());
   }
   else {
      $respuesta = mysqli_query($conexion, "call select_clientes(1)") or die(mysqli_error());
   }
   $total = mysqli_num_rows($respuesta);
   $sw_color = 0;
   $contador = 1;
?>
<html>
<head>
   <title>Clientes</title>
</head>

<form id="form_clientes" method="post" action="">
   <body class="principal">
      <div id="container">
         <a href="clientes-add.php" class="boton" style="width: 147px">Agregar Cliente</a>
         <a href="proveedor-add.php" class="boton" style="width: 172px">Agregar Proveedor</a>
         <?php 
            if ($total > 0) {
               echo '<table id="clientes" class="propio">';
               echo '<caption>';
               if(isset($_GET["tipo"])){
                  $tipo_cliente = $_GET["tipo"];
                  if ($tipo_cliente == 1){
                     echo '<input type="radio" id="rd_clientes" name="rd_clientes" onclick="clientes_proveedores(1);" checked>&nbsp;<label for="rd_clientes">Clientes</label>&nbsp;';
                     echo '&nbsp;<input type="radio" id="rd_proveedores" name="rd_clientes" onclick="clientes_proveedores(2);">&nbsp;<label for="rd_proveedores">Proveedores</label>';
                  }
                  else {
                     echo '<input type="radio" id="rd_clientes" name="rd_clientes" onclick="clientes_proveedores(1);">&nbsp;<label for="rd_clientes">Clientes</label>&nbsp;';
                     echo '&nbsp;<input type="radio" id="rd_proveedores" name="rd_clientes" onclick="clientes_proveedores(2);" checked>&nbsp;<label for="rd_proveedores">Proveedores</label>';
                  }
               }
               else {
                  echo '<input type="radio" id="rd_clientes" name="rd_clientes" onclick="clientes_proveedores(1);" checked>&nbsp;<label for="rd_clientes">Clientes</label>&nbsp;';
                  echo '&nbsp;<input type="radio" id="rd_proveedores" name="rd_clientes" onclick="clientes_proveedores(2);">&nbsp;<label for="rd_proveedores">Proveedores</label>';
               }
               echo '</caption>';
               echo '<thead>';
               echo '<tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">#</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">ID</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">ACTUALIZADO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">RAZON</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">NOMBRE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">DIRECCION</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">C.P.</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">LOCALIDAD</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">PROVINCIA</td><td align="center" width="100px" style="background-color:rgba(230, 52, 74, 0.8);">CUIT</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">EMPLEADOS</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">&nbsp;</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">OBSERVACIONES</td><td colspan="2" style="background-color:rgba(230, 52, 74, 0.8);">&nbsp;</td></tr>';
               echo '</thead>';
               echo '<tbody>';
               while ($fila = mysqli_fetch_array($respuesta)) {
                  if ($sw_color == 0) {
                     echo '<td align="center" class="propio1">' . $contador . '</td>';
                     echo '<td align="center" class="propio1">' . $fila['id_cliente'] . '</td>';
                     echo '<td align="center" class="propio1">' .$fila['fecha_actualizacion']. '</td>';
                     echo '<td align="center" class="propio1" id="txt_razon_' .$fila['id_cliente']. '" contenteditable="true">' .$fila['razon']. '</td>';
                     echo '<td align="center" class="propio1" id="txt_nombre_' .$fila['id_cliente']. '" contenteditable="true">' .$fila['nombre']. '</td>';
                     echo '<td align="center" class="propio1" id="txt_direccion_' .$fila['id_cliente']. '" contenteditable="true">' .$fila['direccion']. '</td>';
                     echo '<td align="center" class="propio1" id="txt_cp_' .$fila['id_cliente']. '" contenteditable="true">' .$fila['cp']. '</td>';
                     echo '<td align="center" class="propio1" id="txt_localidad_' .$fila['id_cliente']. '" contenteditable="true">' .$fila['localidad']. '</td>';
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
                     echo '<td align="center" class="propio1" id="txt_cuit_' .$fila['id_cliente']. '" contenteditable="true">' .$fila['cuit']. '</td>';
                     //echo '<td align="center" class="propio1" id="txt_abono_' .$fila['id_cliente']. '" contenteditable="true">' .$fila['abono']. '</td>';
                     echo '<td align="center" class="propio1" id="txt_empleados_' .$fila['id_cliente']. '" contenteditable="true">' .$fila['cant_empleados']. '</td>';
                     echo '<td align="center" class="propio1"><a href="contactos.php?id=' .$fila['id_cliente']. '">Ver Contactos</a></td>';
                     echo '<td align="center" class="propio1" id="txt_observaciones_' .$fila['id_cliente']. '" contenteditable="true">' .$fila['observaciones']. '</td>';
                     echo '<td align="center" style="width: 50px;" class="propio1"><a href="" id="btn_guarda" onclick="cliente_edita('. $fila['id_cliente'] .');"><img src="imagenes/small_modify_icon.png" /></a></td>';
                     echo '<td align="center" style="width: 50px;" class="propio1"><a href="" id="btn_elimina" onclick="cliente_elimina('. $fila['id_cliente'] .');"><img src="imagenes/small_delete_icon.png" /></a></td></tr>';
                     $sw_color = 1;
                     $contador++;
                  }
                  else {
                     echo '<td align="center" class="propio1">' . $contador . '</td>';
                     echo '<td align="center" class="propio2">' . $fila['id_cliente'] . '</td>';
                     echo '<td align="center" class="propio2">' .$fila['fecha_actualizacion']. '</td>';
                     echo '<td align="center" class="propio2" id="txt_razon_' .$fila['id_cliente']. '" contenteditable="true">' .$fila['razon']. '</td>';
                     echo '<td align="center" class="propio2" id="txt_nombre_' .$fila['id_cliente']. '" contenteditable="true">' .$fila['nombre']. '</td>';
                     echo '<td align="center" class="propio2" id="txt_direccion_' .$fila['id_cliente']. '" contenteditable="true">' .$fila['direccion']. '</td>';
                     echo '<td align="center" class="propio2" id="txt_cp_' .$fila['id_cliente']. '" contenteditable="true">' .$fila['cp']. '</td>';
                     echo '<td align="center" class="propio2" id="txt_localidad_' .$fila['id_cliente']. '" contenteditable="true">' .$fila['localidad']. '</td>';
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
                     echo '<td align="center" class="propio2" id="txt_cuit_' .$fila['id_cliente']. '" contenteditable="true">' .$fila['cuit']. '</td>';
                     //echo '<td align="center" class="propio2" id="txt_abono_' .$fila['id_cliente']. '" contenteditable="true">' .$fila['abono']. '</td>';
                     echo '<td align="center" class="propio2" id="txt_empleados_' .$fila['id_cliente']. '" contenteditable="true">' .$fila['cant_empleados']. '</td>';
                     echo '<td align="center" class="propio2"><a href="contactos.php?id=' .$fila['id_cliente']. '">Ver Contactos</a></td>';
                     echo '<td align="center" class="propio2" id="txt_observaciones_' .$fila['id_cliente']. '" contenteditable="true">' .$fila['observaciones']. '</td>';
                     echo '<td align="center" style="width: 50px;" class="propio2"><a href="" id="btn_guarda" onclick="cliente_edita('. $fila['id_cliente'] .');"><img src="imagenes/small_modify_icon.png" /></a></td>';
                     echo '<td align="center" style="width: 50px;" class="propio2"><a href="" id="btn_elimina" onclick="cliente_elimina('. $fila['id_cliente'] .');"><img src="imagenes/small_delete_icon.png" /></a></td></tr>';
                     $sw_color = 0;
                     $contador++;
                  }
               }
               echo '</tbody>';
               echo '</table>';
               echo '<br>';
            }
            else {
               echo '<label>A&uacute;n no existen registros cargados</label>';
            }
         ?>
         <br>
      </div>
   </body>
</form>