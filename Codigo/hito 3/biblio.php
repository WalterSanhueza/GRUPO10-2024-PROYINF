<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borradores - Vista de la Bibliotecóloga</title>
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
        .header {
            display: flex;
            justify-content: center; /* Centra el contenido horizontalmente */
            align-items: center; /* Centra el contenido verticalmente */
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            color: #000;
            font-size: 24px;
            text-align: center; /* Asegura que el texto esté centrado */
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
            border-radius: 4px;
            font-size: 16px;
        }
        .solicitar-btn:hover {
            background-color: #2980b9;
        }
        .search-bar {
            display: flex;
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
        .boletin {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .boletin h3 {
            margin-top: 0;
            color: #0066cc;
        }
        .boletin p {
            color: #555;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .action-buttons button, .action-buttons a {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            color: white;
            display: inline-block;
            text-align: center;
        }
        .accept-btn {
            background-color: #2ecc71;
        }
        .accept-btn:hover {
            background-color: #27ae60;
        }
        .deny-btn {
            background-color: #fd5d5d;
        }
        .deny-btn:hover {
            background-color: #c0392b;
        }
        .pdf-btn {
            background-color: #8c8686;
        }
        .pdf-btn:hover {
            background-color: #4d4949;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Borradores Disponibles</h2>
        </div>
        <?php
        // Configuración de la conexión
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

        // Manejar la eliminación del borrador
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
            $delete_id = $_POST['delete_id'];
            $delete_sql = "DELETE FROM BORRADORES WHERE idBorrador = ?";
            $stmt = $conn->prepare($delete_sql);
            $stmt->bind_param("i", $delete_id);
            $stmt->execute();
            $stmt->close();
        }

        // Manejar la aceptación del borrador
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accept_id'])) {
            $accept_id = $_POST['accept_id'];
            $accept_sql = "UPDATE BORRADORES SET estado = 'Aceptado' WHERE idBorrador = ?";
            $stmt = $conn->prepare($accept_sql);
            $stmt->bind_param("i", $accept_id);
            $stmt->execute();
            $stmt->close();
        
            // Aquí puedes decidir si deseas eliminar el borrador o no
            // Si decides eliminarlo, puedes hacerlo en un paso posterior
            $delete_sql = "DELETE FROM BORRADORES WHERE idBorrador = ?";
            $stmt = $conn->prepare($delete_sql);
            $stmt->bind_param("i", $accept_id);
            $stmt->execute();
            $stmt->close();
        }

        // Consulta para obtener los borradores
        $sql = "SELECT idBorrador, titulo, descripcion, pdf_url, estado FROM BORRADORES";
        $result = $conn->query($sql);

        // Verificar si la consulta fue exitosa
        if ($result === false) {
            echo "Error en la consulta SQL: " . $conn->error;
        } else {
            if ($result->num_rows > 0) {
                $counter = 1; // Inicializar el contador
                // Mostrar los datos de cada fila
                while($row = $result->fetch_assoc()) {
                    echo '<div class="boletin">';
                    echo '<div>';
                    echo '<h3>Borrador ' . $counter . ': ' . $row["titulo"] . '</h3>';
                    echo '<p>' . $row["descripcion"] . '</p>';
                    echo '</div>';
                    echo '<div class="action-buttons">';
                    echo '<form method="POST" action="'.$row["pdf_url"].'" style="display:inline;">'; // Apunta directamente a ver_pdf.php
                    echo '<input type="hidden" name="pdf_url" value="' . $row["pdf_url"] . '">'; // Enviar la URL del PDF
                    echo '<button type="submit" class="pdf-btn">Leer PDF</button>';
                    echo '</form>';
                    echo '<form method="POST" action="" style="display:inline;">';
                    echo '<input type="hidden" name="accept_id" value="' . $row["idBorrador"] . '">';
                    echo '<button type="submit" class="accept-btn">Aceptar</button>';
                    echo '</form>';
                    echo '<form method="POST" action="" style="display:inline;">';
                    echo '<input type="hidden" name="delete_id" value="' . $row["idBorrador"] . '">';
                    echo '<button type="submit" class="deny-btn">Denegar</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    $counter++; // Incrementar el contador
                }
            } else {
                echo "<p>No hay borradores disponibles.</p>";
            }
        }

        // Cerrar conexión
        $conn->close();
        ?>
    </div>
</body>
</html>
