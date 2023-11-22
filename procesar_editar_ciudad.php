<?php
// Verificar si se enviaron datos por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recuperar los datos del formulario
    $ciudad_id = $_POST['ciudad_id'];
    $nueva_ciudad = $_POST['nueva_ciudad'];

    // Agregar aquí la lógica necesaria para conectarte a la base de datos
    include 'conexion.php';

    // Verificar si la conexión a la base de datos es exitosa
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    // Actualizar la información de la ciudad en la base de datos
    $query = "UPDATE busquedas_rapidas SET ciudad=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $nueva_ciudad, $ciudad_id);

    if ($stmt->execute()) {
        // Cerrar la conexión y la consulta preparada
        $stmt->close();
        $conn->close();

        // Redireccionar a admin.php después de editar la ciudad y mostrar la alerta
        echo "<script>
                alert('Ciudad editada correctamente.');
                window.location.href='admin.php';
              </script>";
        exit();
    } else {
        die("Error al editar la ciudad: " . $stmt->error);
    }
} else {
    // Si se intenta acceder directamente a este script sin enviar datos por POST, redirigir a admin.php
    header("Location: admin.php");
    exit();
}

?>
