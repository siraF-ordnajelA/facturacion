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
   $total = mysqli_num_rows($respuesta);
   $sw_color = 1;
?>
<html>
<head>
   <title>Bancos</title>
</head>

<form id="form_notas" method="post" action="">
   <body class="principal">
      <div>
         <a href="bancos-add.php" class="boton" style="width: 150px">Agregar banco</a>
         <?php 
            if ($total > 0) {
               echo '<table id="notas" class="propio">';
               echo '<thead>';
               echo '<tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">BANCO</td><td colspan="2" style="background-color:rgba(230, 52, 74, 0.8);">&nbsp;</td></tr>';
               echo '</thead>';
               echo '<tbody>';
               while ($fila = mysqli_fetch_array($respuesta)) {
                  if ($sw_color == 0) {
                     echo '<td align="center" class="propio1" id="txt_banco_' .$fila['id_banco']. '" contenteditable="true">' .$fila['nombre_banco']. '</td>';                     
                     echo '<td align="center" style="width: 50px;" class="propio1"><a href="" id="btn_guarda" onclick="banco_edita('. $fila['id_banco'] .');"><img src="imagenes/small_modify_icon.png" /></a></td>';
                     echo '<td align="center" style="width: 50px;" class="propio1"><a href="" id="btn_elimina" onclick="banco_elimina('. $fila['id_banco'] .');"><img src="imagenes/small_delete_icon.png" /></a></td></tr>';
                     $sw_color = 1;
                  }
                  else {
                     echo '<td align="center" class="propio2" id="txt_banco_' .$fila['id_banco']. '" contenteditable="true">' .$fila['nombre_banco']. '</td>';
                     echo '<td align="center" style="width: 50px;" class="propio2"><a href="" id="btn_guarda" onclick="banco_edita('. $fila['id_banco'] .');"><img src="imagenes/small_modify_icon.png" /></a></td>';
                     echo '<td align="center" style="width: 50px;" class="propio2"><a href="" id="btn_elimina" onclick="banco_elimina('. $fila['id_banco'] .');"><img src="imagenes/small_delete_icon.png" /></a></td></tr>';
                     $sw_color = 0;
                  }
               }
               echo '</tbody>';
               echo '</table>';
               echo '<br>';
            }
            else {
               echo '<label>A&uacute;n no hay bancos cargados.</label>';
            }
         ?>
         <br>
      </div>
   </body>
</form>