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
session_start();
include_once "idiomas.php"; 
$usuario = $_SESSION['email'];
if (!isset($usuario)){
    header("location:inicioSesion.php");
}

$consulta = "SELECT * FROM usuarios WHERE email = '$usuario'";
$ejecuta = $conn->query($consulta);
$rowDatos = $ejecuta->fetch_assoc();

// Inicializar la variable de búsqueda
$search_keyword = "";
$idioma = $_COOKIE['idiomaSeleccionado'] ?? 'es'; // Idioma por defecto
if (isset($_POST['search'])) {
    $search_keyword = $_POST['search'];
}
// Crear la consulta SQL para buscar boletines
$sql = "SELECT * FROM boletines WHERE titulo LIKE '%$search_keyword%' OR descripcion LIKE '%$search_keyword%' OR parametros LIKE '%$search_keyword%'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista del Usuario - Boletines MINAGRI</title>
    <link rel="stylesheet" href="css/Home.css">
    <?php include_once "navbar.php";?>
    <div style="margin-top: 100px;"></div>
</head>

<body>
    <div class="page-wrapper">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('searchInput');
            const boletines = document.querySelectorAll('.boletin');

            input.addEventListener('keyup', function() {
                const query = input.value.toLowerCase();

                boletines.forEach(function(boletin) {
                    const contenido = boletin.getAttribute('data-search');
                    if (contenido.includes(query)) {
                        boletin.style.display = 'block';
                    } else {
                        boletin.style.display = 'none';
                    }
                });
            });
        });
    </script>
    <div class="container">
        <div class="header">
            <h2><?php echo traducir('Boletines Disponibles',$idioma)?> - MINAGRI</h2></br>
        </div>
        <div class = "search-bar">
            <input type="text" id="searchInput" placeholder="<?php echo traducir('Buscar por título o palabra clave...',$idioma)?>" style="width: 96.5%; margin-bottom: 20px;">
        </div>
        
        <div class ="boletin-container">
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="boletin" data-search="' . strtolower($row["titulo"] . ' ' . $row["descripcion"] . ' ' . $row["parametros"]) . '">';
                echo '<h3>' . htmlspecialchars($row["titulo"]) . '</h3>';
                echo '<p>' . htmlspecialchars($row["descripcion"]) . '</p>';

                // Botón Leer PDF
                echo '<form method="POST" action="' . $row["pdf_url"] . '" style="display:inline;">';
                echo '<input type="hidden" name="pdf_url" value="' . $row["pdf_url"] . '">';
                echo '<button type="submit" class="solicitar-btn">'.traducir('Leer PDF',$idioma).'</button>';
                echo '</form>';

                echo '</div>';
            }
            /*
            // Noticias externas
            #$api_key = 'E64nqZFKNa0G7fV5OcYeH5PWcKbFZAv5uzMjjk84';
            #$url = "https://api.thenewsapi.com/v1/news/all?api_token=$api_key&search=agriculture+Chile&language=es";
            #$response = file_get_contents($url);

            if ($response === FALSE) {
                die('Error al conectar con TheNewsAPI.');
            }

            $data = json_decode($response, true);

            echo '<div class="news-container">';
            if (isset($data['data'])) {
                echo '<h2>'.traducir('Otras noticias',$idioma).'</h2>';
                foreach ($data['data'] as $news) {
                    echo '<div class="boletin">';
                    echo '<div class="news-item">';
                    if (!empty($news['image_url'])) {
                        echo '<img src="' . htmlspecialchars($news['image_url']) . '" alt="Imagen de la noticia" class="news-image">';
                    }
                    echo '<div>';
                    echo '<h3><a href="' . htmlspecialchars($news['url']) . '" target="_blank">' . htmlspecialchars($news['title']) . '</a></h3>';
                    echo '<p>' . htmlspecialchars($news['description']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo 'No se encontraron noticias relacionadas con la agricultura.';
            }
            echo '</div>';
            */
            $conn->close();
            ?>
        </div>
    </div>
    </div>
</body>
</html>
<?php include 'footer.php'; ?>
