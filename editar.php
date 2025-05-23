<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            width: 300px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Editar Producto</h1>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "inventario";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener el ID del producto
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        
        // Consultar los datos del producto
        $sql = "SELECT * FROM productoss WHERE id = $id";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "<p>Producto no encontrado.</p>";
            exit;
        }
    } else {
        echo "<p>ID no especificado.</p>";
        exit;
    }

    // Procesar el formulario al enviar
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad'];
        $imagen = $row['imagen']; // Mantener la imagen actual por defecto

        // Si se sube una nueva imagen, manejar el archivo
        if ($_FILES['imagen']['name']) {
            $imagen = $_FILES['imagen']['name'];
            // Mover el archivo a un directorio específico
            move_uploaded_file($_FILES['imagen']['tmp_name'], 'uploads/' . $imagen);
        }

        // Actualizar el producto en la base de datos
        $sql = "UPDATE productoss SET nombre=?, precio=?, cantidad=?, imagen=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdssi", $nombre, $precio, $cantidad, $imagen, $id);

        if ($stmt->execute()) {
            echo "<p>Producto actualizado con éxito.</p>";
            echo "<a href='productos.php'>Volver a productos</a>";
        } else {
            echo "<p>Error al actualizar el producto.</p>";
        }

        $stmt->close();
    }
    ?>

    <form method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>" required>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" value="<?php echo htmlspecialchars($row['precio']); ?>" required step="0.01">

        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" value="<?php echo htmlspecialchars($row['cantidad']); ?>" required>

        <label for="imagen">Imagen (opcional):</label>
        <input type="file" id="imagen" name="imagen"><br>

        <input type="submit" value="Actualizar Producto">
    </form>
</body>
</html>
