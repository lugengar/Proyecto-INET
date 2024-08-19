
const videos = [
    'futbol.mp4',
    'basket.mp4',
    'tenis.mp4'
];
const deportes = [
"fútbol",'basket',
    'tenis'
];
const orden = [
    4,3,1
]
let currentVideoIndex = 0;
let currentPlayer = 1;

const videoPlayer1 = document.getElementById('videoPlayer1');
const videoPlayer2 = document.getElementById('videoPlayer2');
const texto = document.getElementById('texto1');
const buttons = document.querySelectorAll('.circulo');
texto.href = "./index.php?busqueda=&categoria="+orden[0]+"#identificador2"

function changeVideo(index) {
    currentVideoIndex = index;
    updateActiveButton(index);
    playVideo(index);
}

function playVideo(index) {
    const currentVideo = videos[index];
    const nextPlayer = currentPlayer === 1 ? videoPlayer2 : videoPlayer1;
    const previousPlayer = currentPlayer === 1 ? videoPlayer1 : videoPlayer2;

    nextPlayer.src = "videos/"+currentVideo;
    nextPlayer.style.opacity = 0;
    nextPlayer.load();
    nextPlayer.play();

    nextPlayer.oncanplay = function() {
        fadeIn(nextPlayer);
        fadeOut(previousPlayer);
    };

    nextPlayer.onended = function() {
        currentVideoIndex = (currentVideoIndex + 1) % videos.length;
        currentPlayer = currentPlayer === 1 ? 2 : 1;
        updateActiveButton(currentVideoIndex);
        playVideo(currentVideoIndex);
    };
}

function fadeIn(videoElement) {
    videoElement.style.transition = 'opacity 1s ease-in-out';
    videoElement.style.opacity = 1;
}

function fadeOut(videoElement) {
    videoElement.style.transition = 'opacity 1s ease-in-out';
    videoElement.style.opacity = 0;
}

function updateActiveButton(index) {
    buttons.forEach((button, i) => {
        if (i === index) {
            texto.textContent = "Ver productos relacionados con "+deportes[i]
            texto.href = "./index.php?busqueda=&categoria="+orden[i]+"#identificador2"
            button.classList.add('activo');
        } else {
            button.classList.remove('activo');
        }
    });

}

playVideo(currentVideoIndex);
