<?php

include 'conexion.php';

// Verifica si la conexión a la base de datos es exitosa
if (!$conn) {
    $response = "Error de conexión a la base de datos.";
    echo $response;
}

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializa variables
$success_message = $error_message = "";

// Procesa el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];
    $acepta_politicas = isset($_POST["acepta_politicas"]) ? 1 : 0;

    // Hash de la contraseña (mejora la seguridad)
    $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

    // Prepara y ejecuta la consulta SQL para insertar los datos en la base de datos
    // Prepara y ejecuta la consulta SQL para insertar los datos en la base de datos
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, correo, contrasena, tipo_usuario) VALUES (?, ?, ?, ?, 1)");
    $stmt->bind_param("ssss", $nombre, $apellido, $correo, $hashed_password);


    if ($stmt->execute() && $acepta_politicas) {
        // Éxito en la inserción
        $success_message = "¡Registro exitoso!";
    } else {
        // Error en la inserción
        $error_message = "Error al registrar el usuario: " . $stmt->error;
    }

    // Cierra la declaración y la conexión
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registro - Mi Empresa Meteorológica</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./img/logo.svg">
    <link rel="stylesheet" type="text/css" href="./css/coloring.css">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/txtformatting.css">
    <link rel="stylesheet" type="text/css" href="./css/shadow.css">
    <link rel="stylesheet" type="text/css" href="./css/loading.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="on">

    <div class="registro-container">
        <h1>Registro</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>

            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>

            <div class="checkbox-container">
                <input type="checkbox" id="acepta_politicas" name="acepta_politicas" required>
                <label for="acepta_politicas">Acepto las políticas de privacidad</label>
            </div>

            <button type="submit">Registrar</button>
        </form>
        
        <?php
        // Muestra mensajes de éxito o error después de procesar el formulario
        if (!empty($success_message)) {
            echo '<p class="success-message">' . $success_message . '</p>';
        } elseif (!empty($error_message)) {
            echo '<p class="error-message">' . $error_message . '</p>';
        }
        ?>

        <!-- Agrega un enlace o botón para dirigir a los usuarios a la página de inicio de sesión -->
        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </div>    <style>
        /* Agrega estos estilos en tu hoja de estilo personalizada (your-custom-register-styles.css) */

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .registro-container {
            background-color: var(--third-disabled);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .registro-container h1 {
            color: var(--secondary);
            text-align: center;
        }

        .registro-container form {
            display: flex;
            margin: 1px;
            flex-direction: column;
        }

        .registro-container label {
            font-size: 18px;
            font-weight: bold;
            color: var(--secondary);
            margin-bottom: 0px;
        }

        .registro-container input {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--secondary);
            border-radius: 4px;
            font-size: 16px;
            margin-top: 5px;
        }

        .registro-container .checkbox-container {
            display: flex;
            align-items: center;
            margin-top: 10px;
            flex-direction: column;
        }

        .registro-container input[type="checkbox"] {
            margin-right: 288px;
        }

        .registro-container label[for="acepta_politicas"] {
        margin-top: -17px;
    }
        
        .registro-container button {
            width: 100%;
            padding: 10px;
            background-color: var(--third);
            color: var(--secondary);
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 10px;
        }

        .registro-container button:hover {
            background-color: var(--third-disabled);
        }

        .registro-container .success-message {
            color: white;
            background-color: green;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            text-align: center;
        }

        .registro-container .error-message {
            color: white;
            background-color: red;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            text-align: center;
        }

        .registro-container p {
            color: var(--secondary);
            text-align: center;
            margin-top: 10px;
        }

        .registro-container a {
            color: var(--secondary);
            font-weight: bold;
            text-decoration: none;
        }

        .registro-container a:hover {
            color: var(--o1);
        }
    </style>
</body>
</html>
