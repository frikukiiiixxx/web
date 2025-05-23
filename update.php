<?php
include("config.php");
include("session.php");

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$paterno = $_POST['paterno'];
$materno = $_POST['materno'];
$correo = $_POST['correo'];
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "UPDATE usuarios SET nombre='$nombre', paterno='$paterno', materno='$materno', correo='$correo', usuario='$username', password='$password'
WHERE usuario='$id'";
if(mysqli_query($mysqli, $sql)){
    echo '<script language="javascript">';
    echo 'alert("Registro actualizado exitósamente");';
    echo 'window.location="users.php";';
    echo '</script>';
   
} else {
    echo '<script language="javascript">';
    echo 'alert("Error en proceso de actualización de registro!");';
    echo 'window.location="users.php";';
    echo '</script>';
}
?>