<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
</head>
<body>

<h2>Formulario de Registro</h2>

<form action="" method="POST">
    <label for="nombre">Nombre:</label><br>
    <input type="text" name="nombre" required><br><br>
    
    <label for="apellido">Apellido:</label><br>
    <input type="text" name="apellido" required><br><br>
    
    <label for="contrasenia">Contraseña:</label><br>
    <input type="password" name="contrasenia" required><br><br>
    
    <label for="confirmar_contrasenia">Confirmar Contraseña:</label><br>
    <input type="password" name="confirmar_contrasenia" required><br><br>
    
    <label for="correo">Correo Electrónico:</label><br>
    <input type="email" name="correo" required><br><br>
    
    <label for="direccion">Dirección:</label><br>
    <input type="text" name="direccion" required><br><br>
    
    <input type="submit" value="Registrar">
</form>

<?php

$usuario = "root";
$password = "";
$servidor = "localhost";
$basededatos = "inet";

$conexion = mysqli_connect($servidor, $usuario, $password, $basededatos);

if (!$conexion) {
    die("Error al conectarse al servidor de la base de datos: " . mysqli_connect_error());
}

// Función para sanitizar y proteger entradas del formulario
function sanitizarEntrada($data, $conexion) {
    // Eliminar espacios al inicio y final
    $data = trim($data);
    
    // Escapar caracteres especiales para prevenir inyecciones SQL
    $data = mysqli_real_escape_string($conexion, $data);
    
    // Convertir caracteres especiales a entidades HTML
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir y sanitizar los datos del formulario
    $nombre = sanitizarEntrada($_POST['nombre'], $conexion);
    $apellido = sanitizarEntrada($_POST['apellido'], $conexion);
    $contrasenia = sanitizarEntrada($_POST['contrasenia'], $conexion);
    $confirmar_contrasenia = sanitizarEntrada($_POST['confirmar_contrasenia'], $conexion);
    $correo = sanitizarEntrada($_POST['correo'], $conexion);
    $direccion = sanitizarEntrada($_POST['direccion'], $conexion);

    // Verificar si las contraseñas coinciden
    if ($contrasenia !== $confirmar_contrasenia) {
        echo "Las contraseñas no coinciden. Por favor, inténtelo de nuevo.";
    } else {
        // Encriptar la contraseña
        $contrasenia_encriptada = password_hash($contrasenia, PASSWORD_DEFAULT);

        // Preparar la consulta SQL usando sentencias preparadas para mayor seguridad
        $stmt = $conexion->prepare("INSERT INTO usuario (nombre, apellido, contrasenia, correo, direccion) VALUES (?, ?, ?, ?, ?)");

        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conexion->error);
        }

        // Vincular parámetros a la consulta preparada
        $stmt->bind_param("sssss", $nombre, $apellido, $contrasenia_encriptada, $correo, $direccion);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Datos guardados correctamente. <a href='index.php'>Volver</a>";
        } else {
            echo "Hubo un error al guardar los datos: " . $stmt->error;
        }

        $stmt->close();
    }
    $conexion->close();
}

?>

</body>
</html>
