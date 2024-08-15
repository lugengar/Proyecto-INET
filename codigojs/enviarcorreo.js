//CREA UN MENSAJE DE REFERENCIA PARA ENVIAR UN CORREO
document.getElementById('formulariodecontacto').addEventListener('submit', function(event) {
    event.preventDefault(); 

   // var name = document.getElementById('name').value;
   // var email = document.getElementById('email').value;
    var receptor = document.getElementById('receptor').value;
    var message = document.getElementById('message').value;

    var mailtoLink = 'mailto:destinatario@'+ receptor +
    '?subject=' + encodeURIComponent('CONSULTA DESDE LA WEB DE ABC') +
    '&body=' + encodeURIComponent(message);
    window.location.href = mailtoLink;
});