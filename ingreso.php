<?php
session_start();

include("conexiones/Conexiones.php");

if (!isset($_SESSION['contador'])){
   $_SESSION['contador'] = 0;//Con esta variable de sesion cuento la cantidad de intentos fallidos.
}

if (isset($_POST['check'])){
   $user = $_POST['txt_usuario'];
   $pass = $_POST['txt_pass'];

   if (!empty ($user) && !empty($pass)) {
      $user_limpio = preg_replace('([^A-Za-z0-9])', '', $user);//ELIMINA TODOS LOS CARACTERES RAROS DE LA VARIABLE $CONSULTA
      $pass_limpio = preg_replace('([^A-Za-z0-9])', '', $pass);
      
      if (!empty ($user_limpio) && !empty($pass_limpio)) {
         $respuesta = mysqli_query($conexion, "call usuario_login ('$user_limpio')") or die(mysqli_error());
         $fila = mysqli_fetch_array($respuesta);
         $total = mysqli_num_rows($respuesta);
         
         if ($total > 0){
            if (password_verify($pass, $fila['pass'])) {
               //Inicia Sesión
               $_SESSION['loggedin'] = true;
               $_SESSION['start'] = time();
               $_SESSION['expire'] = $_SESSION['start'] + (120 * 60);//DURACION DE LA SESION (Minutos * Segundos)
               $_SESSION['usuario'] = $fila['usuario'];
               $_SESSION['id_empleado'] = $fila['id_empleado'];
               $_SESSION['id_permiso'] = $fila['permisos'];

               header ('Location: caja.php');
            }
            else{
               //Redirige a la web de acceso denegado si la variable de sesion de usuario es FALSE
               echo '<script>alert ("Contrase\u00F1a incorrecta!.");</script>';
               $_SESSION['contador'] = $_SESSION['contador'] + 1;
               $conta = $_SESSION['contador'];
               //echo '<script>alert ("'.$conta.'");</script>';
               if ($conta >= 3){
                  header ('Location: acceso_denegado.html');
                  exit;
               }
            }
         }
         else{
            echo '<script>alert ("Ese usuario no existe.");</script>';
            $_SESSION['contador']++;
            $conta = $_SESSION['contador'];
            //echo '<script>alert ("'.$conta.'");</script>';
            if ($conta == 3){
               header ('Location: acceso_denegado.html');
               exit;
            }
         }
         mysqli_free_result($respuesta);
      }
      else{
         echo '<script>alert ("Debe ingresar alg\u00FAn criterio de b\u00FAsqueda v\u00E1lido.");</script>';
      }
      mysqli_close($conexion);
   }
   else {
      echo '<script>alert ("Debe completar ambos campos!.");</script>';
   }
}
?>

<html>
<head>
   <title>Ingreso al Sistema</title>
   <link href="imagenes/icono.png" type="imagenes/x-icon" rel="shortcut icon" />
   <link rel="stylesheet" href="css/iconos.css" type="text/css" />
   <style>
      @font-face {
         font-family: "MicroExtendFLF";
         font-style: bold;
         font-weight: Bold;
         src: local("?"), url("css/MicroExtendFLF-Bold.woff") format("woff"), url("css/MicroExtendFLF-Bold.ttf") format("truetype");
      }

      body {
         background-image: url("imagenes/back_login.jpg");
         background-repeat: no-repeat;
         background-attachment: fixed;
         background-position: center;
         background-color: Black;
         font-family: MicroExtendFLF;
         font-size: 12px;
         color: White;
      }
      
      div.contenedor_transp{
         position: relative;
         margin: 0 auto;
         top: 110px;
         width: 300px;
         height: 220px;
         padding: 20px;
         border-radius: 15px;
         background-color: rgba(29,49,51,0.8);
      }
      
      input{
         font-family: MicroExtendFLF;
         font-size: 12px;
         display: block;
         width: 100%;
         position: relative;
         border-top-left-radius: 6px;
         border-bottom-left-radius: 6px;
         border-top-right-radius: 6px;
         border-bottom-right-radius: 6px;
         background: transparent;
         border-top: 1px solid rgba(255,255,255,0.4);
         border-left: 1px solid rgba(255,255,255,0.4);
         border-bottom: 1px solid rgba(255,255,255,0.4);
         border-right: 1px solid rgba(255,255,255,0.4);
         color: white;
         padding: 10px 20px;
      }
      
      .icono {
         font-size: 22px;
      }
   </style>
</head>

<body>
   <form id="form_ingreso" method="post" action="">
      <div class="contenedor_transp">
         <center><h2>-LOGIN-</h2></center>
         <table align="center">
            <tr>
               <td align="right"><span class="icono icon icon-user"></span></td>
               <td><input type="text" name="txt_usuario" placeholder="Usuario"></td>
            <tr>
               <td align="right"><span class="icono icon icon-key"></span></td>
               <td><input type="password" name="txt_pass" placeholder="Password"></td>
            </tr>
            <tr>
               <td colspan="2">&nbsp;</td>
            <tr>
            <tr>
               <td colspan="2" align="center"><input type="submit" name="check" value="Login"></td>
            </tr>
         </table>
      </div>
   </form>
</body>
</html>