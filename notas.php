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
   
   $respuesta = mysqli_query($conexion, "call select_notas") or die(mysqli_error());
   $total = mysqli_num_rows($respuesta);
   $sw_color = 1;
?>
<html>
<head>
   <title>Notas</title>
</head>

<form id="form_notas" method="post" action="">
   <body class="principal">
      <div>
         <a href="notas-add.php" class="boton" style="width: 200px">Agregar nota de cr&eacute;dito</a>
         <?php 
            if ($total > 0) {
               echo '<table id="notas" class="propio" style="width:95%">';
               echo '<caption><center><label>Notas de cr&eacute;dito</label></center></caption>';
               echo '<thead>';
               echo '<tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">#ID</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">DETALLE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IMPORTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">CLIENTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">NRO. FACTURA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA FACTURA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IMPORTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IVA</td><td colspan="2">&nbsp;</td></tr>';
               echo '</thead>';
               echo '<tbody>';
               while ($fila = mysqli_fetch_array($respuesta)) {
                  if ($sw_color == 0) {
                     echo '<td align="center" class="propio1">' .$fila['id_nota']. '</td>';
                     echo '<td align="center" class="propio1"><input class="propio" type="date" id="fecha_' .$fila['id_nota']. '" value="' .$fila['fecha']. '" /></td>';
                     echo '<td align="center" class="propio1" id="txt_detalle_' .$fila['id_nota']. '" contenteditable="true">' .$fila['observaciones']. '</td>';
                     echo '<td align="center" class="propio1" id="txt_importe_' .$fila['id_nota']. '" contenteditable="true">' .number_format($fila['importe'], 2, ",", "."). '</td>';
                     echo '<td align="center" class="propio1">' .$fila['razon']. '</td>';
                     echo '<td align="center" class="propio1">00001-' .$fila['nro_factura']. '</td>';
                     echo '<td align="center" class="propio1">' .$fila['fecha_factura']. '</td>';
                     echo '<td align="center" class="propio1">' .number_format($fila['importe_factura'], 2, ",", "."). '</td>';
                     echo '<td align="center" class="propio1">' .number_format($fila['iva'], 2, ",", "."). '</td>';
                     echo '<td align="center" style="width: 50px;" class="propio1"><a href="" id="btn_guarda" onclick="nota_edita('. $fila['id_nota'] .');"><img src="imagenes/small_modify_icon.png" /></a></td>';
                     echo '<td align="center" style="width: 50px;" class="propio1"><a href="" id="btn_elimina" onclick="nota_elimina('. $fila['id_nota'] .');"><img src="imagenes/small_delete_icon.png" /></a></td></tr>';
                     $sw_color = 1;
                  }
                  else {
                     echo '<td align="center" class="propio2">' .$fila['id_nota']. '</td>';
                     echo '<td align="center" class="propio2"><input class="propio" type="date" id="fecha_' .$fila['id_nota']. '" value="' .$fila['fecha']. '" /></td>';
                     echo '<td align="center" class="propio2" id="txt_detalle_' .$fila['id_nota']. '" contenteditable="true">' .$fila['observaciones']. '</td>';
                     echo '<td align="center" class="propio2" id="txt_importe_' .$fila['id_nota']. '" contenteditable="true">' .number_format($fila['importe'], 2, ",", "."). '</td>';
                     echo '<td align="center" class="propio2">' .$fila['razon']. '</td>';
                     echo '<td align="center" class="propio2">00001-' .$fila['nro_factura']. '</td>';
                     echo '<td align="center" class="propio2">' .$fila['fecha_factura']. '</td>';
                     echo '<td align="center" class="propio2">' .number_format($fila['importe_factura'], 2, ",", "."). '</td>';
                     echo '<td align="center" class="propio2">' .number_format($fila['iva'], 2, ",", "."). '</td>';
                     echo '<td align="center" style="width: 50px;" class="propio2"><a href="" id="btn_guarda" onclick="nota_edita('. $fila['id_nota'] .');"><img src="imagenes/small_modify_icon.png" /></a></td>';
                     echo '<td align="center" style="width: 50px;" class="propio2"><a href="" id="btn_elimina" onclick="nota_elimina('. $fila['id_nota'] .');"><img src="imagenes/small_delete_icon.png" /></a></td></tr>';
                     $sw_color = 0;
                  }
               }
               echo '</tbody>';
               echo '</table>';
               echo '<br>';
            }
            else {
               echo '<label>A&uacute;n no existen notas cargadas.</label>';
            }
         ?>
         <br>
      </div>
   </body>
</form>