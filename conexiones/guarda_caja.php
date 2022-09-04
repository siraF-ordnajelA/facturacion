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
   
   include("Conexiones.php");

   $id_razon = $_POST['id_cliente'];
   $tipo_comprobante = $_POST['id_tipo_comprobante'];
   $id_factura = $_POST['nro_comprobante'];
   $id_cheque = $_POST['cheque'];
   $cobrado = $_POST['cobrado'];
   $pagado = $_POST['pagado'];
   $fecha_pagado = $_POST['f_pago'];
   $carga1 = $_POST['carga1'];
   $carga2 = $_POST['carga2'];
   $carga3 = $_POST['carga3'];
   $carga4 = $_POST['carga4'];
   $carga5 = $_POST['carga5'];
   $medio = $_POST['medio'];
   $pago = $_POST['pago'];
   $observaciones = $_POST['obs'];
   $id_usuario = $_POST['id_user'];
   
   $query = "call agrega_caja($id_razon, $tipo_comprobante, $id_factura, $id_cheque, $cobrado, $pagado, '$fecha_pagado', $carga1, $carga2, $carga3, $carga4, $carga5, $medio, $pago, '$observaciones', $id_usuario);";
   $respuesta = mysqli_query($conexion, $query);

   mysqli_close($conexion);
   echo "Se agregaron valores a caja. Recuerde que luego de las proximas 72hs, no pueden modificarse";
?>