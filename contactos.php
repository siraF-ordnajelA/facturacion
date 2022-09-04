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
   $id_cliente = $_REQUEST['id'];
   
   $respuesta = mysqli_query($conexion, "call select_clientes_contactos($id_cliente)") or die(mysqli_error());
?>
<html>
<head>
   <title>Contactos</title>
</head>

<body class="principal">
   <form method="post" action="">
      <div class="contenedor_transp">
         <table align="center">
            <?php
               while ($fila = mysqli_fetch_array($respuesta)) {
                  echo '<tr><td colspan="6" align="center" style="background-color:rgba(230, 52, 74, 0.8);"><label>DATOS DE CONTACTO '. $fila['razon'] .'</label></td></tr>';
                  echo '<tr><td align="right"><label>Nombre:&nbsp;</label></td><td align="left"><input type="text" class="propio" id="txt_nombre_1" maxlength="80" value="'. $fila['nombre1'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Contacto:&nbsp;</label></td><td align="left"><input type="number" id="txt_contacto_1" maxlength="13" value="'. $fila['contacto1'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Mail:&nbsp;</label></td><td align="left" colspan="3"><input type="email" class="propio" id="txt_mail_1" maxlength="80" value="'. $fila['email'] .'" /></td></tr>';
                  echo '<tr><td align="right"><label>Nombre:&nbsp;</label></td><td align="left"><input type="text" class="propio" id="txt_nombre_2" maxlength="80" value="'. $fila['nombre2'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Contacto:&nbsp;</label></td><td align="left"><input type="number" id="txt_contacto_2" maxlength="13" value="'. $fila['contacto2'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Mail:&nbsp;</label></td><td align="left" colspan="3"><input type="email" class="propio" id="txt_mail_2" maxlength="80" value="'. $fila['email2'] .'" /></td></tr>';
                  echo '<tr><td align="right"><label>Nombre:&nbsp;</label></td><td align="left"><input type="text" class="propio" id="txt_nombre_3" maxlength="80" value="'. $fila['nombre3'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Contacto:&nbsp;</label></td><td align="left"><input type="number" id="txt_contacto_3" maxlength="13" value="'. $fila['contacto3'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Mail:&nbsp;</label></td><td align="left" colspan="3"><input type="email" class="propio" id="txt_mail_3" maxlength="80" value="'. $fila['email3'] .'" /></td></tr>';
                  echo '<tr><td align="right"><label>Nombre:&nbsp;</label></td><td align="left"><input type="text" class="propio" id="txt_nombre_4" maxlength="80" value="'. $fila['nombre4'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Contacto:&nbsp;</label></td><td align="left"><input type="number" id="txt_contacto_4" maxlength="13" value="'. $fila['contacto4'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Mail:&nbsp;</label></td><td align="left" colspan="3"><input type="email" class="propio" id="txt_mail_4" maxlength="80" value="'. $fila['email4'] .'" /></td></tr>';
                  echo '<tr><td align="right"><label>Nombre:&nbsp;</label></td><td align="left"><input type="text" class="propio" id="txt_nombre_5" maxlength="80" value="'. $fila['nombre5'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Contacto:&nbsp;</label></td><td align="left"><input type="number" id="txt_contacto_5" maxlength="13" value="'. $fila['contacto5'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Mail:&nbsp;</label></td><td align="left" colspan="3"><input type="email" class="propio" id="txt_mail_5" maxlength="80" value="'. $fila['email5'] .'" /></td></tr>';
                  echo '<tr><td align="right"><label>Nombre:&nbsp;</label></td><td align="left"><input type="text" class="propio" id="txt_nombre_6" maxlength="80" value="'. $fila['nombre6'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Contacto:&nbsp;</label></td><td align="left"><input type="number" id="txt_contacto_6" maxlength="13" value="'. $fila['contacto6'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Mail:&nbsp;</label></td><td align="left" colspan="3"><input type="email" class="propio" id="txt_mail_6" maxlength="80" value="'. $fila['email6'] .'" /></td></tr>';
                  echo '<tr><td align="right"><label>Nombre:&nbsp;</label></td><td align="left"><input type="text" class="propio" id="txt_nombre_7" maxlength="80" value="'. $fila['nombre7'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Contacto:&nbsp;</label></td><td align="left"><input type="number" id="txt_contacto_7" maxlength="13" value="'. $fila['contacto7'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Mail:&nbsp;</label></td><td align="left" colspan="3"><input type="email" class="propio" id="txt_mail_7" maxlength="80" value="'. $fila['email7'] .'" /></td></tr>';
                  echo '<tr><td align="right"><label>Nombre:&nbsp;</label></td><td align="left"><input type="text" class="propio" id="txt_nombre_8" maxlength="80" value="'. $fila['nombre8'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Contacto:&nbsp;</label></td><td align="left"><input type="number" id="txt_contacto_8" maxlength="13" value="'. $fila['contacto8'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Mail:&nbsp;</label></td><td align="left" colspan="3"><input type="email" class="propio" id="txt_mail_8" maxlength="80" value="'. $fila['email8'] .'" /></td></tr>';
                  echo '<tr><td align="right"><label>Nombre:&nbsp;</label></td><td align="left"><input type="text" class="propio" id="txt_nombre_9" maxlength="80" value="'. $fila['nombre9'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Contacto:&nbsp;</label></td><td align="left"><input type="number" id="txt_contacto_9" maxlength="13" value="'. $fila['contacto9'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Mail:&nbsp;</label></td><td align="left" colspan="3"><input type="email" class="propio" id="txt_mail_9" maxlength="80" value="'. $fila['email9'] .'" /></td></tr>';
                  echo '<tr><td align="right"><label>Nombre:&nbsp;</label></td><td align="left"><input type="text" class="propio" id="txt_nombre_10" maxlength="80" value="'. $fila['nombre10'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Contacto:&nbsp;</label></td><td align="left"><input type="number" id="txt_contacto_10" maxlength="13" value="'. $fila['contacto10'] .'" /></td>';
                  echo '<td align="right"><label>&nbsp;Mail:&nbsp;</label></td><td align="left" colspan="3"><input type="email" class="propio" id="txt_mail_10" maxlength="80" value="'. $fila['email10'] .'" /></td></tr>';
               }
               mysqli_close($conexion);
            ?>
            <tr>
               <td colspan="6">&nbsp;</td></tr>
            <tr>
               <td align="center" colspan="6"><button type="button" class="boton" onclick="cliente_contactos_modifica(<?php echo $id_cliente; ?>);">Modificar</button></td>
            </tr>
            <tr>
               <td colspan="6">&nbsp;</td>
            </tr>
         </table>
      </div>
   </form>
</body>
</html>