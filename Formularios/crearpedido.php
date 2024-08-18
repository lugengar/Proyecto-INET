<?php
include "../codigophp/conexionbs.php";
include "../codigophp/verificacion.php";
solousuarios();     
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
if(!empty($_SESSION['pedido'])){

    $estado = "en preparacion";
    $fecha_entrega = ""; // Puedes definir una fecha o dejarla vacía según tus necesidades
    $fk_usuario = $_SESSION['id_usuario'];
    $productos_pedidos = json_encode($_SESSION['pedido']);

    // Preparar la consulta SQL con placeholders sin comillas
    $stmt = $conn->prepare("INSERT INTO pedidos (estado, fecha_entrega, productos_pedido, fk_usuario, total) VALUES (?, ?, ?, ?, ?)");

    // Vincular los parámetros con tipos correctos
    $stmt->bind_param("sssss", $estado, $fecha_entrega, $productos_pedidos, $fk_usuario,$_SESSION['total']);
    $stmt->execute();

    // Limpiar el carrito de compras

    $_SESSION["aceptado"] = true;
    $_SESSION['pedido'] = ["productos" => [],"cantidad" => []];

    // Cerrar la declaración y la conexión
    }
    $stmt->close();
    $conn->close();
    header("location: ../index.php");

    // Redirigir al usuario si es necesario
}
?>
