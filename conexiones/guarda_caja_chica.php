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

   $id_usuario = $_POST['id_usuario'];
   $nro_factura = $_POST['nro_fact'];
   $cobrado = $_POST['cobrado'];
   $pagado = $_POST['pagado'];
   $medio = $_POST['medio'];
   $observaciones = $_POST['obs'];
   
   $query = "call agrega_caja_chica($id_usuario, $nro_factura, $cobrado, $pagado, $medio, '$observaciones');";
   $respuesta = mysqli_query($conexion, $query);

   mysqli_close($conexion);
   echo "Se agregaron valores a caja.";
?>