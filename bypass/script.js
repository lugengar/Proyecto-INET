
const urlParams = new URLSearchParams(window.location.search);
const dato = urlParams.get('payment_type');

// Mostrar el dato en la consola
console.log(dato);

// Redirigir a otra página en un servidor diferente enviando el dato como un nuevo parámetro GET

if (dato) {
    //const servidorDestino = 'http://localhost/Proyecto-INET/Formularios/crearpedido.php';
    const servidorDestino = 'https://192.168.0.210/podium/Formularios/crearpedido.php';
    const nuevaURL = `${servidorDestino}?payment_type=${encodeURIComponent(dato)}`;
    window.location.href = nuevaURL;
}
