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

   $id_caja = $_POST['id_caja'];
   $id_tipo_factura = $_POST['id_tipo_factura'];
   $id_factura = $_POST['id_factura'];

   $query = "call elimina_caja($id_tipo_factura, $id_caja, $id_factura)";

   if (mysqli_query($conexion, $query)){
      echo "Registro eliminado correctamente. Se ha restaurado el saldo de la factura.";
   }
   else {
      echo "Hubo un error al eliminar el registro!.";
   }
   
   mysqli_close($conexion);
?>