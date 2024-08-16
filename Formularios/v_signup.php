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

    if ($contrasenia !== $confirmar_contrasenia) {
        echo "<p class='error_contra'>Las contraseñas no coinciden. Por favor, inténtelo de nuevo.</p>";
    } else {
        $stmt = $conexion->prepare("SELECT id_usuario FROM usuario WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<p class='error_correo'>El correo electrónico ya está registrado. Por favor, use otro correo electrónico.</p>";
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
                header("location: ../index.php");
            } else {
                echo "Hubo un error al guardar los datos: " . $stmt->error;
            }
        }

        $stmt->close();
    }
    $conexion->close();
}

?>
