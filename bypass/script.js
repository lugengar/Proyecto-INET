
const urlParams = new URLSearchParams(window.location.search);
const dato = urlParams.get('dato');

// Mostrar el dato en la consola
console.log(dato);

// Redirigir a otra página en un servidor diferente enviando el dato como un nuevo parámetro GET
if (dato) {
    const servidorDestino = 'http://localhost/Proyecto-INET/index.php';
    const nuevaURL = `${servidorDestino}?nuevoDato=${encodeURIComponent(dato)}`;
    window.location.href = nuevaURL;
}
