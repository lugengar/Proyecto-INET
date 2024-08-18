<!DOCTYPE html>
<html lang="en-es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estiloscss/styles.css">
    <link rel="icon" href="imagenes/SVG/icono.svg" type="image/vnd.microsoft.icon">
    <title>Podium</title>
    <meta name="description" content="Podium">
</head>
<body>
<?php
    include "./codigophp/buscar.php";

?>
<div id="textura"></div>
<div class="container" >
    <div id="barralateral" class="barralateral">
        <a class="botonsalir" onclick="closeMenu()">&times;</a>
        <div class="contenidobarra">
        <a href="./Formularios/signin.php">Inicio</a>
        <a href="#">Servicios</a>
        <a href="#">Contacto</a>
        <a href="#">Contacto</a>
        <a href="#">Contacto</a>
        <a href="#">Contacto</a>
        <a href="#">Contacto</a>
        </div>
    </div>

    <form id="barracarrito" class="barralateral carro" action="./codigophp/productos.php" method="post">
        <a class="botonsalir" onclick="closeMenu2()">&times;</a>
        <div class="contenidobarra">
        <?php
            productosdelcarrito();
            ?>
            <div class="productocarrito">
                <h1></h1>
                <input type="hidden" value="" name="producto">
                <input type="hidden" value="" name="cantidad">
                <input type="hidden" value="" name="precio">
            </div>
        </div>
        <button type="submit" class="pagar" name="enviar" value="pagar">Pagar</button>
    </form>

    <button class="carrito" onclick="openMenu2()"></button>
    <header class="header hidden" id="header">
            <a href="index.php" class="logo"></a>
            <button class="user" onclick="openMenu()"></button>
        </header>
        <main class="carrusel ">
            <div class="imagenes">
            <video autoplay muted class="imagen activo" id="videoPlayer1">
            </video>
            <video autoplay muted class="imagen activo" id="videoPlayer2">
            </video>
                <div class="imagen" style="background-image: url('imagenes/otros/gente.jpg');"></div>
                <div class="imagen" style="background-image: url('imagenes/otros/graduados.jpg');"></div>
               
            </div>
            <div class="filtro" >
            <a onclick="redirigir('identificador1')"  class="texto1" id="texto1">Ver productos relacionados con fútbol</a>
                <div class="circulos">
                    <button onclick="changeVideo(0)" class="circulo activo" style="background-image: url('imagenes/SVG/futbol.svg');"></button>
                    <button onclick="changeVideo(1)" class="circulo" style="background-image: url('imagenes/SVG/basket.svg');"></button>
                    <button onclick="changeVideo(2)" class="circulo" style="background-image: url('imagenes/SVG/tenis.svg');"></button>
                   
                </div>
            </div>
            <a onclick="redirigir('identificador1')" class="logocarrusel"></a>
        </main>
        
        <main class="main">

            <div class="identificador" id="identificador1" style="top: 80dvh;"></div>
           
            <form class="barradebusqueda activo" id="barra" method="GET" action="./index.php#identificador2">
                <div>
                    <input type="text" name="busqueda" placeholder="¿Que producto busca?" required>
                    <input type="submit" value="" style="background-image: url(imagenes/SVG/lupa.svg);">
                </div>
                
                <select name="categoria" id="tipo" value="">
                    <option value="">Elija una categoria</option>
                    <?php
                    crearcategorias();
                    ?>
                </select>
              <?php
                precio();
              ?>
            </form>
           
            <div class="productos" id="uni" style=" position:relative;">
                <?php
                    etiqueta();
                    buscar();
                ?>
            <div class="identificador" id="identificador2" style="top: -20dvh;"></div>

               
            </div>
            <div class="barradebusqueda volverarriba">
                <img src="imagenes/iconos/flecha.svg" alt="">
                <button onclick="redirigir('identificador1')" >Volver arriba</button>
            </div>
        </main>

        <footer class="footer">
            <div class="imagenfooter"></div>
            <div class="logo_pba_vertical2"></div>

            <div class="textofooter">
                <h1>&copy; 2024 Escuela Secundaria Técnica N1 Vicente Lopez. Todos los derechos reservados.</h1>
            </div>
            <div class="redesociales">
      
            </div>
        </footer>
    </div>
</body>
</html>
<script src="codigojs/carrusel.js"></script>
<script src="codigojs/redirigir.js"></script>
<script src="codigojs/botonesbarra.js"></script>
<script src="codigojs/scroll.js"></script>
<script src="https://kit.fontawesome.com/45f45403cb.js" crossorigin="anonymous"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
