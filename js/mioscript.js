$(document).ready(function(){
    $('#menu_principale a, #menu_secondario a, .menu a').addClass('mdl-navigation__link');
    
    //fancybox
//    $('.gallery a').attr('rel','gallAnimata').fancybox();
    
    //applico lightbox
    $(".gallery a").attr("data-lightbox","galleria");
    //opzioni lightbox
    lightbox.option({
        'showImageNumberLabel': false,
        'wrapAround': true
    });
});
