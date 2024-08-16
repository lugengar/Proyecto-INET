<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
</head>
<body>
    <h1>Agregar Producto</h1>
    
    <?php
    // Conexión a la base de datos (reemplaza con tus credenciales)
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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener datos del formulario y escaparlos para prevenir inyecciones SQL
        $nombre_producto = $conn->real_escape_string($_POST["nombre_producto"]);
        $precio = $conn->real_escape_string($_POST["precio"]);
        $descripcion = $conn->real_escape_string($_POST["descripcion"]);
        $cantidad_vendidos = $conn->real_escape_string($_POST["cantidad_vendidos"]);
        $cantidad_disponible = $conn->real_escape_string($_POST["cantidad_disponible"]);
        $fk_categoria = $conn->real_escape_string($_POST["fk_categoria"]);
        $fk_marca = $conn->real_escape_string($_POST["fk_marca"]);

        // Preparar la sentencia SQL con prepared statements
        $stmt = $conn->prepare("INSERT INTO producto (nombre_producto, precio, descripcion, cantidad_vendidos, cantidad_disponible, fk_categoria, fk_marca) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdssdii", $nombre_producto, $precio, $descripcion, $cantidad_vendidos, $cantidad_disponible, $fk_categoria, $fk_marca);

        if ($stmt->execute()) {
            echo "<p>Producto agregado correctamente</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }

    // Cerrar la conexión
    $conn->close();
    ?>

    <form action="" method="post">
        <label for="nombre_producto">Nombre del Producto:</label>
        <input type="text" id="nombre_producto" name="nombre_producto" required><br><br>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" required><br><br>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4" required></textarea><br><br>

        <label for="cantidad_vendidos">Cantidad Vendidos:</label>
        <input type="number" id="cantidad_vendidos" name="cantidad_vendidos" required><br><br>

        <label for="cantidad_disponible">Cantidad Disponible:</label>
        <input type="number" id="cantidad_disponible" name="cantidad_disponible" required><br><br>

        <label for="fk_categoria">Categoría:</label>
        <select id="fk_categoria" name="fk_categoria" required>
            <option value="">Selecciona una categoría</option>
            <option value="1">Tenis</option>
            <option value="2">Padel</option>
            <option value="3">Basketball</option>
            <option value="4">Futbol</option>
            <option value="5">Jockey</option>
            <option value="6">Voley</option>
            <option value="7">Ciclismo</option>
            <option value="8">Golf</option>
        </select><br><br>

        <label for="fk_marca">Marca:</label>
        <select id="fk_marca" name="fk_marca" required>
            <option value="">Selecciona una marca</option>
            <option value="1">Head</option>
            <option value="2">Kappa</option>
            <option value="3">Nike</option>
            <option value="4">Adidas</option>
            <option value="5">Puma</option>
            <option value="6">Jaguar</option>
            <option value="7">Wilson</option>
            <option value="8">Topper</option>
            <option value="9">Under Armour</option>
            <option value="10">Cobra</option>
            <option value="11">Reebok</option>
            <option value="12">New Balance</option>
            <option value="13">Umbro</option>
            <option value="14">Fila</option>
            <option value="15">Ascis</option>
        </select><br><br>

        <input type="submit" value="Agregar Producto">
    </form>
</body>
</html>