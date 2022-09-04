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
   
   $opc = $_POST['opc'];
   $tipo_comprobante = $_POST['compr'];
   $fecha1 = $_POST['fecha1'];
   $fecha2 = $_POST['fecha2'];
   $nro_comprobante = $_POST['nro_compro'];
   
   $query = "call busca_comprobantes($opc, $tipo_comprobante, '$fecha1', '$fecha2', $nro_comprobante);";
   $respuesta = mysqli_query($conexion, $query);
   $total = mysqli_num_rows($respuesta);
   $datos = array();

   if ($total > 0){
      while ($fila = mysqli_fetch_array($respuesta)) {
         $datos[] = $fila;
      }
   }
   else {
      $datos['respuesta'] = "No hay datos cargados";
   }
      
   mysqli_close($conexion);
   //returns data as JSON format
   echo json_encode($datos);
?>