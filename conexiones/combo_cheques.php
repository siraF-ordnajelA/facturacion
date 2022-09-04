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
   
   $utilizado = $_POST['id_utilizado'];
   
   $query = "call select_cheque_no_utilizados($utilizado);";
   $respuesta = mysqli_query($conexion, $query);
      
   echo '<option value="0">--Seleccione cheque--</option>';
      
   while ($fila = mysqli_fetch_array($respuesta)) {
      echo '<option value="'. $fila['id_cheque'] .'">Nro: ' . $fila['nro_cheque'] . ' - Importe: ' . $fila['importe'] . ' - Razon: ' . $fila['razon'] . '</option>';
   }
      
   mysqli_close($conexion);
?>