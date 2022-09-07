<?php
$hostname = "localhost";
$database = "501stargentina";
$username = "usuario";
$password = "password";

$conexion = mysqli_connect($hostname, $username, $password, $database) or trigger_error(mysqli_error(),E_USER_ERROR);
$conexion2 = mysqli_connect($hostname, $username, $password, $database) or trigger_error(mysqli_error(),E_USER_ERROR);
$conexion3 = mysqli_connect($hostname, $username, $password, $database) or trigger_error(mysqli_error(),E_USER_ERROR);
$conexion4 = mysqli_connect($hostname, $username, $password, $database) or trigger_error(mysqli_error(),E_USER_ERROR);
$conexion5 = mysqli_connect($hostname, $username, $password, $database) or trigger_error(mysqli_error(),E_USER_ERROR);
$conexion6 = mysqli_connect($hostname, $username, $password, $database) or trigger_error(mysqli_error(),E_USER_ERROR);
?>