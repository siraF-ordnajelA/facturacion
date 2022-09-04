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

   $id_admin = $_POST['id_administrador'];
   $id_cliente = $_POST['id_cliente'];
   
   $query1 = "call busca_relacion_admin($id_admin, $id_cliente);";
   $query2 = "call agrega_relacion_admin($id_admin, $id_cliente);";
   $respuesta = mysqli_query($conexion, $query1);
   $fila = mysqli_fetch_array($respuesta);
   $cuenta = $fila['cuenta'];
      
   if ($cuenta > 0){
      mysqli_close($conexion);
      echo "La relacion ya existe!.";
   }
   else {
      $respuesta2 = mysqli_query($conexion2, $query2);
      mysqli_close($conexion2);
      echo "Se agrego correctamente la relacion.";
   }
?>