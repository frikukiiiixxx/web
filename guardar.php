<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    // Manejo de la imagen
    $imagen = $_FILES['imagen'];
    $imagenPath = 'uploads/' . basename($imagen['name']);
    move_uploaded_file($imagen['tmp_name'], $imagenPath);

    // Conexión a la base de datos
    $conn = new mysqli('localhost', 'root', '', 'inventario');

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("INSERT INTO productoss (id, nombre, precio, cantidad, imagen) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdis", $id, $nombre, $precio, $cantidad, $imagenPath);

    if ($stmt->execute()) {
        echo "<html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Producto Registrado</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f0f0f0;
                    background-image: url('imgs/fondo.png');
                    background-size: cover;
                    background-position: center;
                    background-attachment: fixed;
                    color: white;
                }

                header {
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    height: 60px;
                    background-color: black;
                    color: white;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    padding: 0 20px;
                    font-size: 24px;
                }

                .dropdown {
                    position: absolute;
                    top: 10px;
                    left: 10px;
                    background-color: #333;
                    color: white;
                    border-radius: 5px;
                    padding: 10px;
                    cursor: pointer;
                    font-size: 18px;
                    transition: background-color 0.3s ease;
                }

                .dropdown:hover {
                    background-color: #444;
                }

                .dropdown-content {
                    display: none;
                    position: absolute;
                    top: 40px;
                    left: 0;
                    background-color: #444;
                    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
                    z-index: 1;
                    border-radius: 5px;
                }

                .dropdown-content a {
                    color: white;
                    padding: 12px 16px;
                    text-decoration: none;
                    display: block;
                    font-size: 16px;
                    transition: background-color 0.3s ease, transform 0.3s ease;
                }

                .dropdown-content a:hover {
                    background-color: #555;
                    transform: translateY(-2px);
                }

                .dropdown:hover .dropdown-content {
                    display: block;
                }

                .container {
                    padding: 80px 20px;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }

                a.button {
                    display: inline-block;
                    padding: 10px 15px;
                    margin: 10px 0;
                    background-color: #555;
                    color: white;
                    text-decoration: none;
                    border-radius: 5px;
                    border: 1px solid #666;
                    transition: background-color 0.3s ease, transform 0.3s ease;
                }

                a.button:hover {
                    background-color: #777;
                    transform: translateY(-2px);
                }

                div.product {
                    background-color: rgba(50, 50, 50, 0.8);
                    padding: 20px;
                    margin: 10px 0;
                    border-radius: 10px;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                    max-width: 400px;
                    width: 100%;
                    text-align: center;
                }

                img {
                    max-width: 100px;
                    border-radius: 5px;
                }
            </style>
        </head>
        <body>
            

            

            <div class='container'>
                <div class='product'>
                    <h2>Producto Registrado</h2>
                    <p>ID: $id</p>
                    <p>Nombre: $nombre</p>
                    <p>Precio: $precio</p>
                    <p>Cantidad: $cantidad</p>
                    <img src='$imagenPath' alt='$nombre' style='max-width:200px;'><br>
                    <a href='productos.php' class='button'>Ver Productos</a>
                </div>
            </div>
        </body>
        </html>";
    } else {
        echo "Error al registrar el producto: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No se han recibido datos.";
}
?>
