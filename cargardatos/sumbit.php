<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "abc";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener datos del formulario
    $id_carrera = $_POST['id_carrera'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $titulo = $_POST['titulo'];

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("INSERT INTO carrera (id_carrera, nombre, descripcion, titulo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $id_carrera, $nombre, $descripcion, $titulo);

    if ($stmt->execute() === TRUE) {
        echo "Nuevo registro creado exitosamente";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar conexión
    $stmt->close();
    $conn->close();
?>
