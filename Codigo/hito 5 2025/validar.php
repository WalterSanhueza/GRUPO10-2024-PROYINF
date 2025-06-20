<?php
session_start();
$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

// Configuración de la conexión
$config = include('config.php');

$conn = new mysqli(
    $config['DB_HOST'],
    $config['DB_USER'],
    $config['DB_PASS'],
    $config['DB_NAME']
);

// Validar que los campos no estén vacíos
if (strlen($correo) >= 1 && strlen($contraseña) >= 1) {

    $consulta = "SELECT * FROM usuarios WHERE email = '$correo' AND contraseña = '$contraseña'";
    $resultado = mysqli_query($conn, $consulta);

    if ($resultado) {
        $filas = mysqli_fetch_array($resultado);

        if ($filas) {
            $_SESSION['email'] = $correo;
            $_SESSION['rol'] = $filas['rol'];

            // Redirigir al home si la autenticación es válida
            echo "<script>('Sesión iniciada correctamente')</script>";
            echo "<script>window.location.href = 'homeFinal.php';</script>";
            exit();
        } else {
            // Cuenta no encontrada
            echo "<script>alert('Cuenta inexistente'); window.location.href='inicioSesion.php';</script>";
            exit();
        }

        mysqli_free_result($resultado);
    } else {
        echo "Error en la consulta: " . mysqli_error($conexion);
    }

} else {
    echo "<script>alert('Debe llenar todos los campos'); window.location.href='inicioSesion.php';</script>";
    exit();
}

mysqli_close($conexion);
?>
