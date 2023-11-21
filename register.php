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
    <link rel="stylesheet" type="text/css" href="./css/register.css">
    <link rel="stylesheet" type="text/css" href="./css/txtformatting.css">
    <link rel="stylesheet" type="text/css" href="./css/shadow.css">
    <link rel="stylesheet" type="text/css" href="./css/loading.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="on">
    <main class="main">
        <div class="navbar">
            <div class="container">
                <div class="navbar-nav">
                    <div class="navbar-brand">
                        <span><img src="./img/logo.svg" alt="TempoTech Logo" class="logo-icon" width="70px"></span>
                        <span class="navbar-brand-txt"><a class="txt-bold type-1" href="/">TempoTech</a></span>
                    </div>

                    <span class="navbar-toggler" id="toggler"><i onclick="toggleNavbar(this)"
                            class="fas fa-bars"></i></span>

                    <div class="navs" id="navs">
                        <div class="navs-item notbtn"><a href="index.html" class="txt-uppercase">Inicio</a></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="registro-container">
        <h1>Registro</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF"]); ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>

            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>

            <div class="checkbox-container">
                <label for="acepta_politicas">Acepto las políticas de privacidad <input type="checkbox"
                        id="acepta_politicas" name="acepta_politicas" required></label>


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
    </div>
</body>

</html>