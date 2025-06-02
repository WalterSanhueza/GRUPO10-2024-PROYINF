<?php

session_start(); // Iniciar sesión para poder almacenar variables de sesión
include_once "idiomas.php";
$idioma = $_COOKIE['idiomaSeleccionado'] ?? 'es';

// Inicializar las variables
$email = "";
$rut = "";
$nombres = "";
$contraseña = "";
$rol = "Usuario normal";

// Conexión a la base de datos
$host = "localhost";
$username = "root";
$password = "";
$dbname = "vigifia";
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

function no_numeros_en_nombre($nombre_usuario) {
    $numeros = ['0','1','2','3','4','5','6','7','8','9'];
    for ($i = 0; $i < strlen($nombre_usuario); $i++) { 
        $aux = $nombre_usuario[$i];
        if (in_array($aux, $numeros)) {
            return false;
        }
    }
    return true; 
}

function rut_valido($rut) {
    $patron = '/^\d{1,2}.\d{3}.\d{3}-[0-9kK]$/';
    return preg_match($patron, $rut) === 1;
}

function email_valido($email) {
    $patron = '/^[^@]+@[^@]*.[^@]+$/';
    return preg_match($patron, $email) === 1;
}


// Procesar los datos cuando el formulario se envíe
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $email = trim($_POST['correo']);
    $rut = trim($_POST['rut']);
    $nombres = trim($_POST['nombres']);
    $contraseña = trim($_POST['contraseña']); 
    $envio  = isset($_POST['envios']) ? 1 : 0;

    // Validar que los campos no estén vacíos
    
    if (strlen($rut) >= 1 && strlen($email) >= 1 && strlen($nombres) >= 1 && strlen($contraseña) >= 1) {
        if (no_numeros_en_nombre($nombres) == false) {
            echo "<script>alert('El nombre de usuario no puede contener números');</script>";
            echo "<script>window.location.href = 'cc.php';</script>";
            exit();
        }
        if (!rut_valido($rut)) {
            echo "<script>alert('El RUT ingresado no es válido.');</script>";
            echo "<script>window.location.href = 'cc.php';</script>";
            exit();
        }
        if (!email_valido($email)) {
            echo "<script>alert('El correo electrónico ingresado no es válido.');</script>";
            echo "<script>window.location.href = 'cc.php';</script>";
            exit();
        }
        // Preparar la consulta de inserción
        $stmt = $conn->prepare("INSERT INTO usuarios (rut, email, nombres, contraseña, rol, envios) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $rut, $email, $nombres, $contraseña, $rol, $envio);

        try {
            if ($stmt->execute()) {
                echo "<script>alert('Usuario creado exitosamente.');</script>";
                $_SESSION['email'] = $email;
                $_SESSION['rol'] = $rol;
                echo "<script>window.location.href = 'homeFinal.php';</script>";
                exit();
            } else {
                echo "<script>alert('Error al crear el usuario');</script>";
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                // Error por clave duplicada (duplicate entry)
                echo "<script>alert('Error: el usuario ya existe');</script>";
            } else {
                // Otro error de base de datos
                echo "<script>alert('Error inesperado: " . $e->getMessage() . "');</script>";
            }
        }

        $stmt->close();
    } else {
        echo "<script>alert('Debe llenar todos los campos');</script>";
    }
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creación de Usuario - MINAGRI</title>
    <link rel="stylesheet" href="css/cc.css">
    <?php include_once "navbar.php";?>
    <div style="margin-top: 100px;"></div>
</head>
<body>
    <div class="container">
        <h2><?php echo traducir('creacion_usuario', $idioma); ?></h2>
        <form action="" method="POST">
            <label for="correo"><?php echo traducir('correo_electronico', $idioma); ?></label>
                <input type="email" id="correo" name="correo" required>

            <label for="nombres"><?php echo traducir('nombre_usuario', $idioma); ?></label>
                <input type="text" id="nombres" name="nombres" required>

            <label for="rut"><?php echo traducir('rut', $idioma); ?></label>
                <input type="text" id="rut" name="rut" placeholder = <?php echo traducir("Con puntos y guión", $idioma)?> required>

            <label for="contraseña"><?php echo traducir('contrasena', $idioma); ?></label>
                <input type="password" id="contraseña" name="contraseña" required>
            <label>
                <input type="checkbox" name="envio"> <?php echo traducir('Me gustaría recibir notificaciones de nuevos boletines.', $idioma); ?>
            </label>

            <input class="boton" type="submit" value="<?php echo traducir('entrar', $idioma); ?>">
        </form>

        <input class="boton" type="button" value="<?php echo traducir('volver_inicio', $idioma); ?>" onclick="location.href='index.php';">
    </div>
</body>
</html>
