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

   $respuesta = mysqli_query($conexion, "call select_empleados") or die(mysqli_error());
   $total = mysqli_num_rows($respuesta);
   $sw_color = 0;
?>
<html>
<head>
   <title>ABM-Usuarios</title>
   <link rel="stylesheet" href="css/estilo.css" type="text/css" />
</head>

<form id="form_usuarios" method="post" action="">
   <body class="principal">
      <div>
         <?php 
            if ($total > 0) {
               echo '<div class="titulo"><label>TABLA DE USUARIOS DEL SISTEMA</label></div>';
               echo '<table id="usuarios" class="propio">';
               //echo '<caption><label>Tabla de Usuarios del Sistema</label></caption>';
               echo '<thead>';
               echo '<tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">#ID</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">ACTUALIZADO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">APELLIDO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">NOMBRE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">USUARIO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">PRIVILEGIO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">MODIFICAR USUARIO/ACCESO</td><td>&nbsp;</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">PASSWORD</td><td style="background-color:rgba(230, 52, 74, 0.8);">&nbsp;</td></tr>';
               echo '</thead>';
               echo '<tbody>';
               $total = 0;
               while ($fila = mysqli_fetch_array($respuesta)) {
                  $total = $total + 1;
                  if ($sw_color == 0) {
                     echo '<td align="center" class="propio1">' .$fila['id_empleado']. '</td>';
                     echo '<td align="center" class="propio1">' .$fila['fecha_actualizacion']. '</td>';
                     echo '<td align="center" class="propio1">' .$fila['apellido']. '</td>';
                     echo '<td align="center" class="propio1">' .$fila['nombre']. '</td>';
                     echo '<td align="center" class="propio1" id="txt_usuario_' .$fila['id_empleado']. '" contenteditable="true">' .$fila['usuario']. '</td>';
                     echo '<td align="center" class="propio1"><select class="propio" id="cbo_tipo_' .$fila['id_empleado']. '">';
                     if ($fila['permisos'] == 1){echo '<option value="1" selected>Administrador</option>';} else {echo '<option value="1">Administrador</option>';}
                     if ($fila['permisos'] == 2){echo '<option value="2" selected>Usuario</option>';} else {echo '<option value="2">Usuario</option>';}
                     echo '</select></td>';
                     echo '<td align="center" class="propio1"><input type="button" class="boton" onclick="modifica_user('. $fila['id_empleado'] .', 1);" value="Modificar" />&nbsp;<input type="button" class="boton" onclick="elimina_user('. $fila['id_empleado'] .');" value="Eliminar" /></td>';
                     echo '<td class="propio1">&nbsp;</td>';
                     echo '<td align="center" class="propio1"><input type="password" class="propio" id="txt_pass_' .$fila['id_empleado']. '" /></td>';
                     echo '<td class="propio1"><input type="button" class="boton" onclick="modifica_user('. $fila['id_empleado'] .', 2);" value="Actualizar Contrase&ntilde;a"</td></tr>';
                     $sw_color = 1;
                  }
                  else {
                     echo '<td align="center" class="propio2">' .$fila['id_empleado']. '</td>';
                     echo '<td align="center" class="propio2">' .$fila['fecha_actualizacion']. '</td>';
                     echo '<td align="center" class="propio2">' .$fila['apellido']. '</td>';
                     echo '<td align="center" class="propio2">' .$fila['nombre']. '</td>';
                     echo '<td align="center" class="propio2" id="txt_usuario_' .$fila['id_empleado']. '" contenteditable="true">' .$fila['usuario']. '</td>';
                     echo '<td align="center" class="propio2"><select class="propio" id="cbo_tipo_' .$fila['id_empleado']. '">';
                     if ($fila['permisos'] == 1){echo '<option value="1" selected>Administrador</option>';} else {echo '<option value="1">Administrador</option>';}
                     if ($fila['permisos'] == 2){echo '<option value="2" selected>Usuario</option>';} else {echo '<option value="2">Usuario</option>';}
                     echo '</select></td>';
                     echo '<td align="center" class="propio2"><input type="button" class="boton" onclick="modifica_user('. $fila['id_empleado'] .', 1);" value="Modificar" />&nbsp;<input type="button" class="boton" onclick="elimina_user('. $fila['id_empleado'] .');" value="Eliminar" /></td>';
                     echo '<td class="propio2">&nbsp;</td>';
                     echo '<td align="center" class="propio2"><input type="password" class="propio" id="txt_pass_' .$fila['id_empleado']. '" /></td>';
                     echo '<td class="propio2"><input type="button" class="boton" onclick="modifica_user('. $fila['id_empleado'] .', 2);" value="Actualizar Contrase&ntilde;a"</td></tr>';
                     $sw_color = 0;
                  }
               }
               echo '</tbody>';
               echo '</table>';
               echo '<br>';
            }
            else {
               echo 'No hay usuarios.';
            }
         ?>
         <br>
      </div>
   </body>
</form>