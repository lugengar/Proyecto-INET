<?php
include "../codigophp/conexionbs.php";

// Función para sanitizar y proteger entradas del formulario
function sanitizarEntrada($data, $conn) {
    // Eliminar espacios al inicio y final
    $data = trim($data);
    
    // Escapar caracteres especiales para prevenir inyecciones SQL
    $data = mysqli_real_escape_string($conn, $data);
    
    // Convertir caracteres especiales a entidades HTML
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    
    return $data;
}
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir y sanitizar los datos del formulario
    $correo = sanitizarEntrada($_POST['correo'], $conn);
    $contrasenia = sanitizarEntrada($_POST['contrasenia'], $conn);

    $stmt = $conn->prepare("SELECT id_usuario, nombre, apellido, direccion, jerarquia, contrasenia FROM usuario WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_usuario,$nombre,$apellido,$direccion,$jerarquia,$contrasenia_encriptada);
        $stmt->fetch();

        if (password_verify($contrasenia, $contrasenia_encriptada)) {
            if (!empty($_SESSION['pedido'])) {
                $_SESSION['jerarquia'] = $jerarquia;
                $_SESSION['direccion'] = $direccion;
                $_SESSION['nombre'] = $nombre;
                $_SESSION['apellido'] = $apellido;
                $_SESSION['id_usuario'] = $id_usuario;
            }else{
                session_unset();
                $_SESSION['jerarquia'] = $jerarquia;
                $_SESSION['direccion'] = $direccion;
                $_SESSION['nombre'] = $nombre;
                $_SESSION['apellido'] = $apellido;
                $_SESSION['id_usuario'] = $id_usuario;
                $_SESSION['pedido'] = ["productos" => [],"cantidad" => [],"precios" => []];
            }
           header("location: ../index.php");
        } else {
            echo "<p class='error_contra'>Contraseña incorrecta. Por favor, inténtelo de nuevo.</p>";
        }
    } else {
        echo "<p class='error_correo'>El correo electrónico no está registrado. Por favor, regístrese primero.</p>";
    }

    $stmt->close();
    $conn->close();
}

?>
