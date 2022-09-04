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
?>
<html>
<head>
   <title>B&uacute;squeda comprobantes</title>
</head>

<script type="text/javascript">
   $(document).ready(function () {
      
   });
</script>

<body class="principal">
   <form id="form_caja" method="post" action="pdf_comprobantes.php" target="_blank">
      <div class="contenedor_transp">
         <div class="form-row">
            <div class="form-group col-md-14">
               <div class="titulo"><center>BUSQUEDA DE COMPROBANTE POR TIPO, FECHA O NUMERO</center></div>
               <div class="custom-control custom-radio custom-control-inline" id="radios">
                 <!-- Default inline 1-->
                 <input type="radio" class="custom-control-input" id="rd_facturas_emitidas" name="rd_comprobantes" value="1">
                 <label class="custom-control-label" for="rd_facturas_emitidas">Facturas emitidas&nbsp;|&nbsp;</label>
                  <!-- Default inline 2-->
                 <input type="radio" class="custom-control-input" id="rd_facturas_recibidas" name="rd_comprobantes" value="2">
                 <label class="custom-control-label" for="rd_facturas_recibidas">Facturas recibidas&nbsp;|&nbsp;</label>
                 <!-- Default inline 3-->
                 <input type="radio" class="custom-control-input" id="rd_cheques" name="rd_comprobantes" value="3">
                 <label class="custom-control-label" for="rd_cheques">Cheques&nbsp;|&nbsp;</label>
                 <!-- Default inline 4-->
                 <input type="radio" class="custom-control-input" id="rd_notas" name="rd_comprobantes" value="4">
                 <label class="custom-control-label" for="rd_notas">Notas</label>
               </div>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-14">
               <input type="date" class="propio" id="fecha1" name="fecha1" />&nbsp;<input type="date" class="propio" id="fecha2" name="fecha2" />
               &nbsp;&nbsp;<input type="button" class="boton" id="btn_busca_1" value="Buscar" onclick="busca_factura(1);" />
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-14">
               <label for="txt_comprobante">N&uacute;mero de comprobante:</label>
               <input type="number" id="txt_comprobante" name="txt_comprobante" class="propio form-class" />
               &nbsp;&nbsp;<input type="button" class="boton" id="btn_busca_2" value="Buscar" onclick="busca_factura(2);" />
            </div>
         </div>
      </div>
      <br>
      <table id="t1" class="propio">
      </table>
      <br>
      <input type="submit" id="btn_pdf" name="btn_pdf" class="boton" value="Exportar a PDF" />
      <br>
   </form>
</body>