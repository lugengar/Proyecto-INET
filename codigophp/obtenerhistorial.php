<?php
include "./codigophp/conexionbs.php";

function verTodasLasFacturas($conn) {
    $sql = "
    SELECT * FROM pedidos
    ";
 
    if ($result = $conn->query($sql)) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $pedido = json_decode($row["productos_pedido"], true);
                echo '<div class="universidad">';

                // Verificar que la decodificación JSON fue exitosa
                if (json_last_error() !== JSON_ERROR_NONE) {
                    echo "Error al decodificar productos_pedido para el pedido ID " . $row['id_pedido'] . "<br>";
                    continue;
                }

                // Consultar los productos asociados a este pedido
                $sql2 = "SELECT * FROM producto WHERE id_producto IN (" . implode(",", $pedido['productos']) . ")";
                $result2 = $conn->query($sql2);
                if ($result2 && $result2->num_rows > 0) {
                    foreach ($result2 as $index => $row2) {
                        echo "<p>Producto: " . $row2['nombre_producto'] . "</p>";
                        echo "<p>Cantidad: " . $pedido['cantidad'][$index] . "</p>";
                        echo "<p>Precio unitario: " . $pedido['precios'][$index] . "</p>";
                    }
                } else {
                    echo "Error al obtener los productos para el pedido ID " . $row['id_pedido'] . "<br>";
                }
                
                echo "<p>Fecha del pedido: " . $row['fecha_pedido'] . "</p>";
                echo "<p>Total: $" . $row['precio_total'] . "</p>";
                echo "<p>Método de pago: " . $row['metodo_pago'] . "</p>";
                echo "<p>Fecha de entrega: " . $row['fecha_entrega'] . "</p>";
                echo "<p>Estado: " . $row['estado'] . "</p>";
                echo '</div>';
            }
        } else {
            echo "No hay facturas disponibles.";
        }

        $result->free();
    } else {
        echo "Error en la consulta: " . $conn->error;
    }
}

// Llamar la función para ver todas las facturas
verTodasLasFacturas($conn);

// Cerrar la conexión
$conn->close();
?>
