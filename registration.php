<?php
    include("session.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Anton&display=swap">
    <style>
        /* Global Styles */
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #1e1e1e, #333) fixed, url('imagen/mamiwepe.png') no-repeat center center;
            background-size: cover;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Header Styles */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: rgba(0, 0, 0, 0.9);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            font-size: 28px;
            font-family: 'Anton', sans-serif;
            text-transform: uppercase;
            letter-spacing: 2px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        header img {
            width: 50px;
            margin-right: 15px;
        }

        /* Container Styles */
        .container {
            background: rgba(0, 0, 0, 0.8);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.7);
            max-width: 500px;
            text-align: center;
            animation: fadeIn 1.5s ease-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            font-size: 30px;
            font-family: 'Anton', sans-serif;
            margin-bottom: 15px;
            letter-spacing: 2px;
        }

        hr {
            border: none;
            height: 2px;
            background: #ffffff;
            margin: 20px auto;
            width: 50%;
        }

        form input[type="text"],
        form input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #444;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: white;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        form input[type="text"]:focus,
        form input[type="password"]:focus {
            outline: none;
            border-color: #ffffff;
        }

        .clearfix {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 20px;
        }

        .clearfix button {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .signupbtn {
            background: white;
            color: #1e1e1e;
            border: none;
        }

        .signupbtn:hover {
            background: #f5f5f5;
            transform: translateY(-3px);
        }

        .cancelbtn {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .cancelbtn:hover {
            background: white;
            color: #1e1e1e;
            transform: translateY(-3px);
        }

        /* Dropdown Styles */
        .dropdown {
            position: fixed;
            top: 15px;
            left: 15px;
            background: rgba(0, 0, 0, 0.7);
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 18px;
            color: white;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            transition: background-color 0.3s ease;
        }

        .dropdown:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 5px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            width: 150px;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            transition: background 0.3s ease;
        }

        .dropdown-content a:hover {
            background: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>

<header>
    <img src="imagen/logo.png" alt="Logo">
    Registrarse
</header>

<div class="container">
    <h2>¡Bienvenido!</h2>
    <hr/>
    <form action="register.php" method="POST">
        <input type="text" placeholder="Nombre" name="nombre" required maxlength="15">
        <input type="text" placeholder="Primer Apellido" name="paterno" required maxlength="15">
        <input type="text" placeholder="Segundo Apellido" name="materno" required maxlength="15">
        <input type="text" placeholder="Correo Electrónico" name="correo" required maxlength="40">
        <input type="text" placeholder="Usuario" name="username" required>
        <input type="password" placeholder="Nueva Contraseña" name="password" required>
        <input type="password" placeholder="Repetir Contraseña" name="psw-repeat" required>
        <div class="clearfix">
            <button type="submit" class="signupbtn">Registrarse</button>
            <button type="button" class="cancelbtn" onclick="window.location.href='login2.html';">Cancelar</button>
        </div>
    </form>
</div>

</body>
</html>
