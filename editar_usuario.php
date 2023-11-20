<?php
// Verificar la autenticación y permisos de administrador

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $usuario_id = $_POST["usuario_id"];
    $nuevo_nombre = $_POST["nuevo_nombre"];
    $nueva_email = $_POST["nueva_email"];

    // Conectar a la base de datos (debes completar la información de conexión)
    $conn = new mysqli("localhost", "nombre_usuario", "contraseña", "nombre_base_de_datos");

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta SQL para actualizar el usuario
    $sql = "UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?";

    // Preparar la consulta
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("ssi", $nuevo_nombre, $nueva_email, $usuario_id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Usuario modificado exitosamente.";
    } else {
        echo "Error al modificar usuario: " . $stmt->error;
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

