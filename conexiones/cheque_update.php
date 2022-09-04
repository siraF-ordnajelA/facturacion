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

   $id_cheque = $_POST['id_cheque'];
   $fecha_emision = $_POST['fecha_emi'];
   $fecha_pago = $_POST['fecha_pag'];
   $importe = $_POST['importe'];
   $nro_cheque = $_POST['comprobante'];
   $id_banco = $_POST['banco'];
   $id_razon = $_POST['razon'];
   $observaciones = $_POST['obs'];
   $tipo_cheque = $_POST['tipo_cheq'];

   $query = "call edita_cheque($id_cheque, $tipo_cheque, $id_banco, '$fecha_emision', '$fecha_pago', $importe, $id_razon, '$nro_cheque', '$observaciones')";

   if (mysqli_query($conexion, $query)){
      echo "Actualizado correctamente.";
   }
   else {
      echo "Hubo un error al actualizar!.";
   }

   mysqli_close($conexion);
?>