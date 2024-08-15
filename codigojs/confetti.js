//CODIGO PARA CREAR CONFETTI EN ALGUN CASO

let click = false;
document.querySelectorAll(".inscribirse").forEach(element => {
    element.addEventListener('click', function(event) {
        if(click == false){
            click = true;
            createConfetti();
            setTimeout(cleanUpConfetti, 4000);
        }
    });
});

function createConfetti() {
    const confettiColors = ['#ff4136', '#0074d9', '#2ecc40', '#ffdc00', '#ff1493']; 
    const confettiElements = 40;
    const container = document.createElement('div');
    container.classList.add('confetti-container');
    
    for (let i = 0; i < confettiElements; i++) {
        const confetti = document.createElement('div');
        confetti.classList.add('confetti');
        confetti.style.left = `${Math.random() * 100}%`;
        confetti.style.animationDelay = `${Math.random() * 2}s`;
        confetti.style.animationDuration = `${Math.random() * 3 + 1.5}s`;
        
        const randomRotation = Math.random() * 360;
        confetti.style.transform = `rotate(${randomRotation}deg)`;
        
        const randomColor = confettiColors[Math.floor(Math.random() * confettiColors.length)];
        confetti.style.backgroundColor = randomColor;
        
        container.appendChild(confetti);
    }
    
    document.body.appendChild(container);
}

function cleanUpConfetti() {
    const confettiContainer = document.querySelector('.confetti-container');
    if (confettiContainer) {
        confettiContainer.remove();
        click = false;
    }
}