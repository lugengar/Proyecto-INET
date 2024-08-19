const cant = document.getElementById('cant-producto');
const plus = document.getElementById('plus');
const minus = document.getElementById('minus');
const max = document.getElementById('max').value;
let conta = 1;

if (conta == 1) {
    cant.value = 1;
}

plus.addEventListener('click', () => {
    conta += 1;
    if (conta >= parseInt(max)){
        conta = parseInt(max);
    }
    cant.value = conta;
});
minus.addEventListener('click', () => {
    conta -= 1;
    if (conta <= 1){
        conta = 1;
    }
    cant.value = conta;
});




