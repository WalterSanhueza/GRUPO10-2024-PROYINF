<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "vigifia";
$conn = new mysqli($host, $username, $password, $dbname);
include_once "idiomas.php";
function traducir_boletin($texto, $idioma_destino) {
    // Preparamos los datos según la documentación
    $data = array(
        'q'      => $texto,
        'source' => 'es',
        'target' => $idioma_destino,
        'format' => 'html'  // Cambiado a html según el ejemplo
    );

    // Usamos la URL del endpoint de LibreTranslate
    $ch = curl_init('https://libretranslate.com/translate');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    curl_close($ch);

    // Opcional: Depuración, imprime la respuesta completa de la API
    var_dump($response);

    $result = json_decode($response, true);

    // Se retorna el campo 'translatedText' si existe, de lo contrario el texto original
    return $result['translatedText'] ?? $texto;
}

function desplegar_boletines_traducidos($conn, $search_keyword, $idioma){
    $sql = "SELECT * FROM boletines WHERE titulo LIKE '%$search_keyword%' OR descripcion LIKE '%$search_keyword%' OR parametros LIKE '%$search_keyword%'";
    $result = $conn->query($sql);
    $counter = 1;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tituloTraducido = traducir($row["titulo"], $idioma);
            $descripcionTraducida = traducir($row["descripcion"], $idioma);
            $parametrosTraducidos = traducir($row["parametros"], $idioma);
            echo '<div class="boletin">';
            echo '<h3>Boletín ' . $counter . ': ' . $tituloTraducido . '</h3>';
            echo '<p>' . $descripcionTraducida . '</p>';
            echo '<p>' . $parametrosTraducidos . '</p>';
            echo '<p>' . $row['fechaPublicacion'] . '</p>';
            echo '<form method="POST" action="'.$row["pdf_url"].'" style="display:inline;">'; // Apunta directamente a ver_pdf.php
            echo '<input type="hidden" name="pdf_url" value="' . $row["pdf_url"] . '">'; // Enviar la URL del PDF
            echo '<button type="submit" class="solicitar-btn">Leer PDF</button>';
            echo '</form>';
            echo '</div>' ;
            $counter++;
        }
    } else {
        echo "<p>No se encontraron resultados para '$search_keyword'.</p>";
    }
}

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['email'])){
    
}
else{
    $usuario = $_SESSION['email'];
    $consulta = "SELECT * FROM usuarios WHERE email = '$usuario'";
    $ejecuta = $conn->query($consulta);
    $rowDatos = $ejecuta->fetch_assoc();

    if ($rowDatos['rol'] == "Bibliotecóloga") {
        header("location:homebiblio.php");
        exit();
    }
    elseif ($rowDatos['rol'] == "Usuario normal") {
        header("location:homeNormal.php");
        exit();
    }
    elseif($rowDatos['rol'] == "Cliente"){
        header("location:homeCliente.php");
        exit();
    }
}

// Inicializar la variable de búsqueda
$search_keyword = "";

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
</head>
<body>
<div class="page-wrapper">
    <link rel="stylesheet" href="css/home.css">
    <?php include_once "navbar.php";  ?>
    <div style="margin-top: 100px;"></div>
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
            <h2><?php echo traducir('Boletines Disponibles',$idioma)?> - VigiFIA</h2></br>
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
            #url = "https://api.thenewsapi.com/v1/news/all?api_token=$api_key&search=agriculture+Chile&language=es";
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
</footer>
</body>
</html>
<?php include 'footer.php'; ?>