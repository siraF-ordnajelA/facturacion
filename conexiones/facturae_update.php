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

   $id_factura = $_POST['id_factura'];
   $id_cliente = $_POST['id_cliente'];
   $fecha = $_POST['fecha'];
   $comprobante = $_POST['compro'];
   $importe = $_POST['importe'];
   $iva = $_POST['iva'];
   $tipo_factura = $_POST['tipo_f'];
   $observaciones = $_POST['obs'];
   
   $query = "call edita_facturae($id_factura, $id_cliente, '$fecha', $comprobante, $importe, $iva, $tipo_factura, '$observaciones');";
   $respuesta = mysqli_query($conexion, $query);

   mysqli_close($conexion);
   echo "Se modifico correctamente la factura emitida.";
?>