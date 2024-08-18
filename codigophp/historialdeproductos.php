
<?php
    include "./codigophp/conexionbs.php";
    $sql = "SELECT * FROM pedidos WHERE fk_usuario = ".$_SESSION['id_usuario'];
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            
            echo "<strong>Estado:</strong> " . $row["estado"] . "<br>";
            echo "<strong>Fecha de Entrega:</strong> " . $row["fecha_entrega"] . "<br>";
    
            echo "<strong>Producto/s pedido/s:</strong> " . $row["productos_pedido"] . "<br>";
            echo "<strong>Total/s:</strong> " . $row["total"] . "<br>";
            $productos_pedido = json_decode($row["productos_pedido"], true);
    
            if (json_last_error() === JSON_ERROR_NONE) {
                echo "<strong>Productos en el pedido:</strong><br>";
    
                $productos_ids = [];
                foreach ($productos_pedido as $producto) {
                    $productos_ids[] = $producto['id_producto'];
                }
    
                if (!empty($productos_ids)) {
                    $ids_string = implode(",", $productos_ids);
    
                    if ($result2->num_rows > 0) {
                        while ($producto_row = $result2->fetch_assoc()) {
                            echo "Producto: " . $producto_row["nombre_producto"] . " - Precio: $" . $producto_row["precio"] . "<br>";
                        }
                    } else {
                        echo "No se encontraron productos con los IDs especificados.<br>";
                    }
                } else {
                    echo "No hay productos en el pedido.<br>";
                }
            } else {

            }
    
            echo "<hr>";
        }
    } else {
        echo "0 resultados";
    }
    
    $conn->close();
    ?>