<?php
   session_start();

   if (isset($_SESSION['loggedin']) && isset($_SESSION['id_empleado']) && $_SESSION['loggedin'] == true) {
      $id_usuario = $_SESSION['id_empleado'];
   }
   else {
      header ('Location: acceso_denegado.html');
      exit;
   }
   
   $ahora = time();
   
   if ($ahora > $_SESSION['expire']) {
      session_destroy();
      echo "Su sesion a finalzado!.";
      echo "<a href='ingreso.php' target='_top'>[Volver a ingresar]</a>";
      exit;
   }
   
   include("conexiones/Conexiones.php");
   include("cabecera.php");
   
   $respuesta1 = mysqli_query($conexion, "call select_administradores") or die(mysqli_error());
   $respuesta2 = mysqli_query($conexion2, "call select_clientes(1)") or die(mysqli_error());
   $total = mysqli_num_rows($respuesta1);
?>
<html>
<head>
   <title>Agregar relacion Edificio</title>
</head>

<body class="principal">
   <form method="post" action="">
      <a href="relacion_administradores.php" class="boton" style="width: 90px">Volver</a>
      <br>
      <div class="contenedor_transp">
         <?php 
            if ($total > 0) {
               echo '<div class="titulo"><center>AGREGAR RELACION DE EDIFICIOS ASIGNADOS A CADA ADMINISTRACION</center></div>';
               echo '<br><br>';
               echo '<table align="center" id="admins_vs_edif" class="propio">';
               echo '<thead>';
               echo '<tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">ADMINISTRADOR</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">EDIFICIOS</td><td style="background-color:rgba(230, 52, 74, 0.8);">&nbsp;</td></tr>';
               echo '</thead>';
               echo '<tbody>';
               while ($fila1 = mysqli_fetch_array($respuesta1)) {
                  echo '<tr><td align="center" class="propio1">' .$fila1['razon']. '</td>';
                  echo '<td align="center" class="propio1"><select class="propio" id="cbo_clientes_' .$fila1['id_cliente']. '">';
                  echo '<option value="0">--Seleccione cliente para agregar--</option>';
                  while ($fila2 = mysqli_fetch_array($respuesta2)) {
                     echo '<option value="' .$fila2['id_cliente']. '">' .$fila2['razon']. '</option>';
                  }
                  mysqli_data_seek($respuesta2, 0);
                  echo '</select></td>';
                  echo '<td align="center" class="propio1"><button type="button" onclick="admin_relacion_agrega(' .$fila1['id_cliente']. ');" class="boton">Agregar</button></td></tr>';
               }
               echo '</tbody>';
               echo '</table>';
               echo '<br>';
            }
            else {
               echo 'No existen Administradores!. <a href="administradores-add.php">(Agregar)</a>';
            }
         ?>
         <br>
      </div>
   </form>
</body>