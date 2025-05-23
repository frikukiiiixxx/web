<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
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
            color: white; /* Color del texto blanco */
        }
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background-color: black; /* Encabezado negro */
            color: white; /* Texto blanco */
            display: flex;
            align-items: center;
            justify-content: space-between; /* Espacio entre los elementos */
            padding: 0 20px; /* Espaciado lateral */
            font-size: 24px;
        }

        /* Menú desplegable en la parte superior izquierda */
        .dropdown {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #333;
            color: white; /* Texto blanco en el botón de menú */
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .dropdown:hover {
            background-color: #444; /* Cambio de color en hover */
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: 40px;
            left: 0;
            background-color: #444; /* Fondo gris oscuro */
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 5px;
        }

        .dropdown-content a {
            color: white; /* Texto blanco en los enlaces */
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .dropdown-content a:hover {
            background-color: #555; /* Gris más claro en hover */
            transform: translateY(-2px); /* Efecto de desplazamiento hacia arriba */
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .container {
            padding: 80px 20px; /* Espacio para el encabezado fijo */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        a.button {
            display: inline-block;
            padding: 10px 15px;
            margin: 10px 0;
            background-color: #555; /* Fondo gris oscuro */
            color: white; /* Texto blanco en los botones */
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid #666;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        a.button:hover {
            background-color: #777; /* Gris más claro en hover */
            transform: translateY(-2px); /* Efecto flotante */
        }

        div.product {
            background-color: rgba(50, 50, 50, 0.8); /* Fondo gris oscuro desvanecido */
            padding: 20px;
            margin: 10px 0;
            border-radius: 10px; /* Bordes redondeados */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Sombra más pronunciada */
            max-width: 400px; /* Ancho máximo del contenedor */
            width: 100%; /* Ancho completo dentro del contenedor */
            text-align: center; /* Centrar el texto */
        }

        img {
            max-width: 100px;
            border-radius: 5px; /* Bordes redondeados para la imagen */
        }
    </style>
</head>
<body>

<header>
    <div>Lista de Productos</div>
    <a href="login.html" class="button" style="background-color: #e63946; color: white;">CERRAR SESIÓN</a>
</header>

<!-- Menú desplegable en la parte superior izquierda -->
<div class="dropdown">
    Menú
    <div class="dropdown-content">
        <a href="productos.php" class="button">INVENTARIO</a>
        <a href="users.php" class="button">USUARIOS ADMINS</a>
        <a href="users2.php" class="button">USUARIOS CLIENTES</a>
    </div>
</div>

<div class="container">
    <?php
    // Conexión a la base de datos
    $conn = new mysqli('localhost', 'root', '', 'inventario');

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Enlace para volver a index.php
    echo "<a href='index.php' class='button'>REGISTRAR</a>";

    $result = $conn->query("SELECT * FROM productoss");

    if ($result->num_rows > 0) {
        while ($producto = $result->fetch_assoc()) {
            echo "<div class='product'>";
            echo "ID: {$producto['id']}<br>";
            echo "Nombre: {$producto['nombre']}<br>";
            echo "Precio: {$producto['precio']}<br>";
            echo "Cantidad: {$producto['cantidad']}<br>";
            echo "<img src='{$producto['imagen']}' alt='{$producto['nombre']}'><br>";
            echo "<a href='actualizar_producto.php?id={$producto['id']}' class='button'>Actualizar</a> | ";
            echo "<a href='eliminar.php?id={$producto['id']}' class='button' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este producto?\")'>Eliminar</a>";
            echo "</div><hr>";
        }
    } else {
        echo "No hay productos registrados.";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
