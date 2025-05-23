<?php
// Configuración de la base de datos
$servername = "localhost"; // Cambia si es necesario
$dbname = "inventario";

// Crear conexión
$conn = new mysqli($servername, null, null, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los datos
$sql = "SELECT id, nombre, precio, cantidad, imagen FROM productoss";
$result = $conn->query($sql);

$productos = [];

if ($result->num_rows > 0) {
    // Guardar los resultados en un array
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

$conn->close();
?>
