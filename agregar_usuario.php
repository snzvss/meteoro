<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Agregar Usuario - TempoTech</title>
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
    <div class="loading" id="loading-box">
        <div class="loading-item">
            <div class="loading-progress"></div>
        </div>
    </div>
    <main class="main">
        <div class="navbar">
            <div class="container">
                <div class="navbar-nav">
                    <div class="navbar-brand">
                        <span><img src="./img/logo.svg" alt="TempoTech Logo" class="logo-icon" width="70px"></span>
                        <span class="navbar-brand-txt"><a class="txt-bold type-1" href="index.html">TempoTech</a></span>

                        <span class="navbar-toggler" id="toggler"><i onclick="toggleNavbar(this)"
                                class="fas fa-bars"></i></span>
                    </div>
                    <div class="navs" id="navs">
                        <div class="navs-item notbtn"><a href="admin.php" class="txt-uppercase">Inicio</a></div>
                        <div class="navs-item"><a href="login.php"><button class="btn txt-uppercase shadow-sm">Cerrar
                                    Sesion</button></a></div>

                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="contact-box">
        <h1 class="contact-t" id="">Agregar Usuarios</h1>
        <div class="container">
            <div class="contact-form">
                <form id="contact-form" action="procesar_agregar_usuario.php" method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" id="apellido" name="apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo:</label>
                        <input type="email" id="correo" name="correo" required>
                    </div>
                    <div class="form-group">
                        <label for="contrasena">Contraseña:</label>
                        <input type="password" id="contrasena" name="contrasena" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_usuario">Tipo de Usuario:</label>
                        <select id="tipo_usuario" name="tipo_usuario" required>
                            <option value="administrador">Administrador</option>
                            <option value="usuario">Usuario Normal</option>
                            <!-- Agrega más opciones según sea necesario -->
                        </select>
                    </div>
                    <button type="submit">Agregar Usuario</button>
            </div>
        </div>
        <div id="response-message"></div>
    </div>
    <script type="text/javascript" src="./js/script.js"></script>
</body>

<footer>
    <div class="features-box">
        <div class="container">
            <div class="footer-items">
                <div class="footer-item">
                    <span>&copy; 2023 Desarrollado por Camilo Sanz y Jeyson Marañon - Todos los derechos
                        reservados.</span>
                </div>
            </div>
        </div>
    </div>
</footer>

</html>