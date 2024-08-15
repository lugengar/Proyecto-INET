//ES UNA ANIMACION PARA APARECER Y DES APARECER LA BARRA SUPERIOR
window.addEventListener('scroll', function() {
    var element = document.getElementById('header');
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
