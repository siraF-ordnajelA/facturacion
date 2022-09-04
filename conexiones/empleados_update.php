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

   $id_empleado = $_POST['id_emp'];
   $apellido = $_POST['ap'];
   $nombre = $_POST['nom'];
   $documento = $_POST['docu'];
   $cuil = $_POST['cuilo'];
   $direccion = $_POST['dom'];
   $piso = $_POST['p'];
   $depto = $_POST['d'];
   $localidad = $_POST['loc'];
   $provincia = $_POST['prov'];
   $sbruto = $_POST['brutus'];
   $carga1 = $_POST['car1'];
   $carga2 = $_POST['car2'];
   $carga3 = $_POST['car3'];
   $jornada = $_POST['jor'];
   $contacto1 = $_POST['c1'];
   $contacto2 = $_POST['c2'];
   $email = $_POST['mail'];
   $observaciones = $_POST['obs'];

   $query = "call edita_empleado($id_empleado, '$apellido', '$nombre', $documento, '$cuil', '$direccion', $piso, '$depto', '$localidad', $provincia, $sbruto, $carga1, $carga2, $carga3, $jornada, '$contacto1', '$contacto2', '$email', '$observaciones')";

   if (mysqli_query($conexion, $query)){
      echo "Modificado correctamente.";
   }
   else {
      echo "Hubo un error al modificar!.";
   }

   mysqli_close($conexion);
?>