<?php
session_start();

// Verificar si se ha recibido la información del producto
if (isset($_POST['id'], $_POST['nombre'], $_POST['precio'], $_POST['cantidad'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    // Calcular el monto total
    $total = $precio * $cantidad;

    // Verificar si ya existe un carrito de compras en la sesión
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Verificar si el producto ya está en el carrito
    $producto_existente = false;
    foreach ($_SESSION['carrito'] as &$producto) {
        if ($producto['id'] == $id) {
            // Si ya existe, actualizar la cantidad y el total
            $producto['cantidad'] += $cantidad;
            $producto['total'] = $producto['precio'] * $producto['cantidad'];
            $producto_existente = true;
            break;
        }
    }

    // Si el producto no está en el carrito, agregarlo
    if (!$producto_existente) {
        $_SESSION['carrito'][] = [
            'id' => $id,
            'nombre' => $nombre,
            'precio' => $precio,
            'cantidad' => $cantidad,
            'total' => $total
        ];
    }

    // Redirigir al carrito
    header("Location: carrito.php");
    exit;
} else {
    echo "Faltan datos del producto.";
}
?>
