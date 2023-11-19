<?php
// Incluye el archivo de conexión
include 'conexion.php';

// Verifica si la conexión a la base de datos es exitosa
if (!$conn) {
    $response = "Error de conexión a la base de datos.";
    echo $response;
}

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si los campos esperados están presentes en el array $_POST
    if (isset($_POST["companyName"]) && isset($_POST["location"]) && isset($_POST["contactType"]) && isset($_POST["message"])) {
        // Obtener los datos del formulario
        $companyName = $_POST["companyName"];
        $location = $_POST["location"];
        $contactType = $_POST["contactType"];
        $message = $_POST["message"];

        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare("INSERT INTO contactos (nombre_empresa, ubicacion, tipo_consulta, mensaje) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $companyName, $location, $contactType, $message);

        if ($stmt->execute()) {
            $response = "Formulario enviado correctamente.";
            echo $response;
        } else {
            $response = "Error al enviar el formulario.";
            echo $response;
        }

        // Cerrar la consulta y la conexión
        $stmt->close();
    } else {
        $response = "Campos del formulario incompletos.";
        echo $response;
    }
    $conn->close();
} else {
    $response = "Método de solicitud no válido.";
    echo $response;
}
?>
