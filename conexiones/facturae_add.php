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

   $id_cliente = $_POST['id_cliente'];
   $fecha = $_POST['fecha'];
   $comprobante = $_POST['compro'];
   $importe = $_POST['importe'];
   $iva = $_POST['iva'];
   $tipo_factura = $_POST['tipo_f'];
   $opc_cobro = $_POST['cobro'];
   $observaciones = $_POST['obs'];
   
   $query1 = "call busca_facturae('$comprobante', $tipo_factura, $id_cliente);";
   $query2 = "call agrega_facturae($id_cliente, '$fecha', $comprobante, $importe, $iva, $tipo_factura, $opc_cobro, '$observaciones');";
   $respuesta = mysqli_query($conexion, $query1);
   $cuenta = mysqli_num_rows($respuesta);
      
   if ($cuenta > 0){
      mysqli_close($conexion);
      echo "El comprbante ya existe!.";
   }
   else {
      $respuesta2 = mysqli_query($conexion2, $query2);
      mysqli_close($conexion2);
      echo "Se agrego correctamente la factura emitida. Recuerde puede ser modificado hasta dentro de las proximas 24hs";
   }
?>