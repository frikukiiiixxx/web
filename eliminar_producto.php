<?php
session_start();

// Verificar si el carrito existe y tiene productos
if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {

    // Verificar si el ID del producto a eliminar está presente en la URL
    if (isset($_GET['id'])) {
        $idProducto = $_GET['id'];

        // Verificar si el producto con ese ID existe en el carrito
        if (isset($_SESSION['carrito'][$idProducto])) {
            // Reducir la cantidad del producto en 1
            $_SESSION['carrito'][$idProducto]['cantidad']--;

            // Si la cantidad llega a 0, eliminar el producto del carrito
            if ($_SESSION['carrito'][$idProducto]['cantidad'] <= 0) {
                unset($_SESSION['carrito'][$idProducto]);
            }

            // Redirigir al carrito después de eliminar el producto
            header('Location: carrito.php');
            exit;
        } else {
            // Si el producto no existe en el carrito, redirigir con un mensaje de error
            echo "Producto no encontrado en el carrito.";
        }
    } else {
        // Si no se pasa el ID, redirigir al carrito
        header('Location: carrito.php');
        exit;
    }
} else {
    // Si no hay productos en el carrito, redirigir a la página principal o donde desees
    header('Location: adela.php');
    exit;
}
?>
