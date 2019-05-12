$('.navbar-flecha').click(e => {				
    e.preventDefault();
    $('body,html').animate({
        scrollTop: $('.description').offset().top }, 'slow');
});
