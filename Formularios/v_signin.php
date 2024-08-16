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
    $correo = sanitizarEntrada($_POST['correo'], $conexion);
    $contrasenia = sanitizarEntrada($_POST['contrasenia'], $conexion);

    $stmt = $conexion->prepare("SELECT contrasenia FROM usuario WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($contrasenia_encriptada);
        $stmt->fetch();

        if (password_verify($contrasenia, $contrasenia_encriptada)) {
            header("location: ../index.php");
        } else {
            echo "<p class='error_contra'>Contraseña incorrecta. Por favor, inténtelo de nuevo.</p>";
        }
    } else {
        echo "<p class='error_correo'>El correo electrónico no está registrado. Por favor, regístrese primero.</p>";
    }

    $stmt->close();
    $conexion->close();
}

?>
