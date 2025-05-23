<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    // Conexión a la base de datos
    $conn = new mysqli('localhost', 'root', '', 'inventario');

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Manejar la imagen si se sube una nueva
    $imagenPath = null;
    if (!empty($_FILES['imagen']['name'])) {
        $imagen = $_FILES['imagen'];
        $imagenPath = 'uploads/' . basename($imagen['name']);
        move_uploaded_file($imagen['tmp_name'], $imagenPath);
    }

    // Actualizar el producto en la base de datos
    if ($imagenPath) {
        $stmt = $conn->prepare("UPDATE productoss SET nombre = ?, precio = ?, cantidad = ?, imagen = ? WHERE id = ?");
        $stmt->bind_param("sdssi", $nombre, $precio, $cantidad, $imagenPath, $id);
    } else {
        $stmt = $conn->prepare("UPDATE productoss SET nombre = ?, precio = ?, cantidad = ? WHERE id = ?");
        $stmt->bind_param("sdii", $nombre, $precio, $cantidad, $id);
    }

    $stmt->execute();
    $mensaje = $stmt->affected_rows > 0 ? "Producto Actualizado" : "No se realizaron cambios";

    $stmt->close();
    $conn->close();
} else {
    $mensaje = "No se han recibido datos.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0; 
            background-image: url('imgs/fondo.png'); 
            background-size: cover; 
            background-position: center; 
            background-attachment: fixed; 
            color: #000; 
        }
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background-color: black; 
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .container {
            padding: 80px 20px; 
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .message {
            background-color: rgba(200, 200, 200, 0.8); 
            padding: 20px;
            border-radius: 10px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); 
            max-width: 400px; 
            width: 100%; 
            text-align: center; 
            margin-top: 20px; 
        }
        a.button {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 20px;
            background-color: #4CAF50; 
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }
        a.button:hover {
            background-color: #45a049; 
        }
    </style>
</head>
<body>

<header>
    Registro de Producto
</header>

<div class="container">
    <div class="message">
        <h1><?php echo $mensaje; ?></h1>
        <a href='productos.php' class='button'>Ver Productos</a>
    </div>
</div>

</body>
</html>
