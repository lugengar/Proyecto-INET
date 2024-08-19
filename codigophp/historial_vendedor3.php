<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inet";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

function verTodasLasFacturas($conn) {

    $sql = "
    SELECT h.productos_pedido, h.fecha_pedido, h.precio_total, h.metodo_pago, h.fecha_entrega, h.estado
    FROM historica h
    WHERE h.estado = 'entregado'
    ";

 
    if ($result = $conn->query($sql)) {
        if ($result->num_rows > 0) {
            echo "<h2>Todas las Facturas</h2>";
            while ($row = $result->fetch_assoc()) {
                echo "Productos: " . $row['productos_pedido'] . "<br>";
                echo "Fecha del pedido: " . $row['fecha_pedido'] . "<br>";
                echo "Total: $" . $row['precio_total'] . "<br>";
                echo "Método de pago: " . $row['metodo_pago'] . "<br>";
                echo "Fecha de entrega: " . $row['fecha_entrega'] . "<br>";
                echo "Estado: " . $row['estado'] . "<br><br>";
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