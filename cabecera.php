<?php
   //session_start();
   
   if (isset($_SESSION['loggedin']) && isset($_SESSION['id_empleado']) && $_SESSION['loggedin'] == true) {
      $id_usuario = $_SESSION['id_empleado'];
      $id_permiso = $_SESSION['id_permiso'];
      
      $random_version = mt_rand(1,1000);
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
?>

<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
   
   <meta http-equiv="expires" content="0">
   <meta http-equiv="Cache-Control" content="no-cache">
   <meta http-equiv="Pragma" CONTENT="no-cache">
   
   <link href="imagenes/icono.png" type="imagenes/x-icon" rel="shortcut icon" />
   <link rel="stylesheet" href="css/estilos.css">
	<link rel="stylesheet" href="css/iconos.css">
   <link rel="stylesheet" href="css/bootstrap.css">
   <!-- Select2 -->
   <link rel="stylesheet" href="css/select2.min.css">
   <link rel="stylesheet" href="css/select2-bootstrap4.min.css">
   
   <script src="Jawas/jquery-3.5.1.min.js"></script>
   <script language="JavaScript" type="text/javascript" src="Jawas/jawa.js?version=<?php echo $random_version; ?>"></script>
   <!-- Select2 -->
   <script src="Jawas/select2.full.js"></script>
   <script>
      $(function () {
         //Initialize Select2 Elements
         $('.select2').select2()

         //Initialize Select2 Elements
         $('.select2bs4').select2({
            theme: 'bootstrap4'
         })
         
         $('.select2').select2({
            containerCssClass: "pepe",
            selectionCssClass: "pepe",
            dropdownCssClass: "pepe",
            inputCssClass: "pepe"
         });
      })
   </script>
   <script language="JavaScript" type="text/javascript">
      $(document).ready(main);
      var contador = 1;
      
      function main () {
         $('.menu_bar').click(function(){
            if (contador == 1) {
               $('nav').animate({
                  left: '0'
               });
               contador = 0;
            } else {
               contador = 1;
               $('nav').animate({
                  left: '-100%'
               });
            }
         });
       
         // Mostramos y ocultamos submenus
         $('.submenu').click(function(){
            $(this).children('.children').slideToggle();
         });
      }
   </script>
</head>
<header>
		<div class="menu_bar">
			<a href="#" class="bt-menu"><span class="icon-size icon icon-menu3"></span>Men&uacute;</a>
		</div>
		<nav>
			<ul>
				<li><a href="caja.php"><span class="icon-size icon icon-home"></span>Inicio</a></li>
            <?php
               if($id_permiso == 1){
                  echo '<li class="submenu">';
                  echo '<a href="#"><span class="icon-size icon icon-pencil2"></span>ABM&nbsp;&nbsp;<span class="icon-size glyphicon glyphicon-chevron-down"></span></a>';
                  echo '<ul class="children">';
                  echo '<li class="submenu"><a href="administradores.php">Administradores <span class="icon-size icon icon-office"></span></a></li>';
                  echo '<li><a href="clientes.php">Clientes/Proveedores <span class="icon-size icon icon-newspaper"></span></a></li>';
                  echo '<li><a href="empleados.php">Empleados <span class="icon-size icon icon-address-book"></span></a></li>';
                  echo '<li><a href="bancos.php">Bancos <span class="icon-size icon icon-library"></span></a></li>';
                  echo '<li><a href="usuarios.php">Usuarios <span class="icon-size icon icon-users"></span></a></li>';
                  echo '</ul>';
                  echo '</li>';
               }
            ?>
            <li class="submenu">
               <a href="#"><span class="icon-size icon icon-file-text2"></span>Comprobantes&nbsp;&nbsp;<span class="icon-size glyphicon glyphicon-chevron-down"></span></a>
					<ul class="children">
                  <li><a href="facturas_emitidas.php">Facturas Emitidas <span class="icon-size icon icon-upload2"></span></a></li>
						<li><a href="facturas_recibidas.php">Facturas Recibidas <span class="icon-size icon icon-download2"></span></a></li>
						<li><a href="cheque.php">Cheques <span class="icon-size icon icon-newspaper"></span></a></li>
                  <li><a href="notas.php">Notas de cr&eacute;dito <span class="icon-size icon icon-attachment"></span></a></li>
					</ul>
				</li>
            <li class="submenu">
               <a href="#"><span class="icon-size icon icon-books"></span>Consultas&nbsp;&nbsp;<span class="icon-size glyphicon glyphicon-chevron-down"></span></a>
					<ul class="children">
						<li><a href="comprobantes.php">B&uacute;squeda de comprobantes <span class="icon-size icon icon-search"></span></a></li>
                  <li><a href="estado_cuentas.php">Facturaci&oacute;n por Clientes <span class="icon-size icon icon-paste"></span></a></li>
                  <li><a href="estado_cuentas_prov.php">Facturaci&oacute;n por Proveedores <span class="icon-size icon icon-paste"></span></a></li>
                  <li><a href="estado_caja.php">Estado Caja <span class="icon-size icon icon-stats-dots"></span></a></li>
					</ul>
				</li>
				<li><a href="caja_chica.php"><span class="icon-size icon icon-coin-dollar"></span>Caja Chica</a></li>
				<li><a href="egreso.php"><span class="icon-size icon icon-exit"></span>Salir</a></li>
			</ul>
		</nav>
	</header>
</html>