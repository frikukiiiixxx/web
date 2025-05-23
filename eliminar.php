<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventario";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = $_GET['id'];

$sql = "DELETE FROM productoss WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Producto eliminado exitosamente.";
} else {
    echo "Error eliminando el producto: " . $conn->error;
}

$conn->close();

// Redirigir a la página de productos después de eliminar
header("Location: index.php");
exit();
?>
