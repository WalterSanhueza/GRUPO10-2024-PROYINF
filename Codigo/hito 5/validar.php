<style>
    .bad {
    color: red; /* Color del texto */
    background-color: #f8d7da; /* Color de fondo */
    border: 1px solid #f5c6cb; /* Borde */
    padding: 10px; /* Espaciado interno */
    border-radius: 5px; /* Bordes redondeados */
    text-align: center; /* Centrar el texto */
    font-family: Arial, sans-serif; /* Fuente */
    font-size: 18px; /* Tamaño de la fuente */
    }   
</style>
<?php
$correo = $_POST['correo'];

$contraseña = $_POST['contraseña'];
session_start();
$_SESSION['email'] = $correo;

$conexion = mysqli_connect("localhost","root","","vigifia");

$consulta = "SELECT * FROM usuarios where email='$correo' and contraseña = '$contraseña'";
$resultado = mysqli_query($conexion,$consulta);

if ($resultado) {
    $filas = mysqli_fetch_array($resultado);

    if ($filas) {
        if ($filas['rol'] == "Cliente") {
            header("Location: HomeCliente.php");
        } elseif ($filas['rol'] == "Bibliotecóloga") {
            header("Location: Homebiblio.php");
        } elseif ($filas['rol'] == "Usuario normal") {
            header("Location: HomeNormal.php");
        } elseif ($filas['rol'] == "Equipo TI") {
            header("Location: HomeTI.php");
        } else {
            include("inicioSesion.php");
            echo '<h1 class="bad">ERROR EN LA AUTENTIFICACIÓN</h1>';
        }
    } else {
        include("inicioSesion.php");
        echo '<h1 class="bad">ERROR EN LA AUTENTIFICACIÓN</h1>';
    }

    mysqli_free_result($resultado);
} else {
    echo "Error en la consulta: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>