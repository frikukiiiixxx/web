<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'inventario');

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los parámetros de la URL
$id_producto = $_GET['id'];
$nombre_producto = $_GET['nombre'];
$precio_producto = $_GET['precio'];

// Lógica para procesar la compra cuando se envíe el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cantidad_comprada = $_POST['cantidad'];
    $talla_seleccionada = $_POST['talla'];  // Obtener la talla seleccionada
    $monto_total = $precio_producto * $cantidad_comprada;

    // Mostrar ticket de compra
    echo '<div class="ticket-container">';
    echo "<h2>Ticket de Compra</h2>";
    echo "<p><strong>Producto:</strong> {$nombre_producto}</p>";
    echo "<p><strong>Cantidad:</strong> {$cantidad_comprada}</p>";
    echo "<p><strong>Talla Seleccionada:</strong> {$talla_seleccionada}</p>";  // Mostrar la talla
    echo "<p><strong>Precio Unitario:</strong> $ {$precio_producto}</p>";
    echo "<p><strong>Monto Total:</strong> $ {$monto_total}</p>";
    
    // Formulario para ir a la página de pago
    echo '<form method="POST" action="pagar.php">';
    echo '<input type="hidden" name="monto_total" value="' . $monto_total . '">';
    echo '<input type="hidden" name="producto" value="' . $nombre_producto . '">';
    echo '<input type="hidden" name="cantidad_comprada" value="' . $cantidad_comprada . '">';
    echo '<input type="hidden" name="talla" value="' . $talla_seleccionada . '">';  // Enviar la talla seleccionada
    echo '<button type="submit" class="btn-primary">Pagar</button>';
    echo '</form>';
    echo '</div>';
    
    // Detenemos el script después de mostrar el ticket
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar Producto</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            color: #e0e0e0;
            background: #1c1c1c;
        }

        header {
            background: #2c2c2c;
            color: #e0e0e0;
            padding: 10px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .title {
            display: flex;
            align-items: center;
            font-size: 28px;
            font-weight: 700;
            color: #e0e0e0;
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
        }

        .title img {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }

        .header-nav {
            display: flex;
            align-items: center;
        }

        .header-nav a {
            color: #e0e0e0;
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
            font-weight: 500;
            position: relative;
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header-nav a::after {
            content: '';
            display: block;
            height: 2px;
            background: #555;
            position: absolute;
            left: 0;
            bottom: -4px;
            width: 0;
            transition: width 0.3s;
        }

        .header-nav a:hover::after {
            width: 100%;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 15px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .form-container {
            background: #2c2c2c;
            border-radius: 10px;
            margin: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            width: 300px;
            height: auto;
            border: 2px solid #0066ff; /* Contorno azul fuerte */
            transition: transform 0.3s;
        }

        .form-container:hover {
            transform: scale(1.02);
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .form-container input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #444;
            color: #fff;
        }

        .btn-primary {
            background: #0066ff;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            display: inline-block;
            font-weight: 700;
            transition: background 0.3s, transform 0.3s;
            margin-top: 20px;
        }

        .btn-primary:hover {
            background: #0055cc;
            transform: translateY(-3px);
        }

        .ticket-container {
            background: #2c2c2c;
            border-radius: 10px;
            padding: 20px;
            margin: 30px auto;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            border: 2px solid #0066ff;
            color: #e0e0e0;
            text-align: center;
        }

        .ticket-container h2 {
            color: #0066ff;
        }

        .ticket-container p {
            font-size: 18px;
            margin-bottom: 10px;
        }

        footer {
            background: #2c2c2c;
            color: #e0e0e0;
            padding: 30px 0;
            text-align: center;
            font-size: 14px;
        }

        footer p {
            margin: 0;
        }

        footer a {
            color: #888;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .talla-buttons {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .btn-talla {
            background: #444;
            color: #e0e0e0;
            border: 1px solid #ccc;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
        }

        .btn-talla:hover {
            background: #0066ff;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>

<header>
    <div class="header">
        <div class="title">
            <img src="your-logo.png" alt="Logo"> 
            <h1>Compra del Producto</h1>
        </div>
        <div class="header-nav">
            <a href="#">Inicio</a>
            <a href="#">Productos</a>
            <a href="#">Contactos</a>
        </div>
    </div>
</header>

<div class="container">
    <div class="form-container">
        <h2>Producto: <?php echo $nombre_producto; ?></h2>
        <form method="POST">
            <label for="cantidad">Piezas deseadas:</label>
            <input type="number" id="cantidad" name="cantidad" value="1" min="1" max="99" required>

            <!-- Botones de Talla -->
            <label for="talla">Selecciona la talla:</label>
            <div class="talla-buttons">
                <input type="radio" id="S" name="talla" value="S" required>
                <label for="S" class="btn-talla">S</label>

                <input type="radio" id="M" name="talla" value="M">
                <label for="M" class="btn-talla">M</label>

                <input type="radio" id="L" name="talla" value="L">
                <label for="L" class="btn-talla">L</label>

                <input type="radio" id="XL" name="talla" value="XL">
                <label for="XL" class="btn-talla">XL</label>
            </div>
            
            <button type="submit" class="btn-primary">Generar Ticket</button>
        </form>
    </div>
</div>

</body>
</html>
