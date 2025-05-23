<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Producto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0; /* Fondo gris claro */
            background-image: url('imgs/fondo.png'); /* Cambia esta ruta */
            background-size: cover; /* Cubrir toda la página */
            background-position: center; /* Centrar la imagen */
            background-attachment: fixed; /* Fijar la imagen al fondo */
            color: #000; /* Color del texto más oscuro */
        }
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background-color: black; /* Encabezado negro */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .container {
            padding: 80px 20px; /* Espacio para el encabezado fijo */
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        form {
            background-color: rgba(200, 200, 200, 0.8); /* Fondo gris desvanecido */
            padding: 20px;
            border-radius: 10px; /* Bordes redondeados */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Sombra */
            max-width: 400px; /* Ancho máximo del formulario */
            width: 100%; /* Ancho completo dentro del contenedor */
            text-align: center; /* Centrar el texto */
        }
        label {
            display: block;
            margin: 10px 0 5px; /* Espaciado entre etiquetas y campos */
        }
        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: calc(100% - 20px); /* Ancho completo menos margen */
            padding: 10px;
            border-radius: 5px; /* Bordes redondeados para campos de entrada */
            border: 1px solid #ccc;
            margin-bottom: 15px; /* Espaciado inferior */
        }
        input[type="submit"] {
            background-color: #f5f5dc; /* Color beige */
            color: black;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #e6e6b2; /* Un tono más oscuro en hover */
        }
        a.button {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 20px;
            background-color: #4CAF50; /* Color verde */
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }
        a.button:hover {
            background-color: #45a049; /* Un tono más oscuro en hover */
        }
    </style>
</head>
<body>

<header>
    Registrar Producto
</header>

<div class="container">
    <form action="guardar.php" method="POST" enctype="multipart/form-data">
        <label for="id">ID del Producto:</label>
        <input type="text" id="id" name="id" required>

        <label for="nombre">Nombre del Producto:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" required>

        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" required>

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*" required>

        <input type="submit" value="Registrar Producto">
    </form>

    <!-- Botón para ver productos -->
    <a href="productos.php" class="button">Ver Productos</a>
</div>

</body>
</html>
