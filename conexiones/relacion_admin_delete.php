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

   $id_admin = $_POST['id_admin'];
   $id_cliente = $_POST['id_cliente'];

   $query = "call elimina_relacion_admin($id_admin, $id_cliente)";

   if (mysqli_query($conexion, $query)){
      echo "Relacion eliminado correctamente.";
   }
   else {
      echo "Hubo un error al eliminar!.";
   }

   mysqli_close($conexion);
?>