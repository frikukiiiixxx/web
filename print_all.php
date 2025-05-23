<?php
require('fpdf/fpdf.php');
include('config.php');
session_start();

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'inventario');
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si hay productos en el carrito
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    die('No hay productos en el carrito.');
}

// Calcular el total de la compra
$totalCompra = 0;
foreach ($_SESSION['carrito'] as $producto) {
    $totalCompra += $producto['total'];  // El total por producto ya está calculado en el carrito
}

// Obtener detalles de productos desde la base de datos
$productIds = array_map(function($producto) { return $producto['id']; }, $_SESSION['carrito']);
$productQuery = "SELECT * FROM productoss WHERE id IN (" . implode(',', array_map('intval', $productIds)) . ")";
$productResult = $conn->query($productQuery);

if ($productResult->num_rows > 0) {
    $productos = [];
    while ($row = $productResult->fetch_assoc()) {
        $productos[$row['id']] = $row;  // Almacenar productos con su ID como clave
    }
} else {
    die("No se encontraron productos en la base de datos.");
}

$pdf = new FPDF();
$pdf->AddPage();

// Encabezado
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Detalles de la Compra', 0, 1, 'C');

// Fecha de la compra
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, 10, 'Fecha: ' . date('d-m-Y'), 0, 1, 'R');
$pdf->Ln(10);

// Detalles de la compra (productos)
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 10, 'Producto', 1, 0, 'C');
$pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C');
$pdf->Cell(30, 10, 'Precio', 1, 0, 'C');
$pdf->Cell(30, 10, 'Subtotal', 1, 1, 'C');

// Mostrar los productos en el carrito
$pdf->SetFont('Arial', '', 12);
$totalCompraCalculado = 0;
foreach ($_SESSION['carrito'] as $producto) {
    $productoInfo = $productos[$producto['id']];
    $subtotal = $producto['cantidad'] * $productoInfo['precio'];
    $totalCompraCalculado += $subtotal;

    $pdf->Cell(90, 10, $productoInfo['nombre'], 1);
    $pdf->Cell(30, 10, $producto['cantidad'], 1, 0, 'C');
    $pdf->Cell(30, 10, '$' . number_format($productoInfo['precio'], 2), 1, 0, 'C');
    $pdf->Cell(30, 10, '$' . number_format($subtotal, 2), 1, 1, 'C');
}

// Total
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(150, 10, 'Total de la compra:', 1, 0, 'R');
$pdf->Cell(30, 10, '$' . number_format($totalCompraCalculado, 2), 1, 1, 'C');

// Salida del PDF
$pdf->Output();
?>
