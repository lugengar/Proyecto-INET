<?php
include "./codigophp/conexionbs.php";
include "./codigophp/construccion.php";
$haypedidos = false;
function dividirTexto($texto) {
    if (strpos($texto, ',') !== false) {
        $partes = explode(",", $texto);

        $parte1 = trim($partes[0]);
        $parte2 = trim($partes[1]);

        return [$parte1, $parte2];
    } else {
        return [$texto, 'no tiene'];
    }
}
function verTodasLasFacturas() {
    global $conn;
    global $haypedidos;

    $sql = "
    SELECT * FROM pedidos WHERE fk_usuario = ".$_SESSION['id_usuario']." ORDER BY fecha_pedido DESC
    ";
 
    if ($result = $conn->query($sql)) {
        if ($result->num_rows > 0) {
            $haypedidos = true;
            while ($row = $result->fetch_assoc()) {
                $pedido = json_decode($row["productos_pedido"], true);
                echo '<form class="universidad " method="POST" action="./codigophp/procesarenvio.php">';

                // Verificar que la decodificación JSON fue exitosa
                if (json_last_error() !== JSON_ERROR_NONE) {
                    echo "Error al decodificar productos_pedido para el pedido ID " . $row['id_pedido'] . "<br>";
                    continue;
                }

                // Consultar los productos asociados a este pedido
                $sql2 = "SELECT * FROM producto WHERE id_producto IN (" . implode(",", $pedido['productos']) . ")";
                $result2 = $conn->query($sql2);
                echo "<details > <summary>Productos del pedido:</summary>";
                if ($result2 && $result2->num_rows > 0) {
                    foreach ($result2 as $index => $row2) {
                        echo "<p>" . $row2['nombre_producto'] . " x" . $pedido['cantidad'][$index] . "</p>";
                        echo "<p>Precio unitario: " . $pedido['precios'][$index] . "</p>";
                        echo "<div class='barraseparadora'></div>";
                    }
                } else {
                    echo "Error al obtener los productos para el pedido ID " . $row['id_pedido'] . "<br>";
                }
                echo "</details><details > <summary>Dirección: </summary>";
                echo "<iframe src='".crearmapa($_SESSION["direccion"])."'> </iframe>";
                echo "<p>" . $_SESSION['direccion'] . "</p><div class='barraseparadora'></div></details>";
                
                echo "<p>Fecha del pedido: " . $row['fecha_pedido'] . "</p>";
                echo "<p>Total: $" . $row['precio_total'] . "</p>";
                echo "<p>Método de pago: " . dividirTexto($row['metodo_pago'])[0] . "</p>";
                if($row['estado'] == "entregado"){
                    echo "<p>Fecha de entrega: " . $row['fecha_entrega'] . "</p>";
                }
                echo "<p>Estado: " . $row['estado'] . "</p>";
                echo "<input type='hidden' name='id_pedido' value='" . $row['id_pedido'] . "'>";

                if($row['estado'] == "entregado"){
                    echo '<button value="borrar" name="envio" type="submit">Eliminar pedido</button>';
                }else if($row['estado'] == "en preparacion"){
                    echo '<button value="cancelar" name="envio" type="submit">Cancelar pedido</button>';
                }
                echo '</form>';
            }
        }

        $result->free();
    } else {
        echo "Error en la consulta: " . $conn->error;
    }

}

