$('.navbar-flecha').click(e => {				
    e.preventDefault();
    $('body,html').animate({
        scrollTop: $('.description').offset().top }, 'slow');
});

$(window).scroll(function(){
  $('.banner-black').each(function(){
    if(isScrolledIntoView($(this))){
      $('.counter').each(function conta() {
        var $this = $(this),countTo = $this.attr('data-count');
        $( { countNum: $this.text()} ).animate({
          countNum: countTo
        },
        {
          duration: 2500,
          easing:'linear',
          step: function() {
            $this.text(Math.floor(this.countNum));
          },
          complete: function() {
            $this.text(this.countNum);
          }
        });  
    });
    }
    else{
      console.log('soy invisible');
    }
  });
});

function isScrolledIntoView($elem){
  var $window = $(window);

  var docViewTop = $window.scrollTop();
  var docViewBottom = docViewTop + $window.height();

  var elemTop = $elem.offset().top;
  var elemBottom = elemTop + $elem.height();

  return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}