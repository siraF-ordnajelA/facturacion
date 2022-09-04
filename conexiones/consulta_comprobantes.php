<?php
   session_start();

   if (isset($_SESSION['loggedin']) && isset($_SESSION['id_empleado']) && $_SESSION['loggedin'] == true) {
      $id_usuario = $_SESSION['id_empleado'];
   }
   else {
      header ('Location: ../acceso_denegado.html');
      exit;
   }
   
   $ahora = time();
   
   if ($ahora > $_SESSION['expire']) {
      session_destroy();
      echo "Su sesion a finalzado!.";
      echo "<a href='../ingreso.php' target='_top'>[Volver a ingresar]</a>";
      exit;
   }
   
   include("Conexiones.php");

   $id_accion = $_POST['id_accion'];
   $id_tipo_comprobante = $_POST['id_tipo_comprobante'];
   $id_comprobante = $_POST['id_comprobante'];
   
   //OPC 1 LISTA DE COMPROBANTES
   if ($id_accion == 1) {
      $query = "call select_comprobante($id_tipo_comprobante);";
      $respuesta = mysqli_query($conexion, $query);
      
      echo '<option value="0">-- Seleccione Factura --</option>';
      
      if ($id_tipo_comprobante == 1 OR $id_tipo_comprobante == 2) {
         while ($fila = mysqli_fetch_array($respuesta)) {
            echo '<option value="'. $fila['id_comprobante'] .'">'. $fila['razon'] .' ['. $fila['detalle'] .'] ' . $fila['fecha'] . ' - Saldo: $'. number_format($fila['saldo'], 2, ",", ".") .'</option>';
         }
      }
      else {
         if ($id_tipo_comprobante == 3) {
            while ($fila = mysqli_fetch_array($respuesta)) {
               echo '<option value="'. $fila['id_comprobante'] .'">Destinatario: '. $fila['destinatario'] .' - Nro '. $fila['detalle'] .' ' . $fila['fecha'] . ' - Importe: $'. number_format($fila['importe'], 2, ",", ".") .'</option>';
            }
         }
         while ($fila = mysqli_fetch_array($respuesta)) {
            echo '<option value="'. $fila['id_comprobante'] .'">'. $fila['detalle'] .'</option>';
         }
      }
      
      mysqli_close($conexion);
   }
   
   //OPC 2 LISTA DETALLE DE UN COMPROBANTE
   if ($id_accion == 2) {
      $query2 = "call select_comprobante_datos($id_tipo_comprobante, $id_comprobante);";
      $respuesta2 = mysqli_query($conexion2, $query2);
      $datos = array();
      
      while ($fila2 = mysqli_fetch_array($respuesta2)) {
         $datos['id_cliente'] = $fila2['id_cliente'];
         $datos['importe'] = $fila2['importe'];
         $datos['iva'] = $fila2['iva'];
         $datos['total'] = $fila2['total'];
      }
      
      mysqli_close($conexion2);
      //returns data as JSON format
      echo json_encode($datos, JSON_FORCE_OBJECT);
   }
?>