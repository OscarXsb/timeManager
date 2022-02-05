$('.full-screen-btn').on('click', function (e) {
    var element = document.documentElement;
    if (!$('body').hasClass('full-screen')) {
        $('body').addClass('full-screen');
        $('#alarm-fullscreen-toggler').addClass('active');

        if (element.requestFullscreen) {
            element.requestFullscreen();
        } else if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if (element.webkitRequestFullscreen) {
            element.webkitRequestFullscreen();
        } else if (element.msRequestFullscreen) {
            element.msRequestFullscreen();
        }
    } else {
        console.log(document);
        $('body').removeClass('full-screen');
        $('#alarm-fullscreen-toggler').removeClass('active');

        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
});
