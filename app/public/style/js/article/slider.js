$(document).ready(function() {
  
  var btnSlider = false;
  
  // Slider
  $('.articles_nav').on('click', 'img', function(){
    if(btnSlider) {
      $('.articles_nav img').css('content', 'url("/style/images/icon/plusicon.png")');
      $('.articles_nav_slide').slideUp(300, function() {
        btnSlider = !btnSlider;
      }); 
    } else {
      $('.articles_nav img').css('content', 'url("/style/images/icon/minusicon.png")');
      $('.articles_nav_slide').slideDown(300, function() {
        btnSlider = !btnSlider;   
      });
    }
  });
});