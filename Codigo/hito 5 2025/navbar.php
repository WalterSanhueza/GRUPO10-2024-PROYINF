<?php


if (isset($_COOKIE['idiomaSeleccionado'])) {
    $idioma = $_COOKIE['idiomaSeleccionado'];
}

// recordar la variable de sesion

// Configuración de la conexión
$config = include_once 'config.php';

$conn = new mysqli(
    $config['DB_HOST'],
    $config['DB_USER'],
    $config['DB_PASS'],
    $config['DB_NAME']
);


// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//validar que se cree una variable de sesion al pasar por el login

$usuario = $_SESSION['email'] ?? null;

if ($usuario) {
    $consulta = "SELECT * FROM usuarios WHERE email = '$usuario'";
    $ejecuta = $conn->query($consulta);
    $rowDatos = $ejecuta->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="css/navbar.css" />
</head>
<body>
<script>
function cambiarIdioma(idioma) {
    document.cookie = "idiomaSeleccionado=" + idioma + "; path=/";
    window.location.href = window.location.pathname;
    }
</script>

<div class="navbar">
    <!-- Logo a la izquierda -->
    <div class="navbar-logo">
        <?php if ($usuario): ?>
            <a href="HomeFinal.php"><img src="img/home.png" width="30" alt="Inicio"></a>
            <span class="session-info">
                <?php 
                echo traducir("Sesión iniciada como",$idioma)." : ". htmlspecialchars($rowDatos["nombres"]) . " (" . 
                    (($rowDatos['rol'] == "Bibliotecóloga") ? "Bibliotecóloga/o" : htmlspecialchars($rowDatos['rol'])) . ")";
                ?>
            </span>
            
            <?php
            if ($rowDatos['rol'] == "Bibliotecóloga") {
                echo '<a class="btn-nav" href="Biblio.php">'. traducir('Ver Borradores',$idioma).'</a>';
            } elseif ($rowDatos['rol'] == "Cliente") {
                echo '<a class="btn-nav" href="pedir.php">'. traducir('Solicitar Boletín',$idioma).'</a>';
            } elseif ($rowDatos['rol'] == "Equipo TI") {
                echo '<a class="btn-nav" href="ver_soli.php">'. traducir('Ver Solicitudes',$idioma).'</a>';
            }
            ?>
        <?php else: ?>
            <a href="index.php"><img src="img/home.png" width="30" alt="Inicio"></a>
        <?php endif; ?>
    </div>
    
    <!-- Sección de la derecha -->
    <div class ="navbar-right">
        <?php if (isset($usuario)): ?>
            <a href="#" onclick="cambiarIdioma('en')"><img src="img/en.png" width="30"></a>
            <a href="#" onclick="cambiarIdioma('fr')"><img src="img/fr.png" width="30"></a>
            <a href="#" onclick="cambiarIdioma('es')"><img src="img/es.png" width="30"></a>
            <a href="cerrar.php" class="logout-icon"><img src="img/logout.png" width="20" alt="Cerrar sesión"></a>
            
        <?php else: ?>
            <div class="auth-links">
                <a href="cc.php"><?php echo traducir('crear_usuario', $idioma); ?></a>
                <a href="inicioSesion.php"><?php echo traducir('iniciar_sesion', $idioma); ?></a>
                <a href="#" onclick="cambiarIdioma('en')"><img src="img/en.png" width="30"></a>
                <a href="#" onclick="cambiarIdioma('fr')"><img src="img/fr.png" width="30"></a>
                <a href="#" onclick="cambiarIdioma('es')"><img src="img/es.png" width="30"></a>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
