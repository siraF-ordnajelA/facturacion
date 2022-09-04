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
   $punto = $_POST['punto_venta'];
   $comprobante = $_POST['compro'];
   $importe = $_POST['importe'];
   $iva = $_POST['iva'];
   $tipo_factura = $_POST['tipo_f'];
   $opc_cobro = $_POST['cobro'];
   $observaciones = $_POST['obs'];
   
   $query1 = "call busca_facturar('$comprobante', $tipo_factura, $id_cliente);";
   $query2 = "call agrega_facturar($id_cliente, '$fecha', $punto, $comprobante, $importe, $iva, $tipo_factura, $opc_cobro, '$observaciones');";
   $respuesta = mysqli_query($conexion, $query1);
   $cuenta = mysqli_num_rows($respuesta);
      
   if ($cuenta > 0){
      mysqli_close($conexion);
      echo "El comprobante ya existe!.";
   }
   else {
      $respuesta2 = mysqli_query($conexion2, $query2);
      mysqli_close($conexion2);
      echo "Se agrego correctamente la factura recibida.";
   }
?>