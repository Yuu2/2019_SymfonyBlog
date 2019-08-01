$(document).ready(function() {
  
  var btnSlider = false;
  
  // Slider
  $('.articles_nav').on('click', 'img', function(){
    if(btnSlider) {
      $('.articles_nav img').css('content', 'url("/style/images/icon/plusicon.png")');
      $('.articles_slide').slideUp('slow', 'swing', function() {
        btnSlider = !btnSlider;
      }); 
    } else {
      $('.articles_nav img').css('content', 'url("/style/images/icon/minusicon.png")');
      $('.articles_slide').slideDown('slow', 'swing', function() {
        btnSlider = !btnSlider;   
      });
    }
  });
});