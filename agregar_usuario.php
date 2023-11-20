<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Agregar Usuario - TempoTech</title>
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
                    Sesion</button></a></div>
    </nav>
    <h1>Agregar Usuario</h1>
    <form action="procesar_agregar_usuario.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>

        <label for="tipo_usuario">Tipo de Usuario:</label>
        <select id="tipo_usuario" name="tipo_usuario" required>
            <option value="administrador">Administrador</option>
            <option value="usuario">Usuario Normal</option>
            <!-- Agrega más opciones según sea necesario -->
        </select>

        <button type="submit">Agregar Usuario</button>
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
