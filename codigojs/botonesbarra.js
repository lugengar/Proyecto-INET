//SOLO ES UN EFECTO VISUAL PARA LAS BARRAS 
const barra = document.querySelectorAll('.barradebusqueda');
function barradebusqueda(id){
    barra.forEach(barra => barra.classList.remove('activo'));
    document.getElementById(id).classList.add('activo');
    document.getElementById("identificador2").scrollIntoView({ behavior: 'smooth' });
}
