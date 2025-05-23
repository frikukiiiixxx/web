<?php
    include("session.php");
    include("config.php");
    $id = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/mystyle1.css" />
</head>
<body>
<div class="icon-bar">
  <a href="home.php"><i class="fa fa-home"></i></a>
  <a href="users.php"><i class="fa fa-user"></i></a>
  <a class="active" href="registration.php"><i class="fa fa-registered"></i></a>
  <a href="logout.php"><i class="fa fa-power-off"></i></a>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"&gt;
<h2>Actualizar</h2>
<hr/>

<form action="update.php" method="POST">
  <div class="container">
  <?php
    $result = mysqli_query($mysqli,"SELECT * FROM usuarios WHERE usuario ='$id'");
    while($row = mysqli_fetch_array($result))
    {
    echo"<input type='hidden' name='id' value='{$row['usuario']}' required>";
    echo"<input type='text' placeholder='Nombre' name='nombre' value='{$row['nombre']}' required>";
    echo"<input type='text' placeholder='Apellido' name='paterno' value='{$row['paterno']}' required>";
    echo"<input type='text' placeholder='Segundo Apellido' name='materno' value='{$row['materno']}' required>";
      echo"<label><b>Correo Electrónico</b>";
    echo"<input type='text' name='correo' value='{$row['correo']}'required>";
    echo"</label>";
    echo"<input type='text' placeholder='Usuario' name='username' value='{$row['usuario']}' required>";
    echo"<input type='password' placeholder='Nueva Contraseña' name='password' value='{$row['password']}' required>";
    echo"<div class='clearfix'>";
    echo"<button type='submit' class='signupbtn'>Actualizar</button>";
    echo"</div>";
    }?>
  </div>
</form>