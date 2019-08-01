$(document).ready(function(){

  let btnCategory = false;
  
  $('.categories').on('click', function(event) {
    if(btnCategory) {
      $('.category_box').slideUp(500);
    } else {
      $('.category_box').slideDown(500);
    }
    btnCategory = !btnCategory;
  })
  // 카테고리 슬라이드
  $('.category').click(function() {
    const display = $(this).find('ul').css('display');
    
    if(display == 'block') {
      $(this).find('ul').slideUp(300);
    } else {
      $(this).find('ul').slideDown(300);
    }
  });
})