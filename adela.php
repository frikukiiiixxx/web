<?php
// Iniciar la sesión
session_start();

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'inventario');

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM productoss");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet"> <!-- Importar fuente urbana -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #1c1c1c;
            color: #e0e0e0;
            margin: 0;
            padding: 0;
            position: relative;
        }

        /* Carrusel lateral */
        .carousel {
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            width: 200px;
            height: auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            z-index: 10;
        }
        .carousel img {
            width: 200px;
            height: 150px;
            object-fit: cover;
            margin: 10px 0;
            border-radius: 10px;
            opacity: 0.8;
            transition: opacity 0.3s ease-in-out;
        }
        .carousel img:hover {
            opacity: 1;
            transform: scale(1.05);
        }

        /* Estilos del header */
        header {
            text-align: center;
            padding: 20px;
            background: #333;
            color: #fff;
            position: relative;
            margin-bottom: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        header h1 {
            font-size: 3rem;
            font-family: 'Bebas Neue', sans-serif;  /* Fuente urbana */
            color: #ffffff;  /* Color blanco para el título */
            letter-spacing: 3px;
            margin: 0;
        }

        /* Estilos del contenedor de los productos */
        .container {
            max-width: 1200px;
            margin: 20px auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .product-card {
            background: #333; /* Color gris oscuro */
            border-radius: 0; /* Borrar bordes redondeados para hacerlo cuadrado */
            margin: 20px;
            padding: 20px;
            width: 300px;
            height: auto;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s forwards; /* Animación para aparecer */
        }
        .product-card:nth-child(even) {
            animation-delay: 0.3s;
        }
        .product-card:nth-child(odd) {
            animation-delay: 0.5s;
        }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Ajuste en los bordes de las imágenes para hacerlas cuadradas */
        .product-card img {
            width: 300px;
            height: 200px;
            object-fit: contain;
            margin-bottom: 10px;
            transition: transform 0.4s ease;
        }

        .product-card:hover img {
            transform: scale(1.05);
        }

        /* Cambio de color a gris oscuro y cuadrado para el fondo de las tarjetas */
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.4);
        }

        /* Estilo de los botones */
        .btn-primary {
            background: #666; /* Gris más oscuro */
            color: #e0e0e0;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            display: inline-block;
            font-weight: 700;
            margin-top: 20px;
            transition: background 0.3s ease, transform 0.3s ease;
        }
        .btn-primary:hover {
            background: #555; /* Gris más oscuro */
            transform: translateY(-3px);
        }

        .quantity-input {
            background-color: #333;
            color: #fff;
            padding: 5px;
            border: 1px solid #666;
            border-radius: 5px;
            width: 60px;
            margin-top: 10px;
        }
        .quantity-input:focus {
            background-color: #16a085;
        }

        /* Botones de talla (decorativos) */
        .size-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }
        .size-button {
            background-color: #666;  /* Gris oscuro */
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .size-button:hover {
            background-color: #555; /* Gris más oscuro al pasar el ratón */
            transform: translateY(-2px);
        }

        /* Estilos de los botones del carrito y regresar */
        .btn-cart {
            position: absolute;
            top: 20px;
            right: 20px;
            background: transparent;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .btn-cart img {
            width: 50px;
            height: 50px;
        }
        .btn-cart:hover {
            transform: scale(1.1);
        }

        .btn-return {
            position: absolute;
            left: 20px;
            top: 20px;
            background: #666;
            color: #e0e0e0;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 700;
            transition: background 0.3s ease, transform 0.3s ease;
        }
        .btn-return:hover {
            background: #555;
            transform: translateY(-3px);
        }

        /* Animación de carga para los productos */
        .product-card {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s forwards;
        }
        .product-card:nth-child(even) {
            animation-delay: 0.3s;
        }
        .product-card:nth-child(odd) {
            animation-delay: 0.5s;
        }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Estilos del footer */
        footer {
            margin-top: 30px;
            width: 100%;
            background-color: #222;
            text-align: center;
            padding: 20px 0;
        }

        footer img {
            width: 100%;
            max-width: 1200px; /* Asegura que no se haga demasiado ancha */
            height: auto;
            object-fit: cover;
        }
    </style>
</head>
<body>

<header>
    <h1>Lista de Productos</h1>
    <!-- Botón para ver el carrito (usando una imagen) -->
    <a href="carrito.php" class="btn-cart">
        <img src="imagenes/carritoc.png" alt="Ver Carrito">
    </a>
    <!-- Botón para regresar a adela.html -->
    <a href="adela.html" class="btn-return">Regresar</a>
</header>

<div class="container">
    <?php
    if ($result) {
        if ($result->num_rows > 0) {
            while ($producto = $result->fetch_assoc()) {
                echo "<div class='product-card'>";
                // Verifica si la imagen es válida
                if (file_exists($producto['imagen'])) {
                    echo "<img src='{$producto['imagen']}' alt='{$producto['nombre']}'>";
                } else {
                    echo "<img src='ruta/default.jpg' alt='Imagen no disponible'>";
                }
                echo "<div class='product-details'>";
                echo "<strong>ID:</strong> {$producto['id']}<br>";
                echo "<strong>Nombre:</strong> {$producto['nombre']}<br>";
                echo "<strong>Precio:</strong> $ {$producto['precio']}<br>";
                echo "<strong>Disponible:</strong> {$producto['cantidad']}<br>";

                // Botones de talla (solo para decoración)
                echo "<div class='size-buttons'>
                        <button class='size-button'>S</button>
                        <button class='size-button'>M</button>
                        <button class='size-button'>L</button>
                        <button class='size-button'>XL</button>
                    </div>";

                // Campo para definir la cantidad
                echo "<label for='cantidad'>Cantidad:</label>";
                echo "<input type='number' name='cantidad' class='quantity-input' min='1' max='{$producto['cantidad']}' value='1' id='cantidad_{$producto['id']}'><br>";

                // Formulario para agregar al carrito
                echo "<form action='agregar_carrito.php' method='post'>
                        <input type='hidden' name='id' value='{$producto['id']}'>
                        <input type='hidden' name='nombre' value='{$producto['nombre']}'>
                        <input type='hidden' name='precio' value='{$producto['precio']}'>
                        <input type='hidden' name='cantidad' value='1' id='cantidad_hidden_{$producto['id']}'><br>
                        <button type='submit' class='btn-primary'>Agregar a Carrito</button>
                      </form>";

                echo "</div></div>";
            }
        } else {
            echo "<p>No hay productos registrados.</p>";
        }
    } else {
        echo "<p>Error en la consulta: " . $conn->error . "</p>";
    }

    $conn->close();
    ?>
</div>

<footer>
    <img src="imagenes/wepe.png" alt="Imagen de pie de página">
</footer>

</body>
</html>
