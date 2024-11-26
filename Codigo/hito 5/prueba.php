<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

    .news-container {
        max-width: 800px;
        margin: 20px auto;
        padding: 10px;
        font-family: Arial, sans-serif;
    }

    / Título de la Sección /
    .news-container h2 {
        text-align: center;
        font-size: 2em;
        color: #333;
        margin-bottom: 20px;
    }

    / Cada noticia individual /
    .news-item {
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
        padding: 15px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .news-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    / Título de la Noticia /
    .news-item a {
        font-size: 1.2em;
        font-weight: bold;
        color: #0073e6;
        text-decoration: none;
    }

    .news-item a:hover {
        color: #005bb5;
        text-decoration: underline;
    }

    / Descripción de la Noticia */
    .news-item p {
        font-size: 1em;
        color: #555;
        margin-top: 8px;
        line-height: 1.6;
    }
    </style>
</head>
<body>
    
</body>
</html>

<?php
// Reemplaza con tu clave de API de TheNewsAPI
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
    echo '<h2>Noticias de Agricultura</h2>';
    foreach ($data['data'] as $news) {
        echo '<div class="news-item">';
        echo '<a href="' . htmlspecialchars($news['url']) . '" target="_blank">' . htmlspecialchars($news['title']) . '</a>';
        echo '<p>' . htmlspecialchars($news['description']) . '</p>';
        echo '</div>';
    }
} else {
    echo 'No se encontraron noticias relacionadas con la agricultura.';
}

echo '</div>';
?>