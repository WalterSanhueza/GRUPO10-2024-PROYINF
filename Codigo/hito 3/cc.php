<?php
// Inicializar las variables
$email = "";
$rut = "";
$nombres = "";
$contraseña = "";
$rol = "Usuario normal";

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
    $email = trim($_POST['correo']);
    $rut = trim($_POST['rut']);
    $nombres = trim($_POST['nombres']);
    $contraseña = trim($_POST['contraseña']); 

    // Validar que los campos no estén vacíos
    if (strlen($rut) >= 1 && strlen($email) >= 1 && strlen($nombres) >= 1 && strlen($contraseña) >= 1) {
        // Preparar la consulta de inserción
        $stmt = $conn->prepare("INSERT INTO usuarios (rut, email, nombres, contraseña, rol) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $rut, $email, $nombres, $contraseña, $rol);

        // Ejecutar la consulta y verificar si fue exitosa
        if ($stmt->execute()) {
            echo "<script>alert('Usuario creado exitosamente');</script>";
        } else {
            echo "<script>alert('Error al crear el usuario');</script>";
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
    <title>Creación de Usuario - MINAGRI</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 40%;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 16px;
            color: #555;
        }

        input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px;
            font-size: 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        button:hover {
            background-color: #2980b9;
        }

        .button-home {
            padding: 10px;
            font-size: 16px;
            background-color: #3498db;
            text-align: center;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            width: 97%; 
        }

        .button-home:hover {
            background-color: #2980b9;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Creación de Usuario</h2>
        <form action="" method="POST">
            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="nombres">Nombres:</label>
            <input type="text" id="nombres" name="nombres" required>

            <label for="rut">RUT:</label>
            <input type="text" id="rut" name="rut" required>

            <label for="contraseña">Contraseña:</label>
            <input type="password" id="contraseña" name="contraseña" required>

            <button type="submit">Crear Usuario</button>
            
        </form>

        <a href="Home.php" class="button-home">Volver al Inicio</a>
    </div>
</body>
</html>
