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

   $id_cliente = $_POST['id_cliente'];
   $nombre1 = $_POST['nombre1'];
   $c1 = $_POST['tel1'];
   $email1 = $_POST['email1'];
   $nombre2 = $_POST['nombre2'];
   $c2 = $_POST['tel2'];
   $email2 = $_POST['email2'];
   $nombre3 = $_POST['nombre3'];
   $c3 = $_POST['tel3'];
   $email3 = $_POST['email3'];
   $nombre4 = $_POST['nombre4'];
   $c4 = $_POST['tel4'];
   $email4 = $_POST['email4'];
   $nombre5 = $_POST['nombre5'];
   $c5 = $_POST['tel5'];
   $email5 = $_POST['email5'];
   $nombre6 = $_POST['nombre6'];
   $c6 = $_POST['tel6'];
   $email6 = $_POST['email6'];
   $nombre7 = $_POST['nombre7'];
   $c7 = $_POST['tel7'];
   $email7 = $_POST['email7'];
   $nombre8 = $_POST['nombre8'];
   $c8 = $_POST['tel8'];
   $email8 = $_POST['email8'];
   $nombre9 = $_POST['nombre9'];
   $c9 = $_POST['tel9'];
   $email9 = $_POST['email9'];
   $nombre10 = $_POST['nombre10'];
   $c10 = $_POST['tel10'];
   $email10 = $_POST['email10'];
   
   $query = "call edita_cliente_contactos($id_cliente, '$nombre1', '$nombre2', '$nombre3', '$nombre4', '$nombre5', '$nombre6', '$nombre7', '$nombre8', '$nombre9', '$nombre10', '$c1', '$c2', '$c3', '$c4', '$c5', '$c6', '$c7', '$c8', '$c9', '$c10', '$email1', '$email2', '$email3', '$email4', '$email5', '$email6', '$email7', '$email8', '$email9', '$email10');";
   $respuesta = mysqli_query($conexion, $query);
   
   mysqli_close($conexion);
   
   echo "Se modificaron correctamente los contactos del cliente.";
?>