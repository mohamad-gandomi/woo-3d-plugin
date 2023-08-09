setIframeSize();

window.addEventListener('resize', setIframeSize);

function setIframeSize() {
    var wrapperWidth = window.innerWidth;
    if (wrapperWidth > 960) {
        document.getElementById('video').width = (wrapperWidth * 0.8);
        document.getElementById('video').height = Math.floor(wrapperWidth * 0.45);
    }
    else {
        document.getElementById('video').width = (wrapperWidth * 0.9);
        document.getElementById('video').height = Math.floor(wrapperWidth * 0.50625);
    }
}