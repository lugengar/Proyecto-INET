<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = $_SESSION['pedido']['productos'];
    $cantidad = $_SESSION['pedido']['cantidad'];
    $precios = $_SESSION['pedido']['precios'];

    $tipodeboton = $_POST["enviar"];
    
    if ($tipodeboton[0] == "b" && $tipodeboton[1] == "t") {
        $indice = intval($tipodeboton[2]);

        unset($cantidad[$indice]);
        unset($id_producto[$indice]);
        unset($precios[$indice]);

        $cantidad = array_values($cantidad);
        $id_producto = array_values($id_producto);
        $precios = array_values($precios);

        $_SESSION['pedido']['productos'] = $id_producto;
        $_SESSION['pedido']['cantidad'] = $cantidad;
        $_SESSION['pedido']['precios'] = $precios;

        echo "Producto y cantidad eliminados.".$indice;
        header("location: ../index.php#carrito");
    } else if ($tipodeboton[0] == "b" && $tipodeboton[1] == "u") {
        $indice = intval($tipodeboton[2]);
        $_SESSION['pedido']['cantidad'][$indice]--;
        echo "Cantidad disminuida.".$indice;
        header("location: ../index.php#carrito");
    } else if ($tipodeboton == "añadir") {
        $nuevo_id_producto = $_POST['id_producto']; 
        $nueva_cantidad = intval($_POST['cant-producto']); 
        $nuevo_precio = intval($_POST['precio']); 
    
        $indice = array_search($nuevo_id_producto, $id_producto);
    
        if ($indice !== false) {
            $cantidad[$indice] += $nueva_cantidad;
        } else {
            $id_producto[] = $nuevo_id_producto;
            $cantidad[] = $nueva_cantidad;
            $precios[] = $nuevo_precio;
        }
    
        $_SESSION['pedido']['productos'] = $id_producto;
        $_SESSION['pedido']['cantidad'] = $cantidad;
        $_SESSION['pedido']['precios'] = $precios;
        echo "Producto y cantidad agregados.";
        header("location: ../index.php");

    }else if ($tipodeboton == "pagar") {
        /*include "../codigophp/conexionbs.php";
        
        $estado = "en preparacion";
        $fecha_entrega = ""; // Puedes definir una fecha o dejarla vacía según tus necesidades
        $fk_usuario = $_SESSION['id_usuario'];
        $productos_pedidos = json_encode($_SESSION['pedido']);

        // Preparar la consulta SQL con placeholders sin comillas
        $stmt = $conn->prepare("INSERT INTO pedidos (estado, fecha_entrega, productos_pedido, fk_usuario) VALUES (?, ?, ?, ?)");

        // Vincular los parámetros con tipos correctos
        $stmt->bind_param("ssss", $estado, $fecha_entrega, $productos_pedidos, $fk_usuario);
        $stmt->execute();

        // Limpiar el carrito de compras
        

        echo "Pedido creado";
        
        // Cerrar la declaración y la conexión
        $stmt->close();
        $conn->close();*/

        // Redirigir al usuario si es necesario
        header("location: ../Formularios/pagar.php");
    }
   

}
?>

</body>
</html>
