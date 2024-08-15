//ACTIVA UNA ANIMACION SCROLL HACIA DONDE SE INDIQUE EL HREF

function redirigir(href){
    document.getElementById(href).scrollIntoView({ behavior: 'smooth' });
}