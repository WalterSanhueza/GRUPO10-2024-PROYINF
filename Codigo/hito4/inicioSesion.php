<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .boton {
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

        .boton:hover {
            background-color: #2980b9;
        }

    </style>
</head>
<body>
    <div class ="container">
        <form action = "validar.php" method="post">
        <h2> Inicia sesión </h2>
        <label for="correo">Correo electrónico:</label>
        <input type="text" name="correo" required>
        <label for="nombres">Contraseña:</label>
        <input type = "password" name="contraseña" required>
        <input class="boton" type="submit" value="Entrar"></button>
        </form>
    </div>
    
</body>
</html>