<?php
// Inicializar las variables
$parametros = "";
$descripcion = "";
$estado = "por revisar";
$rut = "";

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
    <style>

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            text-align: center;
            color: #333;
        }

        .label {
            font-weight: bold;
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
        }

        .input, .textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .input:focus, .textarea:focus {
            border-color: #0066cc;
            outline: none;
            box-shadow: 0 0 8px rgba(0, 102, 204, 0.2);
        }
    

        .btn {
            width: 100%;
            background-color: #0066cc;
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .btn:hover {
            background-color: #004c99;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #999;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Formulario de Boletín</h2>
        <form action="" method="POST">
            <label for="parametros" class="label">Ingrese palabras clave</label>
            <input type="text" id="parametros" name="parametros" class="input" placeholder="Cosechas, Sistemas, Ciencia, etc..">

            <label for="descripcion" class="label">Ingrese una descripción de lo que su empresa busca, objetivos y criterios</label>
            <textarea id="descripcion" name="descripcion" class="textarea" placeholder="Describa aquí lo que su empresa busca..."></textarea>
            
            <label for="rut" class="label">Ingrese el rut de su empresa</label>
            <input type="text" id="rut" name="rut" class="input" placeholder="77.777.777-7">
            <button type="submit" class="btn">Enviar</button>
        </form>
        <a href="Home.php" class="btn">Volver al Inicio</a>
        <div class="footer">
            <p>&copy; 2024 FIA - Todos los derechos reservados</p>
        </div>
    </div>

</body>
</html>

