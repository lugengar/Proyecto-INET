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
    $stmt = $conn->prepare("INSERT INTO pedidos (estado, fecha_entrega, productos_pedido, fk_usuario, precio_total, metodo_pago, fecha_pedido) VALUES (?, ?, ?, ?, ?, ?, ?)");

    $productos = $_SESSION['pedido']['productos'];  // Array de IDs de productos
    $cantidadesVendidas = $_SESSION['pedido']['cantidad'];  // Array de cantidades vendidas correspondientes a cada producto
    $cantidadesDisponibles = $_SESSION['pedido']['cantidad'];  // Array de cantidades disponibles correspondientes a cada producto
    
    $sql = "UPDATE producto SET 
        cantidad_vendidos = CASE id_producto ";
    
    foreach ($productos as $index => $id_producto) {
        $sql .= "WHEN $id_producto THEN (cantidad_vendidos + " . $cantidadesVendidas[$index] . ") ";
    }
    
    $sql .= "END, 
        cantidad_disponible = CASE id_producto ";
    
    foreach ($productos as $index => $id_producto) {
        $sql .= "WHEN $id_producto THEN (cantidad_disponible - " . $cantidadesVendidas[$index] . ") ";
    }
    
    $sql .= "END 
        WHERE id_producto IN (" . implode(",", $productos) . ")";
    
    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Productos actualizados correctamente.";
    } else {
        echo "Error al actualizar productos: " . $conn->error;
    }
    function traducirMetodoPago($metodo) {
        $traducciones = [
            'account_money' => 'Cuenta de Mercado Pago',
            'credit_card' => 'Tarjeta de crédito',
            'debit_card' => 'Tarjeta de débito',
            'prepaid_card' => 'Tarjeta prepaga',
            'ticket' => 'Boleto',
            'bank_transfer' => 'Transferencia bancaria',
            'atm' => 'Cajero automático',
            'wallet' => 'Billetera virtual',
        ];
        return $traducciones[$metodo] ?? $metodo;
    }
    
    // Vincular los parámetros con tipos correctos
    $metodo = traducirMetodoPago($_GET["payment_type"]).",".$_GET["payment_id"];
    $stmt->bind_param("sssssss", $estado, $fecha_entrega, $productos_pedidos, $fk_usuario,$_SESSION['total'],$metodopago,date('Y-m-d'));
    $stmt->execute();

    // Limpiar el carrito de compras

    $_SESSION["aceptado"] = true;
    $_SESSION['pedido'] = ["productos" => [],"cantidad" => [],"precios" => []];

    // Cerrar la declaración y la conexión
    }
    $stmt->close();
    $conn->close();
    header("location: ../index.php");

}
?>
