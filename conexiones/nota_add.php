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

   $detalle = $_POST['detalle'];
   $importe = $_POST['importe'];;
   $factura_id = $_POST['id_factura'];
   
   $query1 = "call busca_notas($factura_id);";
   $query2 = "call agrega_notas('$detalle', $importe, $factura_id);";
   $respuesta = mysqli_query($conexion, $query1);
   $cuenta = mysqli_num_rows($respuesta);
      
   if ($cuenta > 0){
      mysqli_close($conexion);
      echo "La nota relacionada a esa factura ya existe!.";
      mysqli_close($conexion);
   }
   else {
      $respuesta2 = mysqli_query($conexion2, $query2);
      mysqli_close($conexion2);
      echo "Se agrego correctamente la nota.";
   }
?>