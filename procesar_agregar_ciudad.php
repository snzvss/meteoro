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
        echo "<script>
                alert('Ciudad agregada exitosamente.');
                window.location.href='admin.php';
              </script>";
    } else {
        echo "Error al agregar la ciudad: " . $conn->error;
    }

    // Cierra la conexión a la base de datos
    $conn->close();
}
?>
