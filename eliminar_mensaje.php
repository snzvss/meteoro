<?php
// Agrega aquí la lógica necesaria para conectarte a la base de datos
include 'conexion.php';

// Verifica si la conexión a la base de datos es exitosa
if (!$conn) {
    die("Error de conexión a la base de datos.");
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    $id_mensaje = $_GET["id"];

    // Realiza la eliminación del mensaje en la base de datos
    $query = "DELETE FROM contactos WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_mensaje);

    if ($stmt->execute()) {
        // Mensaje eliminado correctamente
        echo "<script>
                alert('Mensaje eliminado correctamente.');
                window.location.href = 'admin.php';
              </script>";
    } else {
        // Error al eliminar el mensaje
        echo "<script>
                alert('Error al eliminar el mensaje.');
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
