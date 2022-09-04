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

   $emision = $_POST['tipo'];
   $fecha_emision = $_POST['fecha_e'];
   $fecha_pago = $_POST['fecha_p'];
   $banco = $_POST['banco'];
   $comprobante = $_POST['compro'];
   $importe = $_POST['importe'];
   $destinatario = $_POST['dest'];
   $observaciones = $_POST['obs'];
   
   $query1 = "call busca_chequee('$comprobante');";
   $query2 = "call agrega_chequee($emision, '$fecha_emision', '$fecha_pago', '$banco', '$comprobante', $importe, '$destinatario', '$observaciones');";
   $respuesta = mysqli_query($conexion, $query1);
   $cuenta = mysqli_num_rows($respuesta);
      
   if ($cuenta > 0){
      mysqli_close($conexion);
      echo "El comprobante ya existe!.";
   }
   else {
      $respuesta2 = mysqli_query($conexion2, $query2);
      mysqli_close($conexion2);
      echo "Se agrego correctamente el cheque.";
   }
?>