<?php
$id = $_GET['id'] ?? null;

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'inventario');

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el producto por ID
$stmt = $conn->prepare("SELECT * FROM productoss WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$producto = $result->fetch_assoc();

if (!$producto) {
    echo "Producto no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Producto</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;  /* Evitar desplazamiento horizontal */
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
            background-image: url('imgs/fondo.png'); /* Cambia esta ruta */
            background-size: cover;
            background-position: center;
            color: #333;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
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
            z-index: 1;  /* Asegura que el encabezado esté por encima del contenido */
        }

        .container {
            max-width: 400px;
            width: 100%;
            background: rgba(200, 200, 200, 0.9); /* Gris desvanecido */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            overflow: auto;  /* Asegura que el contenedor sea desplazable si es necesario */
            position: relative;
            z-index: 2;
        }

        h1 {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        img {
            display: block;
            margin: 20px auto;
            max-width: 200px;
        }
    </style>
</head>
<body>

<header>
    Actualizar Producto
</header>

<div class="container">
    <form action="guardar_actualizacion.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($producto['id']) ?>">
        
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" value="<?= htmlspecialchars($producto['precio']) ?>" required>

        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" value="<?= htmlspecialchars($producto['cantidad']) ?>" required>

        <label for="imagen">Imagen (opcional):</label>
        <input type="file" id="imagen" name="imagen" accept="image/*">

        <input type="submit" value="Actualizar Producto">
    </form>
    <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
</div>

</body>
</html>
