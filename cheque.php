<?php
   session_start();

   if (isset($_SESSION['loggedin']) && isset($_SESSION['id_empleado']) && $_SESSION['loggedin'] == true) {
      $id_usuario = $_SESSION['id_empleado'];
      $id_permiso = $_SESSION['id_permiso'];
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
   
   $respuesta = mysqli_query($conexion, "call select_chequee") or die(mysqli_error());
   $respuesta2 = mysqli_query($conexion2, "call select_bancos") or die(mysqli_error());
   $respuesta3 = mysqli_query($conexion3, "call select_clientes_all") or die(mysqli_error());
   $total = mysqli_num_rows($respuesta);
   $sw_color = 0;
?>
<html>
<head>
   <title>Cheques Emitidos</title>
</head>

<form id="form_cheques" method="post" action="">
   <body class="principal">
      <a href="cheque-add.php" class="boton" style="width: 200px">Agregar cheque emitido</a>
      <div>
         <?php 
            if ($total > 0) {
               echo '<table id="chequese" class="propio">';
               echo '<caption><center><label>Cheques emitidos</label></center></caption>';
               echo '<thead>';
               echo '<tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">TIPO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA EMISION</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA PAGO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IMPORTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">NRO.DE CHEQUE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">BANCO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">DESTINATARIO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">OBSERVACIONES</td><td colspan="2" style="background-color:rgba(230, 52, 74, 0.8);">&nbsp;</td></tr>';
               echo '</thead>';
               echo '<tbody>';
               while ($fila = mysqli_fetch_array($respuesta)) {
                  if ($sw_color == 0) {
                     echo '<tr>';
                     echo '<td align="center" class="propio1"><select class="propio" id="cbo_tipo_' .$fila['id_cheque']. '" onchange="tipo_cheque_select(2, ' .$fila['id_cheque']. ')">';
                     if ($fila['tipo_cheque'] == 2){echo '<option value="2" selected>Emitido</option><option value="1">Recibido</option>';}
                     if ($fila['tipo_cheque'] == 1){echo '<option value="2">Emitido</option><option value="1" selected>Recibido</option>';}
                     echo '</select></td>';
                     echo '<td align="center" class="propio1"><input class="propio" type="date" id="fecha_emision_' .$fila['id_cheque']. '" value="' .$fila['fecha_emision']. '" />';
                     echo '<td align="center" class="propio1"><input class="propio" type="date" id="fecha_pago_' .$fila['id_cheque']. '" value="' .$fila['fecha_pago']. '" />';
                     echo '<td align="center" class="propio1" id="txt_importe_' .$fila['id_cheque']. '" contenteditable="true">' .$fila['importe']. '</td>';
                     echo '<td align="center" class="propio1" id="txt_nro_comp_' .$fila['id_cheque']. '" contenteditable="true">' .$fila['nro_cheque']. '</td>';
                     echo '<td align="center" class="propio1"><select class="propio" id="cbo_banco_' .$fila['id_cheque']. '">';
                     while ($fila2 = mysqli_fetch_array($respuesta2)) {
                        if ($fila['banco'] == $fila2['id_banco']){
                           echo '<option value="'. $fila2['id_banco'] .'" selected>'. $fila2['nombre_banco'] .'</option>';
                        }
                        else {
                           echo '<option value="'. $fila2['id_banco'] .'">'. $fila2['nombre_banco'] .'</option>';
                        }
                     }
                     mysqli_data_seek($respuesta2, 0);
                     echo '</select></td>';
                     echo '<td align="center" class="propio1"><select class="propio" style="width: 300px;" id="cbo_clientes_' .$fila['id_cheque']. '" disabled>';
                     while ($fila3 = mysqli_fetch_array($respuesta3)) {
                        if ($fila['destinatario'] == $fila3['id_cliente']){
                           echo '<option value="'. $fila3['id_cliente'] .'" selected>'. $fila3['razon'] .'</option>';
                        }
                        else {
                           echo '<option value="'. $fila3['id_cliente'] .'">'. $fila3['razon'] .'</option>';
                        }
                     }
                     mysqli_data_seek($respuesta3, 0);
                     echo '</select></td>';
                     echo '<td align="center" class="propio1" id="txt_observaciones_' .$fila['id_cheque']. '" contenteditable="true">' .$fila['observaciones']. '</td>';
                     //if($id_permiso == 1 && $fila['Diff'] < 2){
                        echo '<td align="center" style="width: 50px;" class="propio1"><a href="" id="btn_guarda" onclick="chequee_edita('. $fila['id_cheque'] .');"><img src="imagenes/small_modify_icon.png" /></a></td>';
                        echo '<td align="center" style="width: 50px;" class="propio1"><a href="" id="btn_elimina" onclick="chequee_elimina('. $fila['id_cheque'] .');"><img src="imagenes/small_delete_icon.png" /></a></td>';
                        //echo '<td align="center" style="width: 50px;" class="propio1"><a href="" id="btn_elimina" onclick="chequee_elimina('. $fila['id_cheque'] .');"><img src="imagenes/small_delete_icon.png" /></a></td></tr>';
                     /*}
                     else {*/
                        echo '</tr>';
                     //}
                     $sw_color = 1;
                  }
                  else {
                     echo '<tr>';
                     echo '<td align="center" class="propio2"><select class="propio" id="cbo_tipo_' .$fila['id_cheque']. '" onchange="tipo_cheque_select(2, ' .$fila['id_cheque']. ')">';
                     if ($fila['tipo_cheque'] == 2){echo '<option value="2" selected>Emitido</option><option value="1">Recibido</option>';}
                     if ($fila['tipo_cheque'] == 1){echo '<option value="2">Emitido</option><option value="1" selected>Recibido</option>';}
                     echo '</select></td>';
                     echo '<td align="center" class="propio2"><input class="propio" type="date" id="fecha_emision_' .$fila['id_cheque']. '" value="' .$fila['fecha_emision']. '" />';
                     echo '<td align="center" class="propio2"><input class="propio" type="date" id="fecha_pago_' .$fila['id_cheque']. '" value="' .$fila['fecha_pago']. '" />';
                     echo '<td align="center" class="propio2" id="txt_importe_' .$fila['id_cheque']. '" contenteditable="true">' .$fila['importe']. '</td>';
                     echo '<td align="center" class="propio2" id="txt_nro_comp_' .$fila['id_cheque']. '" contenteditable="true">' .$fila['nro_cheque']. '</td>';
                     echo '<td align="center" class="propio2"><select class="propio" id="cbo_banco_' .$fila['id_cheque']. '">';
                     while ($fila2 = mysqli_fetch_array($respuesta2)) {
                        if ($fila['banco'] == $fila2['id_banco']){
                           echo '<option value="'. $fila2['id_banco'] .'" selected>'. $fila2['nombre_banco'] .'</option>';
                        }
                        else {
                           echo '<option value="'. $fila2['id_banco'] .'">'. $fila2['nombre_banco'] .'</option>';
                        }
                     }
                     mysqli_data_seek($respuesta2, 0);
                     echo '</select></td>';
                     echo '<td align="center" class="propio2"><select class="propio" style="width: 300px;" id="cbo_clientes_' .$fila['id_cheque']. '" disabled>';
                     while ($fila3 = mysqli_fetch_array($respuesta3)) {
                        if ($fila['destinatario'] == $fila3['id_cliente']){
                           echo '<option value="'. $fila3['id_cliente'] .'" selected>'. $fila3['razon'] .'</option>';
                        }
                        else {
                           echo '<option value="'. $fila3['id_cliente'] .'">'. $fila3['razon'] .'</option>';
                        }
                     }
                     mysqli_data_seek($respuesta3, 0);
                     echo '</select></td>';
                     echo '<td align="center" class="propio2" id="txt_observaciones_' .$fila['id_cheque']. '" contenteditable="true">' .$fila['observaciones']. '</td>';
                     //if($id_permiso == 1 && $fila['Diff'] < 2){
                        echo '<td align="center" style="width: 50px;" class="propio2"><a href="" id="btn_guarda" onclick="chequee_edita('. $fila['id_cheque'] .');"><img src="imagenes/small_modify_icon.png" /></a></td>';
                        echo '<td align="center" style="width: 50px;" class="propio2"><a href="" id="btn_elimina" onclick="chequee_elimina('. $fila['id_cheque'] .');"><img src="imagenes/small_delete_icon.png" /></a></td>';
                        //echo '<td align="center" style="width: 50px;" class="propio2"><a href="" id="btn_elimina" onclick="chequee_elimina('. $fila['id_cheque'] .');"><img src="imagenes/small_delete_icon.png" /></a></td></tr>';
                     /*}
                     else {*/
                        echo '</tr>';
                     //}
                     $sw_color = 0;
                  }
               }
               echo '</tbody>';
               echo '</table>';
               echo '<br>';
            }
            else {
               echo '<label>No existen cheques cargados a&uacute;n</label>';
            }
         ?>
         <br>
      </div>
   </body>
</form>