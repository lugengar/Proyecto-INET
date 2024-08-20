<?php
    include "./codigophp/verificacion.php";
    soloadmin();
    include "./codigophp/buscar.php";
    include "codigophp/conexionbs.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estiloscss/styles.css">
    <link rel="stylesheet" href="estiloscss/administrar.css">
    <!-- <link rel="stylesheet" href="estiloscss/footer.css"> -->
    <title>Document</title>
</head>

<body>
    <header>
        <img src="imagenes/logo.svg" alt="">
        <h1>ADMINISTRAR PRODUCTOS</h1>
        <a class="logocarrusel2" href="./index.php"></a>
    </header>
    <div id="textura"></div>
    <input type="checkbox" name="add" id="add">
    <main>
        <div class="agregar-producto"><label for="add">Agregar otro producto</label></div>
        <label for="add" class="shadow-modal"></label>
        <div class="modal-add">
            <div class="text"><p>Agregar productos</p><label for="add"><i class="fa-solid fa-xmark"></i></label></div>
            <?php
            $categorias_query = $conn->query("SELECT id_categoria, categoria FROM categoria");
            $marcas_query = $conn->query("SELECT id_marca, nombre_marca FROM marca");
            $categorias = [];
            $marcas = [];
            while ($row = $categorias_query->fetch_assoc()) {
                $categorias[] = $row;
            }
            while ($row = $marcas_query->fetch_assoc()) {
                $marcas[] = $row;
            }
            ?>

            <form action="administrar-productos.php" method="post">
                <input type="text" name="nombre_producto" placeholder="Ingrese el nombre del producto">
                <input type="number" name="precio" placeholder="Ingrese le precio del producto">
                <textarea id="descripcion" name="descripcion" placeholder="Descripción"></textarea>
                <input type="number" name="cantidad_disponible" placeholder="¿Cuantas unidades son?">
                <label for="fk_categoria">Seleccione la categoria:</label>
                <select id="fk_categoria" name="fk_categoria" required>
                    <option value="">Selecciona un producto</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo $categoria['id_categoria']; ?>">
                            <?php echo $categoria['categoria']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="fk_marca">Seleccione la categoria:</label>
                <select id="fk_marca" name="fk_marca" required>
                    <option value="">Selecciona un producto</option>
                    <?php foreach ($marcas as $marca): ?>
                        <option value="<?php echo $marca['id_marca']; ?>">
                            <?php echo $marca['nombre_marca']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="botones">
                    <label for="add" class="cancelar">cancelar</label>
                    <input type="submit" value="Agregar producto">
                </div>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Obtener datos del formulario y escaparlos para prevenir inyecciones SQL
                $nombre_producto = $conn->real_escape_string($_POST["nombre_producto"]);
                $precio = $conn->real_escape_string($_POST["precio"]);
                $descripcion = $conn->real_escape_string($_POST["descripcion"]);
                $cantidad_disponible = $conn->real_escape_string($_POST["cantidad_disponible"]);
                $fk_categoria = $conn->real_escape_string($_POST["fk_categoria"]);
                $fk_marca = $conn->real_escape_string($_POST["fk_marca"]);
        
                // Preparar la sentencia SQL con prepared statements
                $stmt = $conn->prepare("INSERT INTO producto (nombre_producto, precio, descripcion, cantidad_disponible, fk_categoria, fk_marca) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sdsdii", $nombre_producto, $precio, $descripcion, $cantidad_disponible, $fk_categoria, $fk_marca);
        
                if ($stmt->execute()) {
                    echo "<p>Producto agregado correctamente</p>";
                } else {
                    echo "<p>Error: " . $stmt->error . "</p>";
                }
        
                $stmt->close();
            }
            ?>  
        </div>
          
        <?php
        $query = $conn->prepare("SELECT c.categoria, c.icon, p.id_producto, p.nombre_producto FROM producto p INNER JOIN categoria c ON p.fk_categoria = c.id_categoria");
        $query->execute();
        $query->store_result();
        $query->bind_result($categoria, $icon, $id, $nombre_producto);
        if ($query->num_rows < 0) {
            echo "<p class='error_correo'>No hay ningun producto cargado</p>";
        } else {
            echo "<table><thead><tr><th>Categoria</th><th>Nombre</th><th></th><th><th></tr></thead><tbody>";
            while($query->fetch()){
        ?>
            <tr>
                <td class="icon"><div><?php echo $icon; ?></div><p><?php echo $categoria; ?></p></td>
                <td><?php echo $nombre_producto?></td>
                <td class="botonesUD"><a href="actualizar_producto.php?actualizar=<?php echo $id; ?>">Editar</a><a href="codigophp/borrarproducto.php?delete=<?php echo $id; ?>">Eliminar</a></td>
            </tr>
        <?php 
            }
            echo "</tbody></table>";
        } 
        ?>
    </main>
    
    <?php include "footer.html"; ?>
    <script src="codigojs/resize.js"></script>
</body>
</html>