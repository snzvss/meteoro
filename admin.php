<?php
// Verifica si el usuario tiene permisos de administrador, si no, redirige a la página de inicio
session_start();
if (!isset($_SESSION["usuario"]) || $_SESSION["tipo_usuario"] !== "administrador") {
    header("Location: login.php");
    exit();
}

// Agrega aquí la lógica necesaria para conectarte a la base de datos
include 'conexion.php';

// Verifica si la conexión a la base de datos es exitosa
if (!$conn) {
    die("Error de conexión a la base de datos.");
}

// Lógica para el CRUD de Usuarios
$tabla_usuarios_visible = false;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["accion_usuarios"])) {
    $accion_usuarios = $_POST["accion_usuarios"];

    // Agrega lógica para cada acción (crear, leer, actualizar, eliminar) según sea necesario
    if ($accion_usuarios === "leer_usuarios") {
        $tabla_usuarios_visible = true;
        $query = "SELECT id, nombre, correo FROM usuarios";
        $result = $conn->query($query);

        // Verifica si la consulta fue exitosa
        if (!$result) {
            die("Error en la consulta: " . $conn->error);
        }

        // Verifica si hay filas devueltas
        if ($result->num_rows > 0) {
            $usuarios = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            // No se encontraron usuarios, puedes mostrar un mensaje o hacer algo más
            echo "No se encontraron usuarios.";
        }

        // Cierra el resultado
        $result->close();
    }
}

// Lógica para el CRUD de Ciudades
$tabla_ciudades_visible = false;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["accion_ciudades"])) {
    $accion_ciudades = $_POST["accion_ciudades"];

    // Agrega lógica para cada acción (crear, leer, actualizar, eliminar) según sea necesario
    if ($accion_ciudades === "leer_ciudades") {
        $tabla_ciudades_visible = true;
        $query = "SELECT id, ciudad FROM busquedas_rapidas";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $ciudades = $result->fetch_all(MYSQLI_ASSOC);
        }
    }
}

