//ACTIVA UNA ANIMACION SCROLL HACIA DONDE SE INDIQUE EL HREF

function redirigir(href){
    document.getElementById(href).scrollIntoView({ behavior: 'smooth' });
}

document.getElementById("tipo").addEventListener("change", function() {
    document.getElementById('barra').submit();
});