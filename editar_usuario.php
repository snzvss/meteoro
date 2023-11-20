<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Editar Usuario - TempoTech</title>
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
    <h1>Editar Usuario</h1>

    <?php
    // Recuperar el ID del usuario de la URL
    if (isset($_GET['id'])) {
        $usuario_id = $_GET['id'];

        // Agrega aquí la lógica necesaria para conectarte a la base de datos
        include 'conexion.php';

        // Verifica si la conexión a la base de datos es exitosa
        if (!$conn) {
            die("Error de conexión a la base de datos.");
        }

        // Consulta para obtener la información del usuario
        $query = "SELECT nombre, apellido, correo, tipo_usuario FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $stmt->bind_result($nombre, $apellido, $correo, $tipo_usuario);

        // Verifica si se obtuvieron resultados
        if ($stmt->fetch()) {
            // La información del usuario se ha recuperado correctamente
        } else {
            // No se encontró el usuario con el ID proporcionado, puedes manejar esto según tus necesidades
            die("Usuario no encontrado.");
        }

        // Cierra la consulta y la conexión
        $stmt->close();
        $conn->close();
    } else {
        // No se proporcionó el ID del usuario en la URL, puedes manejar esto según tus necesidades
        die("ID de usuario no proporcionado.");
    }
?>


    <form action="procesar_editar_usuario.php" method="post">
        <input type="hidden" name="usuario_id" value="<?php echo $usuario_id; ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" value="<?php echo $apellido; ?>" required>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?php echo $correo; ?>" required>

        <label for="tipo_usuario">Tipo de Usuario:</label>
        <select id="tipo_usuario" name="tipo_usuario" required>
            <option value="administrador" <?php echo ($tipo_usuario === 'administrador') ? 'selected' : ''; ?>>
                Administrador
            </option>
            <option value="usuario" <?php echo ($tipo_usuario === 'usuario') ? 'selected' : ''; ?>>
                Usuario Normal
            </option>
            <!-- Agrega más opciones según sea necesario -->
        </select>

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
