<?php
session_start();

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'inventario');

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el carrito existe en la sesión
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    die('No hay productos en el carrito.');
}

// Calcular el total de la compra
$totalCompra = 0;
foreach ($_SESSION['carrito'] as $producto) {
    $totalCompra += $producto['total'];
}

if ($totalCompra <= 0) {
    die('El total de la compra no es válido.');
}

// Obtener detalles de productos desde la base de datos
$productIds = array_map(function($producto) { return $producto['id']; }, $_SESSION['carrito']);
$productQuery = "SELECT * FROM productoss WHERE id IN (" . implode(',', array_map('intval', $productIds)) . ")";
$productResult = $conn->query($productQuery);

if ($productResult->num_rows > 0) {
    $productos = [];
    while ($row = $productResult->fetch_assoc()) {
        $productos[$row['id']] = $row;
    }
} else {
    die("No se encontraron productos en la base de datos.");
}

// Verificar si se está procesando el pago
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tarjeta']) && isset($_POST['numero']) && isset($_POST['expiracion'])) {
        foreach ($_SESSION['carrito'] as $producto) {
            $productoId = $producto['id'];
            $cantidadComprada = $producto['cantidad'];

            // Reducir la cantidad en la base de datos
            $stmt = $conn->prepare("UPDATE productoss SET cantidad = cantidad - ? WHERE id = ?");
            $stmt->bind_param("ii", $cantidadComprada, $productoId);
            $stmt->execute();
            $stmt->close();
        }

        unset($_SESSION['carrito']);
        // Aquí puedes redirigir a la página de confirmación si es necesario
        // header("Location: adela.php");
        // exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecciona tu Tarjeta</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Bebas Neue', sans-serif;
            background: #1d1d1d;
            color: #e1e1e1;
            margin: 0;
            padding: 0;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        header {
            text-align: center;
            padding: 20px;
            background: #111;
            color: #f5f5f5;
            position: relative;
            border-bottom: 2px solid #444;
        }
        header h1 {
            font-size: 32px;
            letter-spacing: 2px;
        }
        .container {
            text-align: center;
            background-color: #2c2c2c;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
            width: 90%;
            max-width: 900px;
            margin: 30px auto;
            border: 1px solid #333;
        }
        .card-option {
            display: inline-block;
            width: 200px;
            height: 280px;
            margin: 20px;
            padding: 15px;
            border: 3px solid #333;
            cursor: pointer;
            border-radius: 12px;
            background-color: #333;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-option:hover {
            transform: scale(1.08);
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.2);
        }
        .card-option img {
            width: 90%;
            height: auto;
            border-radius: 8px;
            margin: 15px auto;
            display: block;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            animation: fadeInModal 0.5s ease-in-out;
        }

        @keyframes fadeInModal {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .modal-content {
            background-color: #222;
            padding: 40px;
            border-radius: 12px;
            width: 600px;
            text-align: center;
            color: #fff;
            position: relative;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.8);
        }
        .modal-content h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        .modal-content input {
            margin: 15px 0;
            padding: 15px;
            width: 100%;
            border-radius: 10px;
            border: 2px solid #444;
            background-color: #333;
            color: #fff;
            font-size: 16px;
        }
        .product-list table {
            width: 100%;
            border-collapse: collapse;
            font-size: 18px;
        }
        .product-list th, .product-list td {
            padding: 15px;
            text-align: left;
            border: 1px solid #444;
        }
        .product-list th {
            background-color: #111;
            color: #fff;
            font-size: 20px;
        }
        .product-list td {
            background-color: #333;
            color: #f5f5f5;
            font-size: 18px;
        }

        .pay-button {
            background-color: #fff;
            color: #333;
            font-size: 20px;
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 20px;
            text-align: center;
        }
        .pay-button:hover {
            background-color: #ccc;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 36px;
            color: #fff;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .close:hover {
            transform: rotate(90deg);
        }

        /* Estilos para la impresión */
        @media print {
            body {
                background: white;
                color: black;
                font-size: 12px;
            }
            .modal, .container {
                display: none;
            }
            .print-page {
                padding: 20px;
                width: 100%;
                text-align: center;
            }
            .barcode {
                margin-top: 30px;
                height: 80px;
                background-image: url('https://barcode.tec-it.com/barcode.ashx?data=1234567890&code=Code128&dpi=96&dataseparator=');
                background-repeat: no-repeat;
                background-position: center;
                background-size: contain;
            }
        }
    </style>
</head>
<body>


<header>
    <button onclick="window.location.href='carrito.php'" class="back-button">Regresar al Carrito</button>
    <img src="imagen/logo.png" alt="Logo" style="height: 100px; position: absolute; left: 20px; top: 20px;">

    <h1>Selecciona tu tarjeta para pagar</h1>
</header>

<div class="container">
    <form id="formularioTarjeta" method="POST">
        <input type="hidden" name="total_compra" value="<?php echo $totalCompra; ?>">

        <div class="card-option" onclick="mostrarModal('Visa')">
            <img src="imagenes/visa.png" alt="Visa">
        </div>

        <div class="card-option" onclick="mostrarModal('Mastercard')">
            <img src="imagenes/master.png" alt="Mastercard">
        </div>

        <div class="card-option" onclick="mostrarModal('Amex')">
            <img src="imagenes/carnet.png" alt="Amex">
        </div>

        <div class="card-option" onclick="mostrarModal('Discover')">
            <img src="imagenes/american.png" alt="Discover">
        </div>
    </form>
</div>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>
        <h2>Detalles de la tarjeta seleccionada</h2>
        
        <div class="product-list">
            <table>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>
                <?php
                $totalCompraCalculado = 0;
                foreach ($_SESSION['carrito'] as $producto) {
                    $productoInfo = $productos[$producto['id']];
                    $totalCompraCalculado += $productoInfo['precio'] * $producto['cantidad'];
                    echo "<tr>
                            <td>{$productoInfo['nombre']}</td>
                            <td>{$producto['cantidad']}</td>
                            <td>\${$productoInfo['precio']}</td>
                          </tr>";
                }
                ?>
                <tr>
                    <td colspan="2" style="text-align: right; font-weight: bold;">Total:</td>
                    <td style="font-weight: bold;">$<?php echo number_format($totalCompraCalculado, 2); ?></td>
                </tr>
            </table>
        </div>

        <h3>Detalles de tu tarjeta</h3>
        <input type="text" name="numero" placeholder="Número de tarjeta" required>
        <input type="text" name="cvv" placeholder="CVV" required>
        <input type="text" name="expiracion" placeholder="Fecha de expiración" required>

        <!-- Botón de pagar y generar ticket -->
        <button type="submit" class="pay-button" onclick="imprimirTicket()">Pagar y Generar Ticket</button>

        <div class="barcode"></div>
    </div>
</div>

<script>
    function mostrarModal(tarjeta) {
        document.getElementById('myModal').style.display = 'flex';
    }

    function cerrarModal() {
        document.getElementById('myModal').style.display = 'none';
    }

    function imprimirTicket() {
        window.print();
    }
</script>

</body>
</html>