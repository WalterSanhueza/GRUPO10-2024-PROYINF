<?php
session_start(); // Iniciar sesión para poder almacenar variables de sesión
include_once "idiomas.php"; // Asegúrate de usar include_once
include_once "navbar.php"; // Asegúrate de usar include_once

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <?php include("navbar.php") ?>
    <div style="margin-top: 100px;"></div>
</head>
<body>
    
    <div class="container">
        <form action="validar.php" method="post">
            <h2><?php echo traducir('iniciar_sesion', $idioma); ?></h2>

            <label for="correo"><?php echo traducir('correo_electronico', $idioma); ?></label>
            <input type="text" name="correo" required>

            <label for="nombres"><?php echo traducir('contrasena', $idioma); ?></label>
            <input type="password" name="contraseña" required>

            <input class="boton" type="submit" value="<?php echo traducir('entrar', $idioma); ?>">
            <input class="boton" type="button" value="<?php echo traducir('volver_inicio', $idioma); ?>" onclick="location.href='index.php';">


        </form>
    </div>
    
    
</body>
</html>