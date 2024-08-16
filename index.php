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
<div id="textura"></div>

    
        <div class="overlay" id="overlay"></div>
    <div class="container" >
        <main class="carrusel ">
            <div class="imagenes">
            <video autoplay muted class="imagen activo" id="videoPlayer">
                <source src="videos/futbol.mp4" type="video/mp4" id="videoSource">
            </video>

                <div class="imagen" style="background-image: url('imagenes/otros/gente.jpg');"></div>
                <div class="imagen" style="background-image: url('imagenes/otros/graduados.jpg');"></div>
               
            </div>
            <div class="filtro" >
            <a class="texto1">Ver productos relacionados con fútbol</a>
                <div class="circulos">
                    <button onclick="changeVideo(0)" class="circulo activo" style="background-image: url('imagenes/SVG/futbol.svg');"></button>
                    <button onclick="changeVideo(1)" class="circulo" style="background-image: url('imagenes/SVG/basket.svg');"></button>
                    <button onclick="changeVideo(2)" class="circulo" style="background-image: url('imagenes/SVG/tenis.svg');"></button>
                   
                </div>
            </div>
            <a onclick="redirigir('identificador1')" class="casita_superior"></a>
        </main>
        <header class="header" id="header">
            <a href="index.php" class="logo_pba_horizontal " ></a>
        </header>
        <main class="main">



            <!-- MAPA -->
            <div popover class="pop2">
                <h1>HAGA CLIC FUERA DEL CUADRO PARA SALIR</h1>
                <!-- ACA VA EL DIV O LO Q SEA DEL MAPA. EL TAMAÑO SE AJUSTA AUTOMATICAMENTE-->
                <div id="mapa">
                    <p>Hola</p>
                    <img id="imagenmapa" src="./imagenes/otros/mapa2.svg" alt="">
                    <img class="puntero" src="./imagenes/otros/puntero.svg" alt="">
                    <style>
                        /*POR SI QUERES AGREGAR ESTILOS DESDE ACÁ*/
                    </style>
                </div>
            </div>


            <div class="identificador" id="identificador1" style="top: 80dvh;"></div>
           
            <form class="barradebusqueda activo" id="nombre" method="GET" action="./index.php#identificador2">
            
            
                
                <div>
                    <input type="hidden" name="tipo" value="nombre" required><input type="text" name="busqueda" placeholder="¿Que producto busca?" required>
                    <input type="submit" value="" style="background-image: url(imagenes/SVG/lupa.svg);">
                </div>
                <select name="busqueda" id="" required>
                <option value="">Elija una categoria</option>
                
            </select>
                <p >Menor precio<input type="checkbox" name="" id="" value=""></p>
                <p>Sin filtro<input type="checkbox" name="" id="" value=""></p>

            </form>
           
            <div class="universidades" id="uni" style="padding-top:0vh; position:relative;">
                <div style="height:200vh;"></div>
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
<script src="codigojs/ventanas.js"></script>
<script src="codigojs/botonesbarra.js"></script>
<script src="codigojs/scroll.js"></script>

