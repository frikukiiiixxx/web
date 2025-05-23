<?php
include("session.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/mystyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Contexto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .icon-bar {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #333;
            overflow: hidden;
            z-index: 1000;
        }
        .icon-bar a {
            float: left;
            width: 20%;
            text-align: center;
            padding: 14px 0;
            color: white;
            text-decoration: none;
            font-size: 20px;
        }
        .icon-bar a:hover {
            background-color: #575757;
        }
        .active {
            background-color: #4CAF50;
        }
        .carrusel {
            display: flex;
            overflow: hidden;
            white-space: nowrap; /* Evita que las imágenes se ajusten a una nueva línea */
            width: 100%;
            position: relative;
            margin-top: 50px; /* Para que no se superponga con la barra de iconos */
        }
        .carrusel img {
            width: 100px; /* Ajusta el tamaño de las imágenes */
            margin-right: 10px; /* Espaciado entre imágenes */
        }
        .carrusel-wrapper {
            display: flex;
            animation: scroll 10s linear infinite;
        }
        @keyframes scroll {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-400px); /* Ajusta según el total de imágenes */
            }
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 50px); /* Ajusta la altura para evitar que se superponga con la barra de iconos */
            text-align: center;
        }
        .container h1 {
            font-size: 4em;
            color: #333;
        }
    </style>
</head>
<body>

<div class="icon-bar">
    <a class="active" href="home.php"><i class="fa fa-home"></i></a> 
    <a href="users.php"><i class="fa fa-user"></i></a> 
    <a href="registration.php"><i class="fa fa-registered"></i></a>
    <a href="print_all.php" target="_blank"><i class="fa fa-print"></i></a>
    <a href="logout.php"><i class="fa fa-power-off"></i></a> 
</div>

<div class="carrusel">
    <div class="carrusel-wrapper">
        <!-- Repite el mismo logo varias veces -->
        <img src="logo.png" alt="Logo">
        <img src="logo.png" alt="Logo">
        <img src="logo.png" alt="Logo">
        <img src="logo.png" alt="Logo">
        <img src="logo.png" alt="Logo">
        <img src="logo.png" alt="Logo">
    </div>
</div>

<div class="container">
    <h1>Contexto</h1>
</div>

</body>
</html>

