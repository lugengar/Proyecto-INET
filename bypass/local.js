
const urlParams = new URLSearchParams(window.location.search);
const dato = urlParams.get('payment_type');
const dato2 = urlParams.get('payment_id');

if (dato) {
    const servidorDestino = 'http://localhost/Proyecto-INET/Formularios/crearpedido.php';
    //const servidorDestino = 'https://192.168.0.210/podium/Formularios/crearpedido.php';
    const nuevaURL = `${servidorDestino}?payment_type=${encodeURIComponent(dato)}&payment_id=${encodeURIComponent(dato2)}`;
    window.location.href = nuevaURL;
}
