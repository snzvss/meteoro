<?php
// Verificar si se enviaron datos por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recuperar los datos del formulario
    $usuario_id = $_POST['usuario_id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $tipo_usuario = $_POST['tipo_usuario'];

    // Agregar aquí la lógica necesaria para conectarte a la base de datos
    include 'conexion.php';

    // Verificar si la conexión a la base de datos es exitosa
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    // Actualizar la información del usuario en la base de datos
    $query = "UPDATE usuarios SET nombre=?, apellido=?, correo=?, tipo_usuario=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $nombre, $apellido, $correo, $tipo_usuario, $usuario_id);

    if ($stmt->execute()) {
        // Cerrar la conexión y la consulta preparada
        $stmt->close();
        $conn->close();

        // Redireccionar a admin.php después de editar el usuario y mostrar la alerta
        echo "<script>
                alert('Usuario editado correctamente.');
                window.location.href='admin.php';
              </script>";
        exit();
    } else {
        die("Error al editar el usuario: " . $stmt->error);
    }
} else {
    // Si se intenta acceder directamente a este script sin enviar datos por POST, redirigir a admin.php
    header("Location: admin.php");
    exit();
}

?>
