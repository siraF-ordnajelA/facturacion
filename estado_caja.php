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
   
   
   if(isset($_POST["btn_busca"])){
      $fecha1 = $_POST['fecha1'];
      $fecha2 = $_POST['fecha2'];
      
      if (empty($fecha1) or empty($fecha2)){
         echo '<script>alert("Debe completar ambas fechas!.");</script>';
      }
      else {
         $respuesta = mysqli_query($conexion, "call busca_estado_caja('$fecha1', '$fecha2');") or die(mysqli_error());
         $fila = mysqli_fetch_array($respuesta);
         $total = mysqli_num_rows($respuesta);
      }
   }
?>
<html>
<head>
   <title>Estado de caja</title>
</head>

<script type="text/javascript">
   $(document).ready(function () {
      
   });
</script>

<body class="principal">
   <form id="form_caja" method="post" action="">
      <div class="contenedor_transp">
         <div class="form-row">
            <div class="titulo form-group col-md-12">
               <center>ESTADO DE CAJA</center>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-12">
               <label>Seleccione entre fechas:&nbsp;</label>
               <input type="date" class="propio" id="fecha1" name="fecha1" />&nbsp;<input type="date" class="propio" id="fecha2" name="fecha2" />
               &nbsp;&nbsp;<input type="submit" class="boton" id="btn_busca" name="btn_busca" value="Buscar" />
            </div>
         </div>
      </div>
      <br><br>
      <?php
         if(isset($total)){
            if ($fila['Facturado'] != ""){
               echo '<table class="propio">';
               echo '<caption><center><label>Calculado entre el '. $fecha1 .' y el '. $fecha2 .'</center></label></caption>';
               echo '<tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);"><h3>TOTAL IMPORTE</h3></td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);"><h3>IVA</h3></td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);"><h3>TOTAL FACTURADO</h3></td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);"><h3>TOTAL COBRADO</h3></td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);"><h3>SEG.SOCIAL</h3></td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);"><h3>CARGAS IVA</h3></td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);"><h3>GANANCIAS</h3></td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);"><h3>TOTAL CARGAS</h3></td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);"><h3>RESTA</h3></td>';
               echo '<tr><td align="center" class="propio1"><h1>$'. $fila['Facturado'] .'</h1></td></td><td align="center" class="propio1"><h1>$'. $fila['Iva'] .'</h1></td><td align="center" class="propio1"><h1>$'. $fila['Total'] .'</h1></td><td align="center" class="propio1"><h1>$'. $fila['Ganancias'] .'</h1><td align="center" class="propio1"><h1>$'. $fila['cargas1'] .'</h1></td><td align="center" class="propio1"><h1>$'. $fila['cargas2'] .'</h1></td><td align="center" class="propio1"><h1>$'. $fila['cargas3'] .'</h1></td><td align="center" class="propio1"><h1>$'. $fila['total_carga'] .'</h1></td><td align="center" class="propio1"><h1>$'. $fila['Saldos'] .'</h1></td></tr>';
               echo '</table>';
               //echo '<br>';
               echo '<a class="boton" href="pdf_estado_caja.php?f1=' . $fecha1 . '&f2=' . $fecha2 . ' " target="_blank">Exportar a PDF</a>';
               echo '<br>';
            }
            else {
               echo '<h2>No existen registros.</h2>';
            }
         }
      ?>
   </form>
</body>