<?php
// recordar la variable de sesion

$host = "localhost";
$username = "root";
$password = "";
$dbname = "vigifia";
$conn = new mysqli($host, $username, $password, $dbname);

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
    <style>
        /* Estilos básicos para el navbar */
        .navbar {
            width: 100%;
            background: linear-gradient(90deg, #67d682, #8cf1d0); /* Gradiente de color */
            padding: 15px; /* Aumentar el padding para mayor altura */
            display: flex;
            justify-content: flex-end; /* Alinear el contenido a la derecha */
            position: fixed; /* Fijo en la parte superior */
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra */
            transition: background 0.3s ease; /* Transición suave */
        }
        .navbar a, .navbar span {
            color: black;
            text-decoration: none;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 4px; /* Bordes redondeados */
            transition: background 0.3s ease, transform 0.3s ease; /* Transición suave */
        }
        .navbar a:hover {
            transform: scale(1.1); /* Efecto de agrandamiento */
        }
        /* Añadir un poco de margen superior al contenido para evitar que quede oculto detrás del navbar */
        body {
            margin-top: 70px; /* Ajusta según la altura del navbar */
            font-family: Arial, sans-serif; /* Fuente más moderna */
        }
        .dropdown {
            position: relative;
            display: inline-block;
            margin-right: 20px; /* Ajustar el margen derecho para mover a la izquierda */
        }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0; /* Alinear el contenido desplegable a la derecha */
            background-color: white;
            min-width: 250px; /* Ancho mínimo para el dropdown */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }
        .dropdown-content span {
            color: black;
            padding: 12px 16px;
            display: block;
            transition: background 0.3s ease;
            white-space: normal; /* Permitir que el texto se ajuste en varias líneas */
        }
        .dropdown-content span:hover {
            background-color: #d9dbee;
        }
        .dropdown-content a {
            color: white;
            background-color: red; /* Color de fondo rojo */
            padding: 12px 16px;
            display: block;
            border-radius: 4px; /* Bordes redondeados */
            transition: background 0.3s ease, transform 0.3s ease; /* Transición suave */
        }
        .dropdown-content a:hover {
            background-color: darkred; /* Color de fondo al pasar el ratón */
            transform: scale(1.1); /* Efecto de agrandamiento */
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        .navbar .auth-links {
            margin-right: 20px; /* Mover los enlaces un poco a la izquierda */
        }
    </style>
</head>
<body>

<div class="navbar">
    <?php if (isset($usuario)): ?>
    <div class="dropdown">
        <a href="#"><?php echo $rowDatos['nombres']?></a>
        <div class="dropdown-content">
            <span><?php echo $rowDatos['email']?></span>
            <span><?php echo $rowDatos['rol']?></span>
            <a href="cerrar.php">Cerrar sesión</a>
        </div>
    </div>
    <?php else: ?>
    <div class="auth-links">
        <a href="cc.php">Crear usuario</a>
        <a href="inicioSesion.php">Iniciar sesión</a>
    </div>
    <?php endif; ?>
</div>

</body>
</html>
