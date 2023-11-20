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

    // Hash de la contraseña (puedes mejorar esto según tus necesidades)
    $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

    // Prepara la consulta de inserción
    $query = "INSERT INTO usuarios (nombre, apellido, correo, contrasena, tipo_usuario) VALUES ('$nombre', '$apellido', '$correo', '$hashed_password', '$tipo_usuario')";

    // Ejecuta la consulta
    if ($conn->query($query) === TRUE) {
        include "admin.php";
    } else {
        echo "Error al agregar usuario: " . $conn->error;
    }

    // Cierra la conexión a la base de datos
    $conn->close();
}
?>
