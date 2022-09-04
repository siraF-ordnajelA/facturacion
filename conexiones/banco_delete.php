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

   $id_banco = $_POST['id_banco'];
   
   $query = "call elimina_banco($id_banco);";
      
   if (mysqli_query($conexion, $query)){
      echo "Eliminado correctamente!.";
   }
   else {
      echo "Hubo un error al eliminar el banco!.";
   }
   
   mysqli_close($conexion);
?>