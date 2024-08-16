const videoPlayer = document.getElementById('videoPlayer');
const videoSource = document.getElementById('videoSource');

const videos = [
    'futbol.mp4',
    'basket.mp4',
    'tenis.mp4'
];

let currentVideoIndex = 0;

function changeVideo(index) {
    currentVideoIndex = index;
    videoSource.src = "/videos/"+videos[currentVideoIndex];
    videoPlayer.load();
    videoPlayer.play();
}

videoPlayer.addEventListener('ended', function() {
    currentVideoIndex = (currentVideoIndex + 1) % videos.length;
    videoSource.src = "/videos/"+videos[currentVideoIndex];
    videoPlayer.load();
    videoPlayer.play();
});

