<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Producto</title>
</head>
<body>
    <h1>Eliminar Producto</h1>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "inet";

    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Procesar el formulario si se ha enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["producto_id"])) {
        $producto_id = $conn->real_escape_string($_POST["producto_id"]);


        $stmt = $conn->prepare("DELETE FROM producto WHERE id_producto = ?");
        $stmt->bind_param("i", $producto_id);

        if ($stmt->execute()) {
            echo "<p>Producto eliminado correctamente</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }

    $productos_result = $conn->query("SELECT id_producto, nombre_producto FROM producto");
    $productos = [];
    while ($row = $productos_result->fetch_assoc()) {
        $productos[] = $row;
    }

    $conn->close();
    ?>

    <form action="" method="post">
        <label for="producto_id">Selecciona el producto a eliminar:</label>
        <select id="producto_id" name="producto_id" required>
            <option value="">Selecciona un producto</option>
            <?php foreach ($productos as $producto): ?>
                <option value="<?php echo $producto['id_producto']; ?>">
                    <?php echo $producto['nombre_producto']; ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <input type="submit" value="Eliminar Producto">
    </form>
</body>
</html>