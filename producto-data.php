<?php
    include "codigophp/conexionbs.php";
    $id_producto = $_GET['producto'];
    $query = $conn->prepare("SELECT p.nombre_producto, p.precio, p.descripcion, p.cantidad_disponible, m.nombre_marca, c.icon FROM producto p INNER JOIN marca m ON p.fk_marca = m.id_marca INNER JOIN categoria c ON p.fk_categoria = c.id_categoria WHERE p.id_producto = $id_producto");
    $query->execute();
    $query->store_result();
    $query->bind_result($nombre_producto, $precio, $descripcion, $stock, $nombre_marca, $icon);
    while($query->fetch()){
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagenes/SVG/icono.svg" type="image/vnd.microsoft.icon">
    <link rel="stylesheet" href="estiloscss/producto-data.css">
    <title><?php echo $nombre_producto; ?> | Podium</title>
</head>
<div id="textura"></div>

<body>
    <main>
<a class="logocarrusel" href="./index.php"></a>

        <form class="cont-producto" action="./codigophp/productos.php" method="post">

            <div class="icon-producto">
                <?php echo $icon; ?>
            </div>
            <h2 class="nombre-producto"><?php echo $nombre_producto; ?></h2>
            <p class="cant-producto">Cantidad disponible: <?php echo $stock; ?></p>
            <p class="precio-producto">$<?php echo $precio; ?></p>
            <button type="submit" name="enviar" value="añadir" class="boton-producto">Añadir al carrito</button>
            <?php echo '<input type="hidden" name="id_producto" value="'.$id_producto.'">'; ?>
            <?php echo '<input type="hidden" name="precio" value="'.$precio.'">'; ?>
            <?php echo '<input type="hidden" name="cantidad" value="1">'; ?>

            <div class="marca-producto">
                <p class="bold">Marca:</p>
                <p><?php echo $nombre_marca; ?></p>
            </div>
            <div class="descrip-producto">
                <p class="bold">Descripción</p>
                <p><?php echo $descripcion; ?></p>
            </div>
        </form>
    <?php }?>
    </main>
    <?php include "footer.html"?>

    <script src="https://kit.fontawesome.com/45f45403cb.js" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>    
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>