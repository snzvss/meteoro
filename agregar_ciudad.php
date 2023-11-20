<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Agregar Ciudad - TempoTech</title>
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
    <div class="form-container">
        <h1>Agregar Ciudad</h1>
        <form method="post" action="procesar_agregar_ciudad.php">
            <label for="nombre_ciudad">Nombre de la Ciudad:</label>
            <input type="text" id="nombre_ciudad" name="nombre_ciudad" required>

            <button type="submit">Agregar Ciudad</button>
        </form>
    </div>
    <?php
// Agrega aquí la lógica necesaria para conectarte a la base de datos
include 'conexion.php';

// Verifica si la conexión a la base de datos es exitosa
if (!$conn) {
    die("Error de conexión a la base de datos.");
}

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recupera el nombre de la ciudad desde el formulario
    $nombre_ciudad = $_POST["nombre_ciudad"];

    // Puedes realizar validaciones adicionales aquí antes de la inserción en la base de datos

    // Inserta la ciudad en la base de datos
    $query = "INSERT INTO busquedas_rapidas (ciudad) VALUES ('$nombre_ciudad')";
    $result = $conn->query($query);

    // Verifica si la inserción fue exitosa
    if ($result) {
        echo "Ciudad agregada con éxito.";
    } else {
        echo "Error al agregar la ciudad: " . $conn->error;
    }

    // Cierra la conexión a la base de datos
    $conn->close();
}
?>

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