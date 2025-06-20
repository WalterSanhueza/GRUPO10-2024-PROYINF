<?php
// recordar la variable de sesion
session_start();
include_once "idiomas.php";
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
elseif ($rowDatos['rol'] == "Cliente") {
    header("location:homeCliente.php");
    exit();
}
if ($rowDatos['rol'] == "Bibliotecóloga") {
    header("location:homebiblio.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borradores - Vista de la Bibliotecóloga</title>
    <link rel="stylesheet" href="css/versoli.css">
    <?php include_once "navbar.php";?>
    <div style="margin-top: 100px;"></div>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2><?php echo traducir('Solicitudes pendientes',$idioma)?></h2>
        </div>
        <div class="boletin-container">
            <?php
            $conn = new mysqli(
            $config['DB_HOST'],
            $config['DB_USER'],
            $config['DB_PASS'],
            $config['DB_NAME']
            );


            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
                $delete_id = $_POST['delete_id'];
                $delete_sql = "DELETE FROM solicitudes WHERE idSoli = ?";
                $stmt = $conn->prepare($delete_sql);
                $stmt->bind_param("i", $delete_id);
                $stmt->execute();
                $stmt->close();
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accept_id'])) {
                $accept_id = $_POST['accept_id'];
                $accept_sql = "UPDATE solicitudes SET estado = 'Generando boletin' WHERE idSoli = ?";
                $stmt = $conn->prepare($accept_sql);
                $stmt->bind_param("i", $accept_id);
                $stmt->execute();
                $stmt->close();
            }

            $sql = "SELECT idSoli, rutCliente, parametros, descripcion, estado FROM solicitudes";
            $result = $conn->query($sql);

            if ($result === false) {
                echo "Error en la consulta SQL: " . $conn->error;
            } else {
                if ($result->num_rows > 0) {
                    $counter = 1;
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="boletin">';
                        echo '<div>';
                        echo '<h3>Solicitud id: ' . htmlspecialchars($row["idSoli"]) . ' del cliente '. htmlspecialchars($row["rutCliente"]) . '</h3>';
                        echo '<p>' . nl2br(htmlspecialchars($row["parametros"])) . '</p>';
                        echo '<p>' . nl2br(htmlspecialchars($row["descripcion"])) . '</p>';
                        echo '<p>' . nl2br(htmlspecialchars($row["estado"])) . '</p>';
                        echo '</div>';
                        echo '<div class="action-buttons">';
                        echo '<form method="POST" action="" style="display:inline;">';
                        echo '<input type="hidden" name="accept_id" value="' . htmlspecialchars($row["idSoli"]) . '">';
                        echo '<button type="submit" class="accept-btn">'.traducir('Aceptar',$idioma).'</button>';
                        echo '</form>';
                        echo '<form method="POST" action="" style="display:inline;">';
                        echo '<input type="hidden" name="delete_id" value="' . htmlspecialchars($row["idSoli"]) . '">';
                        echo '<button type="submit" class="deny-btn">'.traducir('Denegar',$idioma).'</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                        $counter++;
                    }
                } else {
                    echo "<p>No hay borradores disponibles.</p>";
                }
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
