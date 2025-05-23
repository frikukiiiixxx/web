<?php
// Conexión a la base de datos
$mysqli = new mysqli('localhost', 'root', '', 'tienda');

// Verificar la conexión
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

if (isset($_POST['search'])) {
    $valueToSearch = $_POST['valueToSearh'];
    $query = "SELECT * FROM usuarios WHERE nombre LIKE ? OR paterno LIKE ?";
    $result = filterRecord($query, $valueToSearch);
} else {
    $query = "SELECT * FROM vender";
    $result = filterRecord($query);
}

// Función para ejecutar consultas
function filterRecord($query, $search_value = '') {
    global $mysqli;

    // Preparar la consulta
    $stmt = $mysqli->prepare($query);
    
    if ($stmt === false) {
        // Si la preparación de la consulta falla, muestra el error
        die('Error en la consulta SQL: ' . $mysqli->error);
    }

    if ($search_value) {
        // Bind parameters for LIKE searches
        $search_value = "%".$search_value."%";
        $stmt->bind_param("ss", $search_value, $search_value);
    }
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Obtener los resultados
    return $stmt->get_result();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
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

        .button {
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

        .button:hover {
            background-color: #777;
            transform: translateY(-2px);
        }

        .user-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .user-card {
            background-color: rgba(50, 50, 50, 0.8);
            padding: 20px;
            width: 250px;
            height: 300px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
            font-size: 16px;
        }

        .user-card img {
            max-width: 80px;
            border-radius: 5px;
        }

        .user-card .button {
            margin-top: 10px;
        }

        @media (max-width: 900px) {
            .user-card {
                width: 30%;
            }
        }

        @media (max-width: 600px) {
            .user-card {
                width: 45%;
            }
        }

        @media (max-width: 400px) {
            .user-card {
                width: 90%;
            }
        }

        .search-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .search-container input[type="search"] {
            padding: 8px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            width: 300px;
        }

        .search-container button {
            padding: 8px 16px;
            margin-left: 10px;
            background-color: #e63946;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

<header>
    <div>Lista de Usuarios</div>
    <a href="login.html" class="button" style="background-color: #e63946; color: white;">CERRAR SESIÓN</a>
</header>

<div class="dropdown">
    Menú
    <div class="dropdown-content">
        <a href="productos.php" class="button">INVENTARIO</a>
        <a href="users.php" class="button">USUARIOS ADMINS</a>
        <a href="users2.html" class="button">USUARIOS CLIENTES</a>
    </div>
</div>

<div class="container">

    <div class="search-container">
        <form action="users2.php" method="POST">
            <input type="search" name="valueToSearh" placeholder="Búsqueda">
            <button type="submit" class="button" name="search">Buscar</button>
        </form>
    </div>

    <div class="user-cards">
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<div class='user-card'>";
            echo "<h3>{$row['nombre']}</h3>";
            echo "<p><strong>Apellido Paterno:</strong> {$row['paterno']}</p>";
            echo "<p><strong>Apellido Materno:</strong> {$row['materno']}</p>";
            echo "<p><strong>Correo:</strong> {$row['correo']}</p>";

            // Botones de acción
            echo "<div class='button-container'>";
            echo "<a href='edit.php?id=".$row['usuario']."' class='button'>Actualizar</a>";
            echo "<a href='delete.php?id=".$row['usuario']."' class='button' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este usuario?\")'>Eliminar</a>";
            echo "<a href='print.php?id=".$row['usuario']."' class='button'>Imprimir</a>";
            echo "</div>";

            echo "</div>";
        }
        ?>
    </div>

</div>

</body>
</html>
