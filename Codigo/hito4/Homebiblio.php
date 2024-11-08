<?php
// recordar la variable de sesion
session_start();

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
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .container h2{
            text-align: center;
        }

        .search-bar {
            display: block;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .search-bar input {
            width: 80%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-bar button {
            padding: 10px 15px;
            border: none;
            background-color: #3498db;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #2980b9;
        }

        .header {
            display: flex;
            align-items: center;
            gap: 350px;

            margin-bottom: 20px;
        }

        .buttons-container {
            display: flex;
            gap: 10px;
        }

        .solicitar-btn {
        display: inline-block;
        padding: 10px 15px;
        background-color: #3498db;
        color: white;
        text-decoration: none;
        border: none;           /* Quitar el borde predeterminado */
        border-radius: 4px;
        font-size: 16px;
        outline: none;          /* Quitar el contorno al hacer clic */
        cursor: pointer;
        }

        .solicitar-btn:hover {
            background-color: #2980b9;
        }

        .boletin {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .boletin h3 , .boletin a{
            text-decoration: none;
            margin-top: 0;
            color: #0066cc;
        }

        .boletin p {
            color: #555;
        }
        .boletin-container {
            max-height: 60vh; /* Altura máxima para el contenedor de boletines */
            overflow-y: auto; /* Permitir el desplazamiento vertical en el contenedor de boletines */
        }
        .news-image {
        width: 150px;
        height: 75px;
        margin-right: 10px;
        border-radius: 5px;
        float: left;
        }

    </style>
    <?php include("navbar.php") ?>
</head>
<body>

    <div class="container">
        <div class="header">
            <div class="buttons-container">
                <a href="Biblio.php" class="solicitar-btn">Borradores</a>
            </div>
            <h2>Boletines Disponibles - MINAGRI</h2>
        </div>
        

        <div class="search-bar">
            <form method="POST" action="">
                <input type="text" name="search" placeholder="Buscar por título o palabra clave..." value="<?php echo htmlspecialchars($search_keyword); ?>">
                <button type="submit">Buscar</button>
            </form>
        </div>

        <div class="boletin-container">
            <?php
            $counter = 1;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="boletin">';
                    echo '<h3>Boletín ' . $counter . ': ' . $row["titulo"] . '</h3>';
                    echo '<p>' . $row['descripcion'] . '</p>';
                    echo '<p>' . $row['parametros'] . '</p>';
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
            $api_key = 'E64nqZFKNa0G7fV5OcYeH5PWcKbFZAv5uzMjjk84';

            // Ajusta la URL para filtrar noticias sobre agricultura y limitar el número de resultados
            $url = "https://api.thenewsapi.com/v1/news/all?api_token=$api_key&search=agriculture+Chile&language=es";

            // Realiza la solicitud a la API
            $response = file_get_contents($url);
            if ($response === FALSE) {
                die('Error al conectar con TheNewsAPI.');
            }

            $data = json_decode($response, true);

            // Contenedor principal de las noticias
            echo '<div class="news-container">';
            if (isset($data['data'])) {
                echo '<h2>Otras noticias</h2>';
                foreach ($data['data'] as $news) {
                    echo '<div class="boletin">';
                    echo '<div class="news-item">';
                    echo '<h3><a href="' . htmlspecialchars($news['url']) . '" target="_blank">' . htmlspecialchars($news['title']) . '</a></h3>';
                    if (!empty($news['image_url'])) {
                        echo '<img src="' . htmlspecialchars($news['image_url']) . '" alt="Imagen de la noticia" class="news-image">';
                    }
                    echo '<p>' . htmlspecialchars($news['description']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo 'No se encontraron noticias relacionadas con la agricultura.';
            }

            echo '</div>';
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>

