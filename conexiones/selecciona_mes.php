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
   
   $query = "call select_fecha_caja;";
   $respuesta = mysqli_query($conexion, $query);
   $total = mysqli_num_rows($respuesta);
   $datos = array();
   
   if ($total > 0){
      while ($fila = mysqli_fetch_array($respuesta)) {
         $datos[]['fecha'] = $fila['Fecha'];
      }
   }
   else {
      $datos['fecha'] = "No hay datos cargados";
   }
      
   mysqli_close($conexion);
   //returns data as JSON format
   echo json_encode($datos);
?>