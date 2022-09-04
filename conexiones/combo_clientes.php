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

   $id_tipo = $_POST['id_tipo'];
   
   $query = "call select_admin_clientes($id_tipo);";
   $respuesta = mysqli_query($conexion, $query);
      
   if ($id_tipo == 1) {
      echo '<option value="0">--Seleccione cliente--</option>';
   }
   if ($id_tipo == 2) {
      echo '<option value="0">--Seleccione proveedor--</option>';
   }
      
   while ($fila = mysqli_fetch_array($respuesta)) {
      echo '<option value="'. $fila['id_cliente'] .'">' . $fila['razon_cliente'] . '</option>';
   }
      
   mysqli_close($conexion);
?>