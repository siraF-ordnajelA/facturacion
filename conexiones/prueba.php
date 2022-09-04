<?php
/*
$hostname = "localhost";
$username = "root";
$password = "M49fCqRzzI44swZi";
*/
$hostname = "localhost";
$username = "c1880898_cleaner";
$password = "feRI12rave";

// Create connection
$conn = new mysqli($hostname, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("La conexi&oacute;n fall&oacute;: " . $conn->connect_error);
}
echo "Conectado correctamente";
?>