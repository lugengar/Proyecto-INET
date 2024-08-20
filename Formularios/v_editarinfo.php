<?php
include "../codigophp/conexionbs.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir y sanitizar los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $id_usuario = $_SESSION['id_usuario'];
   
    $stmt = $conn->prepare("UPDATE usuario SET nombre = ?, apellido = ?, direccion = ? WHERE id_usuario = ?");
    $stmt->bind_param("ssss", $nombre, $apellido, $direccion, $id_usuario);
    $stmt->execute();
    $_SESSION['nombre'] = $nombre;
    $_SESSION['apellido']  = $apellido;
    $_SESSION['direccion'] = $direccion;
    header("location: ./editarinfo.php");

    $stmt->close();
    $conn->close();
}

?>
