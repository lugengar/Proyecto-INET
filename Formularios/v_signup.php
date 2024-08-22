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
    $nombre = sanitizarEntrada($_POST['nombre'], $conn);
    $apellido = sanitizarEntrada($_POST['apellido'], $conn);
    $contrasenia = sanitizarEntrada($_POST['contrasenia'], $conn);
    $confirmar_contrasenia = sanitizarEntrada($_POST['confirmar_contrasenia'], $conn);
    $correo = sanitizarEntrada($_POST['correo'], $conn);
    $direccion = sanitizarEntrada($_POST['direccion'], $conn);

    if ($contrasenia !== $confirmar_contrasenia) {
        echo "<p class='error_contra'>Las contraseñas no coinciden. Por favor, inténtelo de nuevo.</p>";
    } else {
        $stmt = $conn->prepare("SELECT id_usuario FROM usuario WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<p class='error_correo'>El correo electrónico ya está registrado. Por favor, use otro correo electrónico.</p>";
        } else {
            // Encriptar la contraseña
            $contrasenia_encriptada = password_hash($contrasenia, PASSWORD_DEFAULT);

            // Preparar la consulta SQL usando sentencias preparadas para mayor seguridad
            $stmt = $conn->prepare("INSERT INTO usuario (nombre, apellido, contrasenia, correo, direccion) VALUES (?, ?, ?, ?, ?)");

            if ($stmt === false) {
                die("Error al preparar la consulta: " . $conn->error);
            }

            // Vincular parámetros a la consulta preparada
            $stmt->bind_param("sssss", $nombre, $apellido, $contrasenia_encriptada, $correo, $direccion);
            
            // Ejecutar la consulta
            if ($stmt->execute()) {
                $stmt = $conn->prepare("SELECT jerarquia, id_usuario FROM usuario WHERE correo = ? AND contrasenia = ?");
                $stmt->bind_param("ss", $correo, $contrasenia_encriptada);

                // Ejecutar la consulta
                $stmt->execute();
                $result2 = $stmt->get_result();

                if ($result2 && $result2->num_rows > 0) {
                    foreach ($result2 as $index => $row2) {
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
                    }
                }
                
                header("location: ../index.php");
            } else {
                echo "Hubo un error al guardar los datos: " . $stmt->error;
            }
        }

        $stmt->close();
    }
    $conn->close();
}

?>
