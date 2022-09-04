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
   
   $respuesta = mysqli_query($conexion, "call select_relacion_admin") or die(mysqli_error());
   $total = mysqli_num_rows($respuesta);
   $sw_color = 0;
?>
<html>
<head>
   <title>Edificios Administradores</title>
   <link rel="stylesheet" href="css/estilo.css" type="text/css" />
</head>

<form id="form_notas" method="post" action="">
   <body class="principal">
      <a href="administradores.php" class="boton" style="width: 90px">Volver</a>
      <a href="relacion_administradores_add.php" class="boton" style="width: 160px">Agregar relaci&oacute;n</a>
      <br>
      <div>
         <?php 
            if ($total > 0) {
               echo '<table align="center" id="admins_vs_edif" class="propio">';
               echo '<caption><center><div class="titulo"><label>ADMINISTRADORES Y EDIFICIOS ASIGNADOS</label></div></center></caption>';
               echo '<thead>';
               echo '<tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">ADMINISTRACION</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">ABONO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">EDIFICIOS</td><td style="background-color:rgba(230, 52, 74, 0.8);">&nbsp;</td></tr>';
               echo '</thead>';
               echo '<tbody>';
               while ($fila = mysqli_fetch_array($respuesta)) {
                  if ($sw_color == 0){
                     echo '<tr><td align="center" class="propio1">' .$fila['Administrador']. '</td>';
                     echo '<td align="center" class="propio1">' .$fila['abono']. '</td>';
                     echo '<td align="center" class="propio1">' .$fila['Cliente']. '</td>';
                     echo '<td class="propio1"><input type="button" class="boton" id="btn_elimina" onclick="admin_relacion_elimina('. $fila['id_admi'] .','. $fila['id_clientes'] .');" value="Borrar relaci&oacute;n"</td></tr>';
                     $sw_color = 1;
                  }
                  else {
                     echo '<tr><td align="center" class="propio2">' .$fila['Administrador']. '</td>';
                     echo '<td align="center" class="propio2">' .$fila['abono']. '</td>';
                     echo '<td align="center" class="propio2">' .$fila['Cliente']. '</td>';
                     echo '<td class="propio2"><input type="button" class="boton" id="btn_elimina" onclick="admin_relacion_elimina('. $fila['id_admi'] .','. $fila['id_clientes'] .');" value="Borrar relaci&oacute;n"</td></tr>';
                     $sw_color = 0;
                  }
               }
               echo '</tbody>';
               echo '</table>';
               echo '<br>';
            }
            else {
               echo 'No existen edificios relacionados a&uacute;n!. <a href="relacion_administradores_add.php">(Agregar)</a>';
            }
         ?>
         <br>
      </div>
   </body>
</form>