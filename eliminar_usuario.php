<?php
// Verificar la autenticación y permisos de administrador

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del usuario a eliminar desde el formulario
    $usuario_id = $_POST["usuario_id"];

    // Conectar a la base de datos (debes completar la información de conexión)
    $conn = new mysqli("localhost", "nombre_usuario", "contraseña", "nombre_base_de_datos");

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta SQL para eliminar el usuario
    $sql = "DELETE FROM usuarios WHERE id = ?";

    // Preparar la consulta
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("i", $usuario_id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Usuario eliminado exitosamente.";
    } else {
        echo "Error al eliminar usuario: " . $stmt->error;
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $conn->close();
} else {
    // Redirigir si se intenta acceder directamente al archivo
    header("Location: index.php");
    exit();
}
?>
