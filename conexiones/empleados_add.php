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

   //$id_empleado = $_POST['id_emp'];
   
   $apellido = $_POST['ap'];
   $nombre = $_POST['nom'];
   $documento = $_POST['docu'];
   $cuil = $_POST['cuilo'];
   $domicilio = $_POST['dom'];
   $piso = $_POST['p'];
   $depto = $_POST['d'];
   $localidad = $_POST['loc'];
   $provincia = $_POST['prov'];
   $email = $_POST['mail'];
   $contacto1 = $_POST['c1'];
   $contacto2 = $_POST['c2'];
   $bruto = $_POST['brutus'];
   $carga1 = $_POST['car1'];
   $carga2 = $_POST['car2'];
   $carga3 = $_POST['car3'];
   $jornada = $_POST['jornada'];
   $observaciones = $_POST['obs'];
   $permiso = $_POST['permiso'];

   $query1 = "call busca_dni($documento);";
   $query2 = "call agrega_empleado('$apellido', '$nombre', $documento, '$cuil', '$domicilio', $piso, '$depto', '$localidad', $provincia, $bruto, $carga1, $carga2, $carga3, $jornada, '$contacto1', '$contacto2', '$email', '$observaciones', $permiso);";
   $respuesta = mysqli_query($conexion, $query1);
   $cuenta = mysqli_num_rows($respuesta);
      
   if ($cuenta > 0){
      echo "El DNI ya existe!.";
   }
   else {
      $respuesta2 = mysqli_query($conexion2, $query2);
      echo "Se agrego correctamente el empleado.";
   }
   
   mysqli_close($conexion);
?>