<?php
include "codigophp/conexionbs.php";
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
        header("Location: administrar-productos.php");
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Obtener datos del producto si se ha seleccionado uno
$producto_data = null;
if (isset($_GET["actualizar"])) {
    $producto_id = $conn->real_escape_string($_GET["actualizar"]);
    $producto_result = $conn->query("SELECT * FROM producto WHERE id_producto = $producto_id");
    if (!$producto_result) {
        die("Error en la consulta del producto: " . $conn->error);
    }
    $producto_data = $producto_result->fetch_assoc();
}

// Consultar categorías y marcas
$categorias_result = $conn->query("SELECT id_categoria, categoria FROM categoria");
$categorias = [];
while ($row = $categorias_result->fetch_assoc()) {
    $categorias[] = $row;
}

$marcas_result = $conn->query("SELECT id_marca, nombre_marca FROM marca");
$marcas = [];
while ($row = $marcas_result->fetch_assoc()) {
    $marcas[] = $row;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estiloscss/style.css">
    <link rel="stylesheet" href="estiloscss/administrar.css">
    <title>Editar Producto</title>
    <style>
        #descripcion2{
            resize: none;
            width: 100%;
            height: 100px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <header>
        <img src="imagenes/logo.svg" alt="">
        <h1>Editar Producto</h1>
    </header>
    <div id="textura"></div>
        <main class="actualizar">
        <div class="cont-datosviejos">
            <div class="dato">
                <p class="bold">Nombre anterior</p>
                <p><?php echo $producto_data['nombre_producto']; ?></p>
            </div>
            <div class="dato">
                <p class="bold">Precio anterior</p>
                <p><?php echo $producto_data['precio']; ?></p>
            </div>
            <div class="dato">
                <p class="bold">Descripción</p>
                <p><?php echo $producto_data['descripcion']; ?></p>
            </div>
            <div class="dato">
                <p class="bold">Cantidad disponible</p>
                <p><?php echo $producto_data['cantidad_disponible']; ?></p>
            </div>
            <div class="dato">
                <p class="bold">Categoria</p>
                <?php foreach ($categorias as $categoria): ?>
                    <p><?php echo ($producto_data['fk_categoria'] == $categoria['id_categoria']) ? $categoria['categoria'] : ''; ?></p>
                <?php endforeach; ?>
            </div>
            <div class="dato">
                <p class="bold">Marca</p>
                <?php foreach ($marcas as $marca): ?>
                    <p><?php echo ($producto_data['fk_marca'] == $marca['id_marca']) ? $marca['nombre_marca'] : ''; ?></p>
                <?php endforeach; ?>
            </div>
        </div>
        <form action="" method="post">
            <?php if ($producto_data): ?>
            <input type="hidden" name="producto_id" value="<?php echo $producto_data['id_producto']; ?>">
            <div class="input">
                <label for="nombre_producto">Nombre del Producto:</label>
                <input type="text" id="nombre_producto" name="nombre_producto" value="<?php echo $producto_data['nombre_producto']; ?>" required>
            </div>
            <div class="input">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01" value="<?php echo $producto_data['precio']; ?>" required>
            </div>
            <div class="input">
                <label for="descripcion2">Descripción:</label>
                <textarea id="descripcion2" name="descripcion" required><?php echo $producto_data['descripcion']; ?></textarea>
            </div>
            <div class="input">
                <label for="cantidad_disponible">Cantidad Disponible:</label>
                <input type="number" id="cantidad_disponible" name="cantidad_disponible" value="<?php echo $producto_data['cantidad_disponible']; ?>" required>
            </div>
            <div class="input">
                <label for="fk_categoria">Categoría:</label>
                <select id="fk_categoria" name="fk_categoria" required>
                    <option value="">Selecciona una categoría</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo $categoria['id_categoria']; ?>" <?php echo ($producto_data['fk_categoria'] == $categoria['id_categoria']) ? 'selected' : ''; ?>>
                            <?php echo $categoria['categoria']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input">
                <label for="fk_marca">Marca:</label>
                <select id="fk_marca" name="fk_marca" required>
                    <option value="">Selecciona una marca</option>
                    <?php foreach ($marcas as $marca): ?>
                        <option value="<?php echo $marca['id_marca']; ?>" <?php echo ($producto_data['fk_marca'] == $marca['id_marca']) ? 'selected' : ''; ?>>
                            <?php echo $marca['nombre_marca']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="submit" value="Actualizar Producto">
            <?php endif; ?>
        </form>
    </main>

    <?php include("footer.html");?>
    
    <script src="codigojs/resize.js"></script>
</body>
</html>