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
   $aprobacion = $_POST['aprueba'];

   $query = "call edita_aprobacion($id_caja, $aprobacion)";

   if (mysqli_query($conexion, $query)){
      echo "Modificado correctamente.";
   }
   else {
      echo "Hubo un error al modificar!.";
   }
   
   mysqli_close($conexion);
?>