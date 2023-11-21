<?php
// Inicia la sesión para verificar si el usuario está autenticado
session_start();

// Verifica si el usuario no está autenticado y redirige a la página de inicio de sesión
if (!isset($_SESSION["usuario_autenticado"]) || $_SESSION["usuario_autenticado"] !== true) {
    echo '<script>window.location="login.php"</script>';
    exit();
}

// Procesa el formulario de solicitud meteorológica
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recupera la ciudad seleccionada por el usuario
    $ciudad = $_POST["ciudad"];

    // Construye la URL de la API con la ciudad seleccionada
    $api_url = "http://api.weatherapi.com/v1/current.json?key=02e5f308a87f41859c610012231911&q=" . urlencode($ciudad) . "&aqi=yes";

    // Realiza la solicitud a la API y obtiene la respuesta
    $respuesta_api = file_get_contents($api_url);

    // Decodifica el JSON de la respuesta
    $datos_clima = json_decode($respuesta_api, true);

    // Verifica si la solicitud fue exitosa antes de mostrar los datos
    if ($datos_clima !== null && isset($datos_clima["location"], $datos_clima["current"])) {
        // Extrae las variables importantes para mostrar
        $nombre_ciudad = $datos_clima["location"]["name"];
        $region = $datos_clima["location"]["region"];
        $pais = $datos_clima["location"]["country"];
        $temperatura_c = $datos_clima["current"]["temp_c"];
        $temperatura_f = $datos_clima["current"]["temp_f"];
        $condicion_clima = $datos_clima["current"]["condition"]["text"];
        $icono_clima = $datos_clima["current"]["condition"]["icon"];
        $viento_kph = $datos_clima["current"]["wind_kph"];
        $presion_mb = $datos_clima["current"]["pressure_mb"];
        $humedad = $datos_clima["current"]["humidity"];

        // Puedes mostrar estas variables en tu página HTML como desees
    } else {
        // La solicitud a la API no fue exitosa, muestra un mensaje de error
        $error_api = "Error al obtener información meteorológica.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Dashboard - Mi Empresa Meteorológica</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./img/logo.svg">
    <link rel="stylesheet" type="text/css" href="./css/coloring.css">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/inicio.css">
    <link rel="stylesheet" type="text/css" href="./css/txtformatting.css">
    <link rel="stylesheet" type="text/css" href="./css/shadow.css">
    <link rel="stylesheet" type="text/css" href="./css/loading.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="on">

    <div class="dashboard-container">
        <nav>
            <a href="cerrar_sesion.php">Cerrar sesión</a>
        </nav>

        <h1>Bienvenido al Dashboard</h1>

        <!-- Formulario para solicitar información meteorológica -->
                <?php
        // Agrega aquí la lógica necesaria para conectarte a la base de datos
        include 'conexion.php';

        // Verifica si la conexión a la base de datos es exitosa
        if (!$conn) {
            die("Error de conexión a la base de datos.");
        }

        // Consulta las ciudades desde la base de datos
        $query_ciudades = "SELECT id, ciudad FROM busquedas_rapidas";
        $result_ciudades = $conn->query($query_ciudades);

        // Verifica si la consulta fue exitosa
        if (!$result_ciudades) {
            die("Error en la consulta de ciudades: " . $conn->error);
        }

        // Cierra la conexión
        $conn->close();
        ?>

        <!-- Formulario para el CRUD de Ciudades -->
        <form method="post" action="inicio.php">
            <label for="ciudad">Selecciona una ciudad:</label>
            <select id="ciudad" name="ciudad" required>
                <?php
                // Muestra las ciudades desde la base de datos en las opciones del select
                while ($row_ciudad = $result_ciudades->fetch_assoc()) {
                    echo "<option value='{$row_ciudad['ciudad']}'>{$row_ciudad['ciudad']}</option>";
                }
                ?>
            </select>

            <button type="submit">Obtener información meteorológica</button>
        </form>

        <?php
        // Muestra la información meteorológica si está disponible
        if (isset($nombre_ciudad)) {
            echo '<div class="clima-info">';
            echo '<h2>Información meteorológica para ' . $nombre_ciudad . '</h2>';
            echo '<p>Región: ' . $region . '</p>';
            echo '<p>País: ' . $pais . '</p>';
            echo '<p>Temperatura: ' . $temperatura_c . '°C / ' . $temperatura_f . '°F</p>';
            echo '<p>Condición: ' . $condicion_clima . '</p>';
            echo '<img src="' . $icono_clima . '" alt="Icono del clima">';
            echo '<p>Viento: ' . $viento_kph . ' kph</p>';
            echo '<p>Presión: ' . $presion_mb . ' mb</p>';
            echo '<p>Humedad: ' . $humedad . '%</p>';
            echo '</div>';
        }

        // Muestra el mensaje de error si la solicitud a la API falla
        if (isset($error_api)) {
            echo '<p class="error-message">' . $error_api . '</p>';
        }
        ?>
    </div>

    <!-- Agrega tus scripts JS aquí -->
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .dashboard-container {
            background-color: var(--third-disabled);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px; /* Ajusta el ancho máximo según tus necesidades */
            margin: auto; /* Centra el contenedor en la pantalla */
            margin-top: 100px; /* Espacio superior */
        }

        nav {
            text-align: right;
        }

        nav a {
            color: var(--secondary);
            text-decoration: none;
            font-size: 16px;
        }

        h1 {
            margin-top: 7px;
            color: var(--secondary);
            text-align: center;
        }

        /* Estilos para el formulario */

        form {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
        }

        label {
            font-size: 18px;
            font-weight: bold;
            color: var(--secondary);
            margin-bottom: 5px;
        }

        select,
        button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid var(--secondary);
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: var(--third);
            color: var(--secondary);
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 10px;
        }

        button:hover {
            background-color: var(--third-disabled);
        }

        /* Estilos para la tabla de información meteorológica */

        .clima-info {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }

        .clima-info h2 {
            font-size: 24px;
            color: var(--secondary);
            margin-bottom: 10px;
        }

        .clima-info p {
            font-size: 16px;
            color: var(--secondary);
            margin: 5px 0;
        }

        .clima-info img {
            margin-top: 10px;
        }

        /* Estilos para mensajes de error */

        .error-message {
            color: white;
            background-color: red;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</body>
</html>
