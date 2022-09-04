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
   
   $respuesta = mysqli_query($conexion, "call select_facturasr") or die(mysqli_error());
   $respuesta2 = mysqli_query($conexion2, "call select_admin_clientes(2)") or die(mysqli_error());
   $total = mysqli_num_rows($respuesta);
   $sw_color = 0;
?>
<html>
<head>
   <title>Facturas Recibidas</title>
</head>

<form id="form_facturasr" method="post" action="">
   <body class="principal">
      <a href="factura_recibida_add.php" class="boton" style="width: 210px">Agregar factura recibida</a>
      <div>
         <?php 
            if ($total > 0) {
               echo '<table id="facturasr" class="propio">';
               echo '<caption><center><label>Facturas recibidas</label></center></caption>';
               echo '<thead>';
               echo '<tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">PROVEEDOR</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">PTO. VENTA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">NRO COMPROBANTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IMPORTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IVA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">SALDO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">TIPO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">% IVA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">PAGO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">OBSERVACIONES</td><td colspan="2" align="center" style="background-color:rgba(230, 52, 74, 0.8);">&nbsp;ACCIONES&nbsp;</td></tr>';
               echo '</thead>';
               echo '<tbody>';
               while ($fila = mysqli_fetch_array($respuesta)) {
                  if ($sw_color == 0) {
                     echo '<td align="center" class="propio1"><input class="propio" type="date" id="fecha_'. $fila['id_factura_recibida'] .'" value="' .$fila['fecha']. '" /></td>';
                     echo '<td align="center" class="propio1"><select class="propio" id="cbo_cliente_' .$fila['id_factura_recibida']. '">';
                     while ($fila2 = mysqli_fetch_array($respuesta2)) {
                        if ($fila['id_cliente'] == $fila2['id_cliente']){
                           echo '<option value="'. $fila2['id_cliente'] .'" selected>'. $fila2['razon_cliente'] .'</option>';
                        }
                        else {
                           echo '<option value="'. $fila2['id_cliente'] .'">'. $fila2['razon_cliente'] .'</option>';
                        }
                     }
                     mysqli_data_seek($respuesta2, 0);
                     echo '</select></td>';
                     echo '<td align="center" class="propio1" id="txt_pto_venta_' .$fila['id_factura_recibida']. '" contenteditable="true">' .$fila['pto_venta']. '</td>';
                     echo '<td align="center" class="propio1" id="txt_nro_comp_' .$fila['id_factura_recibida']. '" contenteditable="true">' .$fila['nro_comprobante']. '</td>';
                     echo '<td align="center" class="propio1" id="txt_importe_' .$fila['id_factura_recibida']. '" contenteditable="true">' .number_format($fila['importe'], 2, ",", "."). '</td>';
                     echo '<td align="center" class="propio1" id="txt_iva_' .$fila['id_factura_recibida']. '">' .number_format($fila['iva'], 2, ",", "."). '</td>';
                     echo '<td align="center" class="propio1">' .number_format($fila['subtotal'], 2, ",", "."). '</td>';
                     echo '<td align="center" class="propio1"><select class="propio" id="cbo_factura_' .$fila['id_factura_recibida']. '" onchange="tipo_factura(1,' .$fila['id_factura_recibida']. ');">';
                     if ($fila['id_tipo'] == 1){echo '<option value="1" selected>A</option>';} else {echo '<option value="1">A</option>';}
                     if ($fila['id_tipo'] == 2){echo '<option value="2" selected>B</option>';} else {echo '<option value="2">B</option>';}
                     if ($fila['id_tipo'] == 3){echo '<option value="3" selected>C</option>';} else {echo '<option value="3">C</option>';}
                     echo '</select></td>';
                     echo '<td align="center" class="propio1"><select class="propio" id="cbo_iva_' .$fila['id_factura_recibida']. '" disabled>';
                     echo '<option value="' . round(($fila['iva']  * 100) / $fila['importe'], 1) . '">' . round(($fila['iva']  * 100) / $fila['importe'], 1) . '%</option>';
                     echo '</select></td>';
                     echo '<td align="center" class="propio1"><select class="propio" id="cbo_cobro_' .$fila['id_factura_recibida']. '">';
                     if ($fila['id_opc'] == 1){echo '<option value="1" selected>Transferencia</option>';} else {echo '<option value="1">Transferencia</option>';}
                     if ($fila['id_opc'] == 2){echo '<option value="2" selected>Cheque</option>';} else {echo '<option value="2">Cheque</option>';}
                     if ($fila['id_opc'] == 3){echo '<option value="3" selected>Efectivo</option>';} else {echo '<option value="3">Efectivo</option>';}
                     echo '</select></td>';
                     echo '<td align="center" class="propio1" id="txt_observaciones_' .$fila['id_factura_recibida']. '" contenteditable="true">' .$fila['observaciones']. '</td>';
                     echo '<td align="center" style="width: 50px;" class="propio1"><a href="#" id="btn_guarda" onclick="facturar_edita('. $fila['id_factura_recibida'] .');"><img src="imagenes/small_modify_icon.png" /></a></td>';
                     echo '<td align="center" style="width: 50px;" class="propio1"><a href="#" id="btn_elimina" onclick="facturar_elimina('. $fila['id_factura_recibida'] .');" value="Borrar"><img src="imagenes/small_delete_icon.png" /></a></td></tr>';
                     $sw_color = 1;
                  }
                  else {
                     echo '<td align="center" class="propio2"><input class="propio" type="date" id="fecha_'. $fila['id_factura_recibida'] .'" value="' .$fila['fecha']. '" /></td>';
                     echo '<td align="center" class="propio2"><select class="propio" id="cbo_cliente_' .$fila['id_factura_recibida']. '">';
                     while ($fila2 = mysqli_fetch_array($respuesta2)) {
                        if ($fila['id_cliente'] == $fila2['id_cliente']){
                           echo '<option value="'. $fila2['id_cliente'] .'" selected>'. $fila2['razon_cliente'] .'</option>';
                        }
                        else {
                           echo '<option value="'. $fila2['id_cliente'] .'">'. $fila2['razon_cliente'] .'</option>';
                        }
                     }
                     mysqli_data_seek($respuesta2, 0);
                     echo '</select></td>';
                     echo '<td align="center" class="propio2" id="txt_pto_venta_' .$fila['id_factura_recibida']. '" contenteditable="true">' .$fila['pto_venta']. '</td>';
                     echo '<td align="center" class="propio2" id="txt_nro_comp_' .$fila['id_factura_recibida']. '" contenteditable="true">' .$fila['nro_comprobante']. '</td>';
                     echo '<td align="center" class="propio2" id="txt_importe_' .$fila['id_factura_recibida']. '" contenteditable="true">' .number_format($fila['importe'], 2, ",", "."). '</td>';
                     echo '<td align="center" class="propio2" id="txt_iva_' .number_format($fila['id_factura_recibida'], 2, ",", "."). '">' .number_format($fila['iva'], 2, ",", "."). '</td>';
                     echo '<td align="center" class="propio2">' .number_format($fila['subtotal'], 2, ",", "."). '</td>';
                     echo '<td align="center" class="propio2"><select class="propio" id="cbo_factura_' .$fila['id_factura_recibida']. '" onchange="tipo_factura(1,' .$fila['id_factura_recibida']. ');">';
                     if ($fila['id_tipo'] == 1){echo '<option value="1" selected>A</option>';} else {echo '<option value="1">A</option>';}
                     if ($fila['id_tipo'] == 2){echo '<option value="2" selected>B</option>';} else {echo '<option value="2">B</option>';}
                     if ($fila['id_tipo'] == 3){echo '<option value="3" selected>C</option>';} else {echo '<option value="3">C</option>';}
                     echo '</select></td>';
                     echo '<td align="center" class="propio2"><select class="propio" id="cbo_iva_' .$fila['id_factura_recibida']. '" disabled>';
                     echo '<option value="' . round(($fila['iva']  * 100) / $fila['importe'], 1) . '">' . round(($fila['iva']  * 100) / $fila['importe'], 1) . '%</option>';
                     echo '</select></td>';
                     echo '<td align="center" class="propio2"><select class="propio" id="cbo_cobro_' .$fila['id_factura_recibida']. '">';
                     if ($fila['id_opc'] == 1){echo '<option value="1" selected>Transferencia</option>';} else {echo '<option value="1">Transferencia</option>';}
                     if ($fila['id_opc'] == 2){echo '<option value="2" selected>Cheque</option>';} else {echo '<option value="2">Cheque</option>';}
                     if ($fila['id_opc'] == 3){echo '<option value="3" selected>Efectivo</option>';} else {echo '<option value="3">Efectivo</option>';}
                     echo '</select></td>';
                     echo '<td align="center" class="propio2" id="txt_observaciones_' .$fila['id_factura_recibida']. '" contenteditable="true">' .$fila['observaciones']. '</td>';
                     echo '<td align="center" style="width: 50px;" class="propio2"><a href="#" id="btn_guarda" onclick="facturar_edita('. $fila['id_factura_recibida'] .');"><img src="imagenes/small_modify_icon.png" /></a></td>';
                     echo '<td align="center" style="width: 50px;" class="propio2"><a href="#" id="btn_elimina" onclick="facturar_elimina('. $fila['id_factura_recibida'] .');" value="Borrar"><img src="imagenes/small_delete_icon.png" /></a></td></tr>';
                     $sw_color = 0;
                  }
               }
               echo '</tbody>';
               echo '</table>';
               echo '<br>';
            }
            else {
               echo '<label>A&uacute;n no se han agregado facturas</label>';
            }
         ?>
         <br>
      </div>
   </body>
</form>