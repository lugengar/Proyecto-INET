const popoverButton = document.querySelectorAll(".pop");
const contenedor = document.querySelectorAll(".pop2");
const overlay = document.getElementById('overlay');
let elegido = 0;
popoverButton.forEach((element, index) => {
    element.addEventListener('click', () => {
        elegido = index;
        document.body.classList.add('inactive');
        contenedor[elegido].style.display = 'block';
        overlay.style.display = 'block';
    });
});

overlay.addEventListener('click', () => {
    document.body.classList.remove('inactive');
    contenedor[elegido].style.display = 'none';
    overlay.style.display = 'none';
});