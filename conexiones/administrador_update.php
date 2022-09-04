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

   $id_administrador = $_POST['id_admin'];
   $razon = $_POST['razo'];
   $nombre = $_POST['nom'];
   $direccion = $_POST['dom'];
   $cp = $_POST['cp'];
   $localidad = $_POST['loc'];
   $provincia = $_POST['prov'];
   $cuit = $_POST['cuito'];
   $abono = $_POST['abon'];
   $observaciones = $_POST['obs'];

   $query = "call edita_administrador($id_administrador, '$razon', '$nombre', '$direccion', '$cp', '$localidad', $provincia, '$cuit', $abono, '$observaciones')";

   if (mysqli_query($conexion, $query)){
      echo "Modificado correctamente.";
   }
   else {
      echo "Hubo un error al modificar!.";
   }

   mysqli_close($conexion);
?>