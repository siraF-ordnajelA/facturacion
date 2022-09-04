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

   $accion = $_POST['accion'];
   $id_usuario = $_POST['id_user'];
   $usuario = $_POST['usuario'];
   $password_raw = $_POST['contra'];
   $tipo = $_POST['tipo'];

   // Edita Usuario y privilegio
   if ($accion == 1) {
      $query = "call edita_usuario($id_usuario, '$usuario', $tipo)";

      if (mysqli_query($conexion, $query)){
         echo "Usuario modificado correctamente.";
      }
      else {
         echo "Hubo un error al modificar!.";
      }
   }
   // Edita contraseña
   else {
      $phasheado = password_hash($password_raw, PASSWORD_BCRYPT);
      $query = "call edita_usuario_pass($id_usuario, '$phasheado')";

      if (mysqli_query($conexion, $query)){
         echo "Clave modificada correctamente.";
      }
      else {
         echo "Hubo un error al modificar!.";
      }
   }

   mysqli_close($conexion);
?>