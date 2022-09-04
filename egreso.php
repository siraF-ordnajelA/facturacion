<?php
   session_start();
   
   if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
      unset ($SESSION['username']);
      session_destroy();
      
      header('Location: ingreso.php');
      
      exit;
   }
?>   
<html>
<head>
   <title></title>      
   <style type="text/css">
      body{
			background-color: Black;
		}
      div.contenedor_transp{
         position: relative;
         margin: 0 auto;
         top: 110px;
         width: 280px;
         height: 80px;
         padding: 20px;
         border-radius: 15px;
         background-color: rgba(29,49,51,0.6);
      }
   </style>
</head>

<body>
   <div class="contenedor_transp">
      <center><a href="ingreso.php"><h1>VOLVER A INGRESAR...</h1></a></center>
   </div>
</body>
</html>