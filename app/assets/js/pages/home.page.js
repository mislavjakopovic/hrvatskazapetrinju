window.addEventListener('load', resizeTile);
window.addEventListener('resize', resizeTile);


function resizeTile(){
    let screenHeight = $(window).height();
    let screenWidth = $(window).width();
    let looking = $('.empty-state')[0];
    let offering = $('.empty-state')[1];
    if(screenWidth < 600){
        looking.dataset.height = 320;
        offering.dataset.height = 320;
    }
}
