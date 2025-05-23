<?php
session_start();

// Verificar si hay productos en el carrito
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    die('No hay productos en el carrito.');
}

// Verificar si los parámetros de pago están disponibles
$monto_total = $_POST['monto_total'] ?? '';
$producto = $_POST['producto'] ?? '';
$cantidad_comprada = $_POST['cantidad_comprada'] ?? 1;

if (empty($monto_total) || empty($producto) || empty($cantidad_comprada)) {
    die('No se ha proporcionado la información de la compra.');
}

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'inventario');

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el pago fue exitoso (simulando con la existencia del número de tarjeta)
if (isset($_POST['numero']) && isset($_POST['expiracion'])) {
    // Aquí iría la lógica del pago y la actualización del inventario
    // ... (esto ya lo tienes en el código original)
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .purchase-summary {
            margin-bottom: 30px;
        }

        .purchase-summary p {
            font-size: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #f2f2f2;
        }

        .card-option {
            display: inline-block;
            width: 150px;
            margin: 10px;
            padding: 20px;
            border: 2px solid #ccc;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .card-option:hover {
            background-color: #f0f0f0;
        }

        .card-option img {
            width: 100%;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
        }

        .modal-content input {
            margin: 10px 0;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .modal-content button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-content button:hover {
            background-color: #45a049;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Resumen de tu Compra</h1>

    <!-- Resumen de la compra -->
    <div class="purchase-summary">
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalCompra = 0;
                foreach ($_SESSION['carrito'] as $key => $producto) {
                    $totalCompra += $producto['total'];
                    echo "<tr>";
                    echo "<td>{$producto['nombre']}</td>";
                    echo "<td>{$producto['cantidad']}</td>";
                    echo "<td>\${$producto['precio']}</td>";
                    echo "<td>\${$producto['total']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <strong>Total a pagar: $<?php echo number_format($totalCompra, 2); ?></strong>
    </div>

    <!-- Opciones de pago -->
    <h2>Selecciona una tarjeta para pagar</h2>
    <div class="card-option" onclick="openForm()">
        <img src="https://via.placeholder.com/150x80/0000FF/FFFFFF?text=Visa" alt="Visa">
        <p>Visa</p>
    </div>
    <div class="card-option" onclick="openForm()">
        <img src="https://via.placeholder.com/150x80/000000/FFFFFF?text=Mastercard" alt="Mastercard">
        <p>Mastercard</p>
    </div>
    <div class="card-option" onclick="openForm()">
        <img src="https://via.placeholder.com/150x80/00BFFF/FFFFFF?text=Amex" alt="Amex">
        <p>American Express</p>
    </div>
    <div class="card-option" onclick="openForm()">
        <img src="https://via.placeholder.com/150x80/FF8C00/FFFFFF?text=Discover" alt="Discover">
        <p>Discover</p>
    </div>

    <!-- Formulario de pago -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeForm()">&times;</span>
            <h2>Datos de tu tarjeta</h2>
            <form method="POST" action="pagar.php">
                <input type="text" name="numero" placeholder="Número de tarjeta" required>
                <input type="text" name="expiracion" placeholder="Fecha de expiración (MM/AA)" required>
                <input type="text" name="nombre" value="Total a pagar: $<?php echo number_format($totalCompra, 2); ?>" readonly>
                <input type="hidden" name="monto_total" value="<?php echo $totalCompra; ?>">

                <button type="submit">Pagar</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Función para abrir el formulario del modal
    function openForm() {
        var modal = document.getElementById("myModal");
        modal.style.display = "flex"; // Mostrar el modal
    }

    // Función para cerrar el modal
    function closeForm() {
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    }
</script>

</body>
</html>
