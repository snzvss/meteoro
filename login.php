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

    // Inicializa la variable de mensaje de error
    $error_message = "";

    // Procesa el formulario cuando se envía
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario
    $correo = $_POST["username"];
    $contrasena = $_POST["password"];

    // Prepara y ejecuta la consulta SQL para obtener la información del usuario
    $stmt = $conn->prepare("SELECT tipo_usuario, contrasena FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->bind_result($tipo_usuario, $hashed_password);

    if ($stmt->fetch() && password_verify($contrasena, $hashed_password)) {

    if ($tipo_usuario == "administrador" || $tipo_usuario == "usuario") {
    session_start();
    $_SESSION['usuario_autenticado'] = true;
    $_SESSION['tipo_usuario'] = $tipo_usuario;
    $_SESSION['usuario'] = $correo;
    if ($tipo_usuario == "administrador") {
    echo '<script>window.location = "admin.php"</script>';
    } elseif ($tipo_usuario == "usuario") {
    echo '<script>window.location = "inicio.php"</script>';
    }
    exit();
    }
    } else {
    // Usuario o contraseña incorrectos
    $error_message = "Usuario o contraseña incorrectos.";
    }


    // Cierra la declaración
    $stmt->close();
    $conn->close();
    }
    ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Login - Mi Empresa Meteorológica</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./img/logo.svg">
    <link rel="stylesheet" type="text/css" href="./css/coloring.css">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/txtformatting.css">
    <link rel="stylesheet" type="text/css" href="./css/shadow.css">
    <link rel="stylesheet" type="text/css" href="./css/loading.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="on">
    <div class="overlay"></div>
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
    <div class="features-box">
        <div class="container">
            <div class="login-container">
                <h1>
                    <img src="./img/login-svgrepo-com.svg" alt="Login Icon" class="login-icon">
                    Login
                </h1>
                <form method="post" action="login.php">
                    <label for="username">Correo:</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit">Iniciar sesión</button>
                </form>

                <?php
    // Muestra mensajes de error si hay alguno
    if (!empty($error_message)) {
    echo '<p class="error-message">' . $error_message . '</p>';
    }
    ?>

                
                <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
            </div>
        </div>
    </div>

    <style>
        
        body {
            background-image: url('./img/background.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0; /* Asegura que no haya márgenes en el cuerpo de la página */
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Color oscuro con opacidad del 50% */
            z-index: -1; /* Coloca el overlay detrás del contenido */
        }


        .login-container {
            width: 35%;
            background-color: var(--third-disabled);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            /* Centra el contenedor en la página */
            margin-top: 50px;
            /* Ajusta el margen superior según tus preferencias */
        }

        .login-container h1 {
            color: var(--secondary);
            display: flex;
            text-align: center;
            align-items: center;
            /* Centra verticalmente el texto e icono */
            justify-content: center;
            margin-bottom: 20px;
            /* Espaciado inferior */
        }

        .login-container h1 img {
            width: 24px;
            /* Ajusta el tamaño del icono según tus preferencias */
            margin-right: 8px;
            /* Espacio entre el icono y el texto "Login" */
        }

        .login-container form {
            display: flex;
            flex-direction: column;
        }

        .login-container label {
            font-size: 18px;
            font-weight: bold;
            color: var(--secondary);
            margin-bottom: 5px;
            /* Ajusta el espacio inferior según tus preferencias */
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--secondary);
            border-radius: 4px;
            font-size: 16px;
            margin-top: 5px;
        }

        .login-container button {
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

        .login-container button:hover {
            background-color: var(--third-disabled);
        }

        .login-container .error-message {
            color: white;
            background-color: red;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            text-align: center;
        }

        .login-container p {
            color: var(--secondary);
            text-align: center;
            margin-top: 10px;
        }

        .login-container a {
            color: var(--secondary);
            font-weight: bold;
            text-decoration: none;
        }

        .login-container a:hover {
            color: var(--o1);
        }
        @media screen and (max-width: 600px) {
            .login-container {
            width: 100%;
            background-color: var(--third-disabled);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: 0 50px;
            /* Centra el contenedor en la página */
            margin-top: 80px;
            /* Ajusta el margen superior según tus preferencias */
        }

            .container {
            margin: 0 1px;
            width: 100%;
        }
    }
    </style>
</body>

</html>