<?php
// Agrega aquí la lógica necesaria para conectarte a la base de datos
include 'conexion.php';

// Verifica si la conexión a la base de datos es exitosa
if (!$conn) {
    die("Error de conexión a la base de datos.");
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    $id_ciudad = $_GET["id"];

    // Realiza la eliminación de la ciudad en la base de datos
    $query = "DELETE FROM busquedas_rapidas WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_ciudad);

    if ($stmt->execute()) {
        // Ciudad eliminada correctamente
        echo "<script>
                alert('Ciudad eliminada correctamente.');
                window.location.href = 'admin.php';
              </script>";
    } else {
        // Error al eliminar la ciudad
        echo "<script>
                alert('Error al eliminar la ciudad.');
                window.location.href = 'admin.php';
              </script>";
    }

    // Cierra la declaración y la conexión
    $stmt->close();
    $conn->close();
} else {
    // Redirige a la página principal si el parámetro ID no está presente
    header("Location: admin.php");
    exit();
}
?>
