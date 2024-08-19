<?php
    include "./codigophp/verificacion.php";
    if ($_SESSION['jerarquia'] != 'vendedor'){
        header("Location: index.php");
    }
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
    <title>Document</title>
</head>

<body>
    <header>
        <img src="imagenes/SVG/logo.svg" alt="">
        <h1>ADMINISTRAR PRODUCTOS</h1>
    </header>
    <input type="checkbox" name="add" id="add">
    <main>
        <label for="add">Add</label>
        <div class="shadow-modal"></div>
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

            <form action="" method="post">
                <input type="text" placeholder="Ingrese el nombre del producto">
                <input type="text" placeholder="Ingrese le precio del producto">
                <input type="text" placeholder="¿Cuantas unidades son?">
                <label for="producto_id">Seleccione la categoria:</label>
                <select id="producto_id" name="producto_id" required>
                    <option value="">Selecciona un producto</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo $categoria['id_categoria']; ?>">
                            <?php echo $categoria['categoria']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="producto_id">Seleccione la categoria:</label>
                <select id="producto_id" name="producto_id" required>
                    <option value="">Selecciona un producto</option>
                    <?php foreach ($marcas as $marca): ?>
                        <option value="<?php echo $marca['id_marca']; ?>">
                            <?php echo $marca['nombre_marca']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" value="Agregar producto">
            </form>
        </div>
    <?php?>    
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
                <td><div class="icon"><?php echo $icon; ?></div><p><?php echo $categoria; ?></p></td>
                <td><?php echo $nombre_producto?></td>
                <td><a href="#">Editar</a></td>
                <td><a href="codigophp/borrarproducto.php?delete=<?php echo $id;?>">Eliminar</a></td>
            </tr>
        <?php 
            }
            echo "</tbody></table>";
        } 
        ?>
    </main>
    
    <?php include "footer.html"; ?>
</body>
</html>