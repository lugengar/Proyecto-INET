//ES UNA ANIMACION PARA APARECER Y DES APARECER LA BARRA SUPERIOR
const element = document.getElementById('header');
window.addEventListener('scroll', function() {
    
    var scrollPosition = window.scrollY || window.pageYOffset;

    // Define el punto en el que quieres que aparezca el elemento
    var triggerPoint = 700; // Cambia esto al valor deseado en píxeles
    if (scrollPosition >= triggerPoint) {
        element.classList.add('visible');
        element.classList.remove('hidden');
    } else {
        element.classList.add('hidden');
        element.classList.remove('visible');
    }
});

function openMenu() {

    document.getElementById("barralateral").classList.add('abierto');
}

function closeMenu() {
    document.getElementById("barralateral").classList.remove('abierto');

}
function openMenu2() {

    document.getElementById("barracarrito").classList.add('abierto');
}

function closeMenu2() {
    document.getElementById("barracarrito").classList.remove('abierto');

}