<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inett";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

function verTodasLasFacturas($conn) {

    $sql = "
    SELECT h.producto_vendido, h.fecha_del_pedido, h.cantidad, h.precio, h.precio_total
    FROM historica h
    JOIN pedidos p ON h.fk_pedido = p.id_pedido
    WHERE p.estado = 'entregado'
    ";


    if ($result = $conn->query($sql)) {
        if ($result->num_rows > 0) {
            echo "<h2>Todas las Facturas</h2>";
            while ($row = $result->fetch_assoc()) {
                echo "Producto: " . $row['producto_vendido'] . "<br>";
                echo "Cantidad: " . $row['cantidad'] . "<br>";
                echo "Precio unitario: $" . $row['precio'] . "<br>";
                echo "Fecha del pedido: " . $row['fecha_del_pedido'] . "<br>";
                echo "Total: $" . $row['precio_total'] . "<br><br>";
            }
        } else {
            echo "No hay facturas disponibles.";
        }


        $result->free();
    } else {
        echo "Error en la consulta: " . $conn->error;
    }
}


verTodasLasFacturas($conn);

// Cerrar la conexión
$conn->close();
?>