// Lógica para la visualización/eliminación de Mensajes de Contacto
$tabla_mensajes_visible = false;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["accion_mensajes"])) {
    $accion_mensajes = $_POST["accion_mensajes"];

    // Agrega lógica para cada acción (ver, eliminar) según sea necesario
    if ($accion_mensajes === "ver_mensajes") {
        $tabla_mensajes_visible = true;
        $query = "SELECT id, nombre_empresa, ubicacion, tipo_consulta, mensaje FROM contactos";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $mensajes_contacto = $result->fetch_all(MYSQLI_ASSOC);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Panel de Administrador - Mi Empresa Meteorológica</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./img/logo.svg">
    <link rel="stylesheet" type="text/css" href="./css/coloring.css">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/txtformatting.css">
    <link rel="stylesheet" type="text/css" href="./css/shadow.css">
    <link rel="stylesheet" type="text/css" href="./css/loading.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="on">

<div class="dashboard-container">
    <nav>
        <span>Bienvenido, <?php echo $_SESSION["usuario"]; ?> | </span>
        <a href="cerrar_sesion.php">Cerrar sesión</a>
    </nav>


    <h1>Panel de Administrador</h1>
<!-- Formulario y HTML para el CRUD de Usuarios -->
<section>
    <h2>Usuarios</h2>
    <form method="post" action="admin.php">
        <input type="hidden" name="accion_usuarios" value="leer_usuarios">
        <button type="submit">Mostrar Usuarios</button>
        <a href="agregar_usuario.php">
            <button type="button">Agregar Usuario</button>
        </a>
        <?php if ($tabla_usuarios_visible): ?>
            <input type="text" style="padding: 10px; border-radius: 5px;" name="busqueda_usuarios" placeholder="Buscar Usuarios">
        <?php endif; ?>
    </form>
    
    <?php if ($tabla_usuarios_visible && isset($usuarios)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Acciones</th> <!-- Nuevo encabezado para acciones -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo $usuario['id']; ?></td>
                        <td><?php echo $usuario['nombre']; ?></td>
                        <td><?php echo $usuario['correo']; ?></td>
                        <td>
                            <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>">
                                <img src="img/editar.svg" alt="Editar">
                            </a>
                            <a href="eliminar_usuario.php?id=<?php echo $usuario['id']; ?>">
                                <img src="img/borrar.svg" alt="Borrar">
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>


    <!-- Formulario y HTML para el CRUD de Ciudades -->
    <section>
        <h2>Ciudades</h2>
        <form method="post" action="admin.php">
            <input type="hidden" name="accion_ciudades" value="leer_ciudades">
            <button type="submit">Mostrar Ciudades</button>
            <a href="agregar_usuario.php">
            <button type="button">Agregar Ciudad</button>
        </a>
        <?php if ($tabla_ciudades_visible): ?>
            <input type="text" style="padding: 10px; border-radius: 5px;" name="busqueda_ciudad" placeholder="Buscar Ciudad">
        <?php endif; ?>
        </form>
        <?php if ($tabla_ciudades_visible && isset($ciudades)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ciudades as $ciudad): ?>
                        <tr>
                            <td><?php echo $ciudad['id']; ?></td>
                            <td><?php echo $ciudad['ciudad']; ?></td>
                            <td>
                            <a href="editar_ciudad.php?id=<?php echo $ciudad['id']; ?>">
                                <img src="img/editar.svg" alt="Editar">
                            </a>
                            <a href="eliminar_ciudad.php?id=<?php echo $ciudad['id']; ?>">
                                <img src="img/borrar.svg" alt="Borrar">
                            </a>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>

    <!-- Formulario y HTML para ver y eliminar Mensajes de Contacto -->
    <section>
        <h2>Mensajes de Contacto</h2>
        <form method="post" action="admin.php">
            <input type="hidden" name="accion_mensajes" value="ver_mensajes">
            <button type="submit">Ver Mensajes</button>
        </form>
        <?php if ($tabla_mensajes_visible && isset($mensajes_contacto)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Tipo de consulta</th>
                        <th>Mensaje</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mensajes_contacto as $mensaje): ?>
                        <tr>
                            <td><?php echo $mensaje['id']; ?></td>
                            <td><?php echo $mensaje['nombre_empresa']; ?></td>
                            <td><?php echo $mensaje['ubicacion']; ?></td>
                            <td><?php echo $mensaje['tipo_consulta']; ?></td>
                            <td><?php echo $mensaje['mensaje']; ?></td>
                            <td>
                            <a href="eliminar_mensaje.php?id=<?php echo $mensaje['id']; ?>">
                                <img src="img/borrar.svg" alt="Borrar">
                            </a>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
</div>

<!-- Agrega tus scripts JS aquí -->
<style>
    /* Agrega tus estilos CSS aquí según tus necesidades */
    .dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

nav {
    display: flex;
    background-color: var(--third);
    padding: 11px;
    text-align: center;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: flex-end;
}

/* Estilos para el mensaje de bienvenida y el enlace de cerrar sesión */
nav span, nav a {
    color: var(--secondary);
    text-decoration: none;
    font-size: 16px; /* Ajusta el tamaño de la fuente según sea necesario */
    margin-right: 10px; /* Ajusta el espaciado entre los elementos según sea necesario */
}

h1, h2 {
    text-align: center;
}

form {
    text-align: center;
    margin-bottom: 20px;
}

button {
    /* Estilos para los botones */
    padding: 10px;
    background-color: var(--third);
    color: var(--secondary);
    border: none;
    border-radius: 4px;
    font-size: 18px;
    cursor: pointer;
    transition: 0.2s;
}

button:hover {
    background-color: var(--third-disabled);
}

table {
    /* Estilos para las tablas */
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

/* Estilos para la columna de acciones */
td a {
    display: inline-block;
    margin-right: 8px; /* Espaciado entre los iconos */
}

/* Estilos para los iconos SVG */
td a img {
    width: 20px; /* Ajusta el tamaño de los iconos según tus preferencias */
    height: 20px;
    vertical-align: middle;
}

th {
    background-color: var(--third);
    color: var(--secondary);
}

tbody tr:hover {
    background-color: var(--third-disabled);
}

/* Estilos para la búsqueda de ciudades */
/* Estilos para la búsqueda de ciudades */
.busqueda_ciudad {
    margin: 20px 0; /* Ajusta el margen según sea necesario */
}

.busqueda_ciudad label {
    font-size: 18px; /* Ajusta el tamaño de la fuente según sea necesario */
}

.busqueda_ciudad select, .busqueda_ciudad input {
    padding: 10px;
    font-size: 16px;
}

.busqueda_ciudad button {
    padding: 10px;
    background-color: #3498db; /* Cambia el color de fondo según sea necesario */
    color: #fff; /* Cambia el color del texto según sea necesario */
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.2s;
}

.busqueda_ciudad button:hover {
    background-color: #2980b9; /* Cambia el color de fondo al pasar el mouse según sea necesario */
}

/* Estilos para la búsqueda de usuarios */
.busqueda_usuarios {
    margin: 20px 0; /* Ajusta el margen según sea necesario */
}

.busqueda_usuarios label {
    font-size: 18px; /* Ajusta el tamaño de la fuente según sea necesario */
}

.busqueda_usuarios input, .busqueda_usuarios button {
    padding: 10px;
    font-size: 16px;
}

.busqueda_usuarios button {
    padding: 10px;
    background-color: #27ae60; /* Cambia el color de fondo según sea necesario */
    color: #fff; /* Cambia el color del texto según sea necesario */
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.2s;
}

.busqueda_usuarios input[type="text"] {
    padding: 10px;
    font-size: 16px;
    width: 600px; /* Ajusta el ancho según sea necesario */
    margin-right: 10px; /* Ajusta el espaciado entre el input y los botones según sea necesario */
}

.busqueda_ciudad input[type="text"] {
    padding: 10px;
    font-size: 16px;
    width: 200px; /* Ajusta el ancho según sea necesario */
}

.busqueda_usuarios button:hover {
    background-color: #219a52; /* Cambia el color de fondo al pasar el mouse según sea necesario */
}

</style>
</body>
</html>
