<?php
session_start();

// Verificar si el carrito existe en la sesión
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    $noHayProductos = true;  // Indicamos que no hay productos
} else {
    $noHayProductos = false;  // Indicamos que sí hay productos
    $totalGeneral = 0;
    // Calcular el total general
    foreach ($_SESSION['carrito'] as $producto) {
        $totalGeneral += $producto['total'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet"> <!-- Fuente urbana -->

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #333; /* Fondo oscuro */
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        header {
            text-align: center;
            padding: 30px;
            background-color: #222;
            color: #fff;
            margin-bottom: 40px;
            width: 100%;
            max-width: 1200px;
            border-radius: 10px;
            position: absolute;
            top: 0; /* Asegura que esté arriba de la pantalla */
            font-family: 'Anton', sans-serif; /* Fuente más urbana */
            display: flex;
            justify-content: space-between; /* Distribuye los elementos a ambos lados */
            align-items: center;
            padding: 20px;
            z-index: 1;
        }

        header h1 {
            font-size: 3rem;
            letter-spacing: 2px;
            margin: 0;
            text-transform: uppercase;
            color: #fff; /* Título blanco */
            text-shadow: 2px 2px 4px rgba(0,0,0,0.6); /* Efecto sombra para darle más estilo */
            text-align: left; /* Alineación del título a la izquierda */
            flex-grow: 1; /* Permite que el título ocupe el espacio intermedio */
            margin-left: 10px;
        }

        .header-buttons {
            display: flex;
            justify-content: space-between; /* Espacio entre los botones */
            gap: 10px; /* Separación entre los botones */
        }

        .header-buttons a {
            color: #fff;
            font-size: 16px;
            text-decoration: none;
            background: #222;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .header-buttons a:hover {
            background: #444;
            transform: translateY(-2px);
        }

        .logo {
            max-width: 50px; /* Ajusta el tamaño del logo */
            height: auto;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin-top: 140px; /* Espacio para el header */
            padding: 20px;
            background-color: #444;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: fadeInUp 1s ease-out; /* Animación para el contenedor */
        }

        .mensaje {
            text-align: center;
            color: #fff;
            font-size: 1.5em;
            margin-top: 20px;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
            background-color: #555;
            color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        th, td {
            padding: 15px;
            text-align: center;
            font-size: 1.2em;
        }

        th {
            background-color: #222;
        }

        td {
            background-color: #666;
        }

        tr:hover {
            background-color: #777;
            transform: scale(1.02);
            transition: all 0.3s ease-in-out;
        }

        .btn-danger {
            background: #cc0000;
            color: #fff;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-danger:hover {
            background: #a10000;
            transform: translateY(-2px);
        }

        .total {
            font-size: 1.8em;
            margin-top: 30px;
            text-align: center;
            color: #fff;
            font-weight: bold;
        }

        .checkout-btn {
            background: #fff; /* Botón blanco */
            color: #333; /* Texto en color oscuro */
            padding: 15px 30px;
            border-radius: 5px;
            font-size: 1.5em;
            text-decoration: none;
            cursor: pointer;
            margin-top: 20px;
            display: block;
            width: 100%;
            text-align: center;
            border: 2px solid #333; /* Borde negro */
            transition: background 0.3s ease, transform 0.3s ease, color 0.3s ease;
        }

        .checkout-btn:hover {
            background: #333; /* Fondo negro */
            color: #fff; /* Texto blanco al pasar el ratón */
            transform: scale(1.05);
        }

        /* Animación para el contenedor de productos */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animación para los productos */
        .product-row {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s forwards;
        }

        .product-row:nth-child(even) {
            animation-delay: 0.3s;
        }

        .product-row:nth-child(odd) {
            animation-delay: 0.5s;
        }

    </style>
</head>
<body>

<header>
    <img src="imagen/logo.png" alt="Logo" class="logo"> <!-- Aquí se coloca la ruta de tu logo -->
    <h1>Carrito de Compras</h1>
    <div class="header-buttons">
        <a href="nosotros.html" class="btn-back">Sobre Nosotros</a>
        <a href="adela.php" class="btn-back">Inicio</a>
        <!-- Agregamos el botón de "Regresar" -->
        <a href="javascript:history.back()" class="btn-back">Regresar</a>
    </div>
</header>

<div class="container">
    <?php if ($noHayProductos): ?>
        <div class="mensaje">
            <p>No hay productos en el carrito.</p>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($_SESSION['carrito'] as $key => $producto) {
                    echo "<tr class='product-row'>";
                    echo "<td>{$producto['nombre']}</td>";
                    echo "<td>{$producto['cantidad']}</td>";
                    echo "<td>\${$producto['precio']}</td>";
                    echo "<td>\${$producto['total']}</td>";
                    echo "<td><a href='eliminar_producto.php?id={$key}' class='btn-danger'>Eliminar</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="total">
            <strong>Total General: $<?php echo number_format($totalGeneral, 2); ?></strong>
        </div>

        <form action="seleccionar_tarjeta.php" method="POST">
            <input type="hidden" name="total_compra" value="<?php echo $totalGeneral; ?>">
            <button class="checkout-btn" type="submit">Finalizar Compra</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
