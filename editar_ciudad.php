<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Editar Ciudad - TempoTech</title>
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
        <main class="main">
            <div class="navbar">
                <div class="container">
                    <div class="navbar-nav">
                        <div class="navbar-brand">
                            <span><img src="./img/logo.svg" alt="TempoTech Logo" class="logo-icon" width="70px"></span>
                            <span class="navbar-brand-txt"><a class="txt-bold type-1"
                                    href="index.html">TempoTech</a></span>

                            <span class="navbar-toggler" id="toggler"><i onclick="toggleNavbar(this)"
                                    class="fas fa-bars"></i></span>
                        </div>
                        <div class="navs" id="navs">
                            <div class="navs-item notbtn"><a href="admin.php" class="txt-uppercase">Inicio</a></div>
                            <div class="navs-item"><a href="login.php"><button
                                        class="btn txt-uppercase shadow-sm">Cerrar Sesion</button></a></div>

                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php
    // Recuperar el ID de la ciudad de la URL
    if (isset($_GET['id'])) {
        $ciudad_id = $_GET['id'];

        // Agrega aquí la lógica necesaria para conectarte a la base de datos
        include 'conexion.php';

        // Verifica si la conexión a la base de datos es exitosa
        if (!$conn) {
            die("Error de conexión a la base de datos.");
        }

        // Consulta para obtener la información de la ciudad
        $query = "SELECT ciudad FROM busquedas_rapidas WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $ciudad_id);
        $stmt->execute();
        $stmt->bind_result($nombre_ciudad);

        // Verifica si se obtuvieron resultados
        if ($stmt->fetch()) {
            // La información de la ciudad se ha recuperado correctamente
        } else {
            // No se encontró la ciudad con el ID proporcionado, puedes manejar esto según tus necesidades
            die("Ciudad no encontrada.");
        }

        // Cierra la consulta y la conexión
        $stmt->close();
        $conn->close();
    } else {
        // No se proporcionó el ID de la ciudad en la URL, puedes manejar esto según tus necesidades
        die("ID de ciudad no proporcionado.");
    }
    ?>

        <div class="contact-box">
            <h1 class="contact-t" id="">Editar Ciudad</h1>
            <div class="container">
                <div class="contact-form">
                    <form id="contact-form" action="procesar_agregar_usuario.php" method="post">
                        <div class="form-group">
                            <input type="hidden" name="ciudad_id" value="<?php echo $ciudad_id; ?>">
                        </div>
                        <div class="form-group">
                            <label for="nueva_ciudad">Nombre de la Ciudad:</label>
                            <input type="text" id="nueva_ciudad" name="nueva_ciudad"
                                value="<?php echo $nombre_ciudad; ?>" required>
                        </div>
                        <button type="submit">Guardar Cambios</button>
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