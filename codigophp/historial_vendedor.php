<?php
session_start(); // Iniciar la sesión

// Configuración de conexión a la base de datos
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
    SELECT u.nombre, u.apellido, h.producto_vendido, h.cantidad, h.precio, h.precio_total, h.fecha_del_pedido
    FROM historica h
    JOIN pedidos p ON h.fk_pedido = p.id_pedido
    JOIN usuario u ON p.fk_usuario = u.id_usuario
    WHERE p.estado = 'entregado'
    ";


    if ($result = $conn->query($sql)) {

        if ($result->num_rows > 0) {
            echo "<h2>Facturas de Todos los Clientes</h2>";
            while ($row = $result->fetch_assoc()) {
                echo "Cliente: " . $row['nombre'] . " " . $row['apellido'] . "<br>";
                echo "Producto: " . $row['producto_vendido'] . "<br>";
                echo "Cantidad: " . $row['cantidad'] . "<br>";
                echo "Precio unitario: $" . $row['precio'] . "<br>";
                echo "Fecha del pedido: " . $row['fecha_del_pedido'] . "<br>";
                echo "Total: $" . $row['precio_total'] . "<br><br>";
            }
        } else {
            echo "No hay facturas disponibles.";
        }
    } else {
        echo "Error en la consulta: " . $conn->error;
    }
}


verTodasLasFacturas($conn);

// Cerrar la conexión
$conn->close();
?>