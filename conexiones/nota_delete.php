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

   $id_nota = $_POST['id_nota'];

   $query = "call elimina_nota($id_nota)";

   if (mysqli_query($conexion, $query)){
      echo "Nota eliminada correctamente.";
   }
   else {
      echo "Hubo un error al eliminar!.";
   }

   mysqli_close($conexion);
?>