<?php
include("config2.php");
include("session.php");

$nombre = $_POST['nombre'];
$paterno = $_POST['paterno'];
$materno = $_POST['materno'];
$correo = $_POST['correo'];
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "INSERT INTO vender(nombre, paterno, materno, correo, usuario, password) 
VALUES('$nombre', '$paterno', '$materno', '$correo', '$username', '$password')";
if(mysqli_query($mysqli, $sql)){
    echo '<script language="javascript">';
	echo 'alert("Nuevo usuario agregado");';
	echo 'window.location="login2.html";';
	echo '</script>';
	
} else {
	echo '<script language="javascript">';
	echo 'alert("Usuario duplicado!");';
	echo 'window.location="registration.php";';
	echo '</script>';
}
?>