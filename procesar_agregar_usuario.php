<?php
include 'conexion.php';

// Verifica si la conexión a la base de datos es exitosa
if (!$conn) {
    die("Error de conexión a la base de datos.");
}

// Verifica si se enviaron datos mediante el formulario POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoge los datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];
    $tipo_usuario = $_POST["tipo_usuario"];

    // Consulta para verificar si el usuario ya existe
    $consulta_usuario_existente = "SELECT id FROM usuarios WHERE correo = '$correo'";
    $resultado = $conn->query($consulta_usuario_existente);

    // Si ya existe un usuario con el mismo correo, muestra una alerta y redirige
    if ($resultado->num_rows > 0) {
        echo "<script>
                alert('Usuario ya existe. Por favor, elige otro correo.');
                window.location.href='agregar_usuario.php';
              </script>";
        exit(); // Termina el script para evitar ejecutar el resto del código
    }

    // Hash de la contraseña (puedes mejorar esto según tus necesidades)
    $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

    // Prepara la consulta de inserción
    $query = "INSERT INTO usuarios (nombre, apellido, correo, contrasena, tipo_usuario) VALUES ('$nombre', '$apellido', '$correo', '$hashed_password', '$tipo_usuario')";

    // Ejecuta la consulta
    if ($conn->query($query) === TRUE) {
        echo "<script>
                alert('Usuario agregado exitosamente.');
                window.location.href='admin.php';
              </script>";
    } else {
        echo "Error al agregar usuario: " . $conn->error;
    }

    // Cierra la conexión a la base de datos
    $conn->close();
}
?>

