<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./estiloscss/styles.css">
</head>
    
<body style="overflow: hidden;">
<div id="textura"></div>

    <div class=" cubrirtodo">
    <div class="logocarrusel"></div>
    <a class="logocarrusel2" href="./index.php"></a>
        <div class="contenidohistorial productos">
        <?php
            include "./codigophp/verificacion.php";
            solousuarios();
            include "./codigophp/obtenerhistorial.php";
            verTodasLasFacturas();
            verTodasLasFacturasviejas();
        ?>
        </div>   
        <?php include "footer.html"?>

    </div>
</body>
</html>