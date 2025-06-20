<?php
// recordar la variable de sesion

session_start();

include "mc.php";
include_once "idiomas.php";
$host = "localhost";
$username = "root";
$password = "grupo4";
$dbname = "vigifia";
$conn = new mysqli($host, $username, $password, $dbname);

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
elseif ($rowDatos['rol'] == "Equipo TI") {
    header("location:HomeTI.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borradores - Vista de la Bibliotecóloga</title>
    <link rel="stylesheet" href="css/biblio.css">
    <?php include_once "navbar.php"; ?>
    <div style="margin-top: 100px;"></div>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2><?php echo traducir('Borradores Disponibles',$idioma)?></h2>
        </div>
        <div class="boletin-container">
            <?php
            $host = "localhost";
            $username = "root";
            $password = "grupo4";
            $dbname = "vigifia";
            $conn = new mysqli($host, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
                $delete_id = $_POST['delete_id'];
                $delete_sql = "DELETE FROM BORRADORES WHERE idBorrador = ?";
                $stmt = $conn->prepare($delete_sql);
                $stmt->bind_param("i", $delete_id);
                $stmt->execute();
                $stmt->close();
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accept_id'])) {
                $accept_id = $_POST['accept_id']; // Mover esto al inicio
                $rutaPDF = '';
                $stmt = $conn->prepare("SELECT pdf_url FROM BORRADORES WHERE idBorrador = ?");
                $stmt->bind_param("i", $accept_id);
                $stmt->execute();
                $stmt->bind_result($rutaPDF);
                $stmt->fetch();
                $stmt->close();
                
                enviarBoletinPorCorreo($rutaPDF, 'Boletin.pdf');

                $accept_id = $_POST['accept_id'];
                $accept_sql = "UPDATE BORRADORES SET estado = 'Aceptado' WHERE idBorrador = ?";
                $stmt = $conn->prepare($accept_sql);
                $stmt->bind_param("i", $accept_id);
                $stmt->execute();
                $stmt->close();

                $delete_sql = "DELETE FROM BORRADORES WHERE idBorrador = ?";
                $stmt = $conn->prepare($delete_sql);
                $stmt->bind_param("i", $accept_id);
                $stmt->execute();
                $stmt->close();

            }

            $sql = "SELECT idBorrador, titulo, descripcion, pdf_url, estado FROM BORRADORES";
            $result = $conn->query($sql);

            if ($result === false) {
                echo "Error en la consulta SQL: " . $conn->error;
            } else {
                if ($result->num_rows > 0) {
                    $counter = 1;
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="boletin">';
                        echo '<div>';
                        echo '<h3>Borrador ' . $counter . ': ' . htmlspecialchars($row["titulo"]) . '</h3>';
                        echo '<p>' . nl2br(htmlspecialchars($row["descripcion"])) . '</p>';
                        echo '</div>';
                        echo '<div class="action-buttons">';
                        echo '<form method="POST" action="'.$row["pdf_url"].'" style="display:inline;">';
                        echo '<input type="hidden" name="pdf_url" value="' . htmlspecialchars($row["pdf_url"]) . '">';
                        echo '<button type="submit" class="solicitar-btn">'.traducir('Leer PDF',$idioma).'</button>';  // Cambiado a .solicitar-btn
                        echo '</form>';
                        echo '<form method="POST" action="" style="display:inline;">';
                        echo '<input type="hidden" name="accept_id" value="' . htmlspecialchars($row["idBorrador"]) . '">';
                        echo '<button type="submit" class="accept-btn">'.traducir('Aceptar',$idioma).'</button>';
                        echo '</form>';
                        echo '<form method="POST" action="" style="display:inline;">';
                        echo '<input type="hidden" name="delete_id" value="' . htmlspecialchars($row["idBorrador"]) . '">';
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
