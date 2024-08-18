<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
</head>
<body>
    <h1>Editar Producto</h1>

    <?php
    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "inet";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Procesar el formulario si se ha enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["producto_id"])) {
        $producto_id = $conn->real_escape_string($_POST["producto_id"]);
        $nombre_producto = $conn->real_escape_string($_POST["nombre_producto"]);
        $precio = $conn->real_escape_string($_POST["precio"]);
        $descripcion = $conn->real_escape_string($_POST["descripcion"]);
        $cantidad_disponible = $conn->real_escape_string($_POST["cantidad_disponible"]);
        $fk_categoria = $conn->real_escape_string($_POST["fk_categoria"]);
        $fk_marca = $conn->real_escape_string($_POST["fk_marca"]);

        // Preparar la sentencia SQL para actualizar el producto
        $stmt = $conn->prepare("UPDATE producto SET nombre_producto=?, precio=?, descripcion=?, cantidad_vendidos=?, cantidad_disponible=?, fk_categoria=?, fk_marca=? WHERE id_producto=?");
        $stmt->bind_param("sdssdiii", $nombre_producto, $precio, $descripcion, $cantidad_vendidos, $cantidad_disponible, $fk_categoria, $fk_marca, $producto_id);

        if ($stmt->execute()) {
            echo "<p>Producto actualizado correctamente</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }

    // Consultar productos para llenar el menú desplegable
    $productos_result = $conn->query("SELECT id_producto, nombre_producto FROM producto");
    if (!$productos_result) {
        die("Error en la consulta de productos: " . $conn->error);
    }

    $productos = [];
    while ($row = $productos_result->fetch_assoc()) {
        $productos[] = $row;
    }

    // Obtener datos del producto si se ha seleccionado uno
    $producto_data = null;
    if (isset($_GET["producto_id"])) {
        $producto_id = $conn->real_escape_string($_GET["producto_id"]);
        $producto_result = $conn->query("SELECT * FROM producto WHERE id_producto = $producto_id");
        if (!$producto_result) {
            die("Error en la consulta del producto: " . $conn->error);
        }
        $producto_data = $producto_result->fetch_assoc();
    }

    // Consultar categorías y marcas
    $categorias_result = $conn->query("SELECT id_categoria, categoria FROM categoria");
    if (!$categorias_result) {
        die("Error en la consulta de categorías: " . $conn->error);
    }

    $categorias = [];
    while ($row = $categorias_result->fetch_assoc()) {
        $categorias[] = $row;
    }

    $marcas_result = $conn->query("SELECT id_marca, nombre_marca FROM marca");
    if (!$marcas_result) {
        die("Error en la consulta de marcas: " . $conn->error);
    }

    $marcas = [];
    while ($row = $marcas_result->fetch_assoc()) {
        $marcas[] = $row;
    }

    // Cerrar la conexión
    $conn->close();
    ?>

    <form action="" method="post">
        <label for="producto_id">Selecciona el producto a editar:</label>
        <select id="producto_id" name="producto_id" onchange="location = this.value;" required>
            <option value="">Selecciona un producto</option>
            <?php foreach ($productos as $producto): ?>
                <option value="?producto_id=<?php echo $producto['id_producto']; ?>" <?php echo (isset($producto_data) && $producto_data['id_producto'] == $producto['id_producto']) ? 'selected' : ''; ?>>
                    <?php echo $producto['nombre_producto']; ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <?php if ($producto_data): ?>
            <input type="hidden" name="producto_id" value="<?php echo $producto_data['id_producto']; ?>">

            <label for="nombre_producto">Nombre del Producto:</label>
            <input type="text" id="nombre_producto" name="nombre_producto" value="<?php echo $producto_data['nombre_producto']; ?>" required><br><br>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" value="<?php echo $producto_data['precio']; ?>" required><br><br>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required><?php echo $producto_data['descripcion']; ?></textarea><br><br>

            <label for="cantidad_disponible">Cantidad Disponible:</label>
            <input type="number" id="cantidad_disponible" name="cantidad_disponible" value="<?php echo $producto_data['cantidad_disponible']; ?>" required><br><br>

            <label for="fk_categoria">Categoría:</label>
            <select id="fk_categoria" name="fk_categoria" required>
                <option value="">Selecciona una categoría</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?php echo $categoria['id_categoria']; ?>" <?php echo ($producto_data['fk_categoria'] == $categoria['id_categoria']) ? 'selected' : ''; ?>>
                        <?php echo $categoria['categoria']; ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="fk_marca">Marca:</label>
            <select id="fk_marca" name="fk_marca" required>
                <option value="">Selecciona una marca</option>
                <?php foreach ($marcas as $marca): ?>
                    <option value="<?php echo $marca['id_marca']; ?>" <?php echo ($producto_data['fk_marca'] == $marca['id_marca']) ? 'selected' : ''; ?>>
                        <?php echo $marca['nombre_marca']; ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <input type="submit" value="Actualizar Producto">
        <?php endif; ?>
    </form>
</body>
</html>