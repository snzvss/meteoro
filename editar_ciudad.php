<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Editar Ciudad - TempoTech</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./img/logo.svg">
    <link rel="stylesheet" type="text/css" href="./css/admin.css">
</head>
<body>
    <nav>
        <span><img src="./img/logo.svg" alt="TempoTech Logo" class="logo-icon" width="70px"></span>
        <span class="navbar-brand-txt"><a class="txt-bold type-1" href="index.html">TempoTech</a></span>
        <div class="navs-item "><a href="admin.php">Inicio</a></div>
        <div class="navs-item notbtn"><a href="login.php"><button class="btn txt-uppercase shadow-sm">Cerrar
                    Sesión</button></a></div>
    </nav>
    <h1>Editar Ciudad</h1>

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

    <form action="procesar_editar_ciudad.php" method="post">
        <input type="hidden" name="ciudad_id" value="<?php echo $ciudad_id; ?>">

        <label for="nueva_ciudad">Nombre de la Ciudad:</label>
        <input type="text" id="nueva_ciudad" name="nueva_ciudad" value="<?php echo $nombre_ciudad; ?>" required>

        <button type="submit">Guardar Cambios</button>
    </form>
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
