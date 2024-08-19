<?php

$usuario = "root";
$password = "";
$servidor = "localhost";
$basededatos = "inet";

$conexion = mysqli_connect($servidor, $usuario, $password, $basededatos);

if (!$conexion) {
    die("Error al conectarse al servidor de la base de datos: " . mysqli_connect_error());
}

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir y sanitizar los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $id_usuario = $_SESSION['id_usuario'];
   
    $stmt = $conexion->prepare("UPDATE usuario SET nombre = ?, apellido = ?, direccion = ? WHERE id_usuario = ?");
    $stmt->bind_param("ssss", $nombre, $apellido, $direccion, $id_usuario);
    $stmt->execute();
    $_SESSION['nombre'] = $nombre;
    $_SESSION['apellido']  = $apellido;
    $_SESSION['direccion'] = $direccion;
    header("location: ./editarinfo.php");

    $stmt->close();
    $conexion->close();
}

?>
