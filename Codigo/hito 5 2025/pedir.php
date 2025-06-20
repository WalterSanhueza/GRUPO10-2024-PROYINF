<?php
// Inicializar las variables
session_start();
include_once "idiomas.php";
$parametros = "";
$descripcion = "";
$estado = "por revisar";
$rut = "";

// Conexión a la base de datos
$host = "localhost";
$username = "root";
$password = "grupo4";
$dbname = "vigifia";
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

//validar que se cree una variable de sesion al pasar por el login

$usuario = $_SESSION['email'];
if (!isset($usuario)){
    header("location:inicioSesion.php");
}

$consulta = "SELECT * FROM usuarios WHERE email = '$usuario'";
$ejecuta = $conn->query($consulta);
$rowDatos = $ejecuta->fetch_assoc();

if ($rowDatos['rol'] == "Usuario normal") {
    header("location:homeNormal.php");
    exit();
}
elseif ($rowDatos['rol'] == "Bibliotecóloga") {
    header("location:homebiblio.php");
    exit();
}
elseif ($rowDatos['rol'] == "Equipo TI") {
    header("location:HomeTI.php");
    exit();
}

// Procesar los datos cuando el formulario se envíe
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $parametros = trim($_POST['parametros']);
    $descripcion = trim($_POST['descripcion']);
    $rut = trim($_POST['rut']);

    // Validar que los campos no estén vacíos
    if (!empty($parametros) && !empty($descripcion) && !empty($rut)) {
        // Preparar la consulta de inserción
        $stmt = $conn->prepare("INSERT INTO solicitudes (parametros, descripcion, rutCliente, estado) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $parametros, $descripcion, $rut, $estado);

        // Ejecutar la consulta y verificar si fue exitosa
        if ($stmt->execute()) {
            echo "<script>alert('Solicitud creada exitosamente');</script>";
        } else {
            echo "<script>alert('Error al crear la solicitud: " . $conn->error . "');</script>";
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
    <title>Formulario Mejorado</title>
    <link rel="stylesheet" href="css/pedir.css">
    <?php include_once "navbar.php"; ?>
    <div style="margin-top: 100px;"></div>
</head>
<body>

    <div class="container">
        <h2><?php echo traducir('Formulario de Boletín',$idioma)?></h2>
        <form action="" method="POST">
            <label for="parametros" class="label"><?php echo traducir('Ingrese palabras clave',$idioma)?></label>
            <input type="text" id="parametros" name="parametros" class="input" placeholder="<?php echo traducir('Cosechas, Sistemas, Ciencia, etc..',$idioma)?>">

            <label for="descripcion" class="label"><?php echo traducir('Ingrese una descripción de lo que su empresa busca, objetivos y criterios',$idioma)?></label>
            <textarea id="descripcion" name="descripcion" class="textarea" placeholder="<?php echo traducir('Describa aquí lo que su empresa busca...',$idioma)?>"></textarea>
            
            <label for="rut" class="label"><?php echo traducir('Ingrese el rut de su empresa',$idioma)?></label>
            <input type="text" id="rut" name="rut" class="input" placeholder="77.777.777-7">
            <button type="submit" class="btn"><?php echo traducir('Enviar',$idioma)?></button>
        </form>
        <input class="boton" type="button" value="<?php echo traducir('volver_inicio', $idioma); ?>" onclick="location.href='HomeFinal.php';">

    </div>

</body>
</html>