function verTodasLasFacturasviejas() {
    global $conn;
    global $haypedidos;
    $sql = "
    SELECT * FROM historica WHERE fk_usuario = ".$_SESSION['id_usuario']." ORDER BY fecha_pedido DESC
    ";
 
    if ($result = $conn->query($sql)) {
        if ($result->num_rows > 0) {
            if($haypedidos){
                echo "<div class='barraseparadora'></div>";
            }
            while ($row = $result->fetch_assoc()) {
                $pedido = json_decode($row["productos_pedido"], true);
                echo '<form class="universidad " method="POST" action="./codigophp/procesarenvio.php">';

                // Verificar que la decodificación JSON fue exitosa
                if (json_last_error() !== JSON_ERROR_NONE) {
                    echo "Error al decodificar productos_pedido para el pedido ID " . $row['id_historica'] . "<br>";
                    continue;
                }

                // Consultar los productos asociados a este pedido
                $sql2 = "SELECT * FROM producto WHERE id_producto IN (" . implode(",", $pedido['productos']) . ")";
                $result2 = $conn->query($sql2);
                echo "<details > <summary>Productos del pedido:</summary>";
                if ($result2 && $result2->num_rows > 0) {
                    foreach ($result2 as $index => $row2) {
                        echo "<p>" . $row2['nombre_producto'] . " x" . $pedido['cantidad'][$index] . "</p>";
                        echo "<p>Precio unitario: " . $pedido['precios'][$index] . "</p>";
                        echo "<div class='barraseparadora'></div>";
                    }
                } else {
                    echo "Error al obtener los productos para el pedido ID " . $row['id_historica'] . "<br>";
                }
                echo "</details><details > <summary>Dirección: </summary>";
                echo "<iframe src='".crearmapa($_SESSION["direccion"])."'> </iframe>";
                echo "<p>" . $_SESSION['direccion'] . "</p><div class='barraseparadora'></div></details>";
                
                echo "<p>Fecha del pedido: " . $row['fecha_pedido'] . "</p>";
                echo "<p>Total: $" . $row['precio_total'] . "</p>";
                echo "<p>Método de pago: " . dividirTexto($row['metodo_pago'])[0] . "</p>";
                if($row['estado'] == "entregado"){
                    echo "<p>Fecha de entrega: " . $row['fecha_entrega'] . "</p>";
                }
                echo "<p>Estado: " . $row['estado'] . "</p>";
                echo "<input type='hidden' name='id_pedido' value='" . $row['id_historica'] . "'>";
                if($row['estado'] == "entregado"){
                    echo '<button value="borrar" name="envio" type="submit">Eliminar pedido</button>';
                }/*else if($row['estado'] == "en preparacion"){
                    echo '<button value="borrar" name="envio" type="submit">Cancelar pedido</button>';
                }*/
                echo '</form>';
            }
        } else {
            if(!$haypedidos){
                echo "<h1>No hay facturas disponibles.</h1>";
            }
        }

        $result->free();
    } else {
        echo "Error en la consulta: " . $conn->error;
    }
$conn->close();
}
function facturasadmin() {
    global $conn;

    $sql = "
    SELECT * FROM pedidos WHERE estado != 'entregado' ORDER BY fecha_pedido DESC
    ";
 
    if ($result = $conn->query($sql)) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $pedido = json_decode($row["productos_pedido"], true);
                echo '<form class="universidad " method="POST" action="./codigophp/procesarenvio.php">';

                // Verificar que la decodificación JSON fue exitosa
                if (json_last_error() !== JSON_ERROR_NONE) {
                    echo "Error al decodificar productos_pedido para el pedido ID " . $row['id_pedido'] . "<br>";
                    continue;
                }

                // Consultar los productos asociados a este pedido
                $sql2 = "SELECT * FROM producto WHERE id_producto IN (" . implode(",", $pedido['productos']) . ")";
                $result2 = $conn->query($sql2);
                echo "<details > <summary>Productos del pedido:</summary>";
                if ($result2 && $result2->num_rows > 0) {
                    foreach ($result2 as $index => $row2) {
                        echo "<p>" . $row2['nombre_producto'] . " x" . $pedido['cantidad'][$index] . "</p>";
                        echo "<p>Precio unitario: " . $pedido['precios'][$index] . "</p>";
                        echo "<div class='barraseparadora'></div>";
                    }
                } else {
                    echo "Error al obtener los productos para el pedido ID " . $row['id_pedido'] . "<br>";
                }
                echo "<h1>N - " . $row['id_pedido'] . "</h1>";
                echo "</details><details > <summary>Dirección: </summary>";
                echo "<iframe src='".crearmapa($_SESSION["direccion"])."'> </iframe>";
                echo "<p>" . $_SESSION['direccion'] . "</p><div class='barraseparadora'></div></details>";
                echo "<p>Fecha del pedido: " . $row['fecha_pedido'] . "</p>";
                echo "<p>Total: $" . $row['precio_total'] . "</p>";
                echo "<p>Método de pago: " . dividirTexto($row['metodo_pago'])[0] . "</p>";
                echo "<p>ID método de pago: " . dividirTexto($row['metodo_pago'])[1] . "</p>";
                if($row['estado'] == "entregado"){
                    echo "<p>Fecha de entrega: " . $row['fecha_entrega'] . "</p>";
                }
                echo "<p>Estado: " . $row['estado'] . "</p>";
                echo "<input type='hidden' name='id_pedido' value='" . $row['id_pedido'] . "'>";

                if($row['estado'] == "en preparacion"){
                    echo '<button value="enviar" name="envio" type="submit">Enviar pedido</button>';
                }else if($row['estado'] == "en camino"){
                    echo '<button value="entregado" class="celeste" name="envio" type="submit">Pedido Recibido</button>';
                }
                echo '</form>';
            }
        } else {
            echo "<h1>No hay facturas disponibles.</h1>";

        }

        $result->free();
    } else {
        echo "Error en la consulta: " . $conn->error;
    }
$conn->close();
}
// Llamar la función para ver todas las facturas

// Cerrar la conexión
?>
