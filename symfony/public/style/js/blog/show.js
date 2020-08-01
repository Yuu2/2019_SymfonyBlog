$(function() {
  
  // 버튼 클릭시 댓글 입력창 슬라이드 
  $('.form-header').on('click', function(event) {

    var formbox = $('.form-box');
        formbox.css('display') === 'none' ? $(".form-box").slideDown() : $(".form-box").slideUp();
  })

  // 댓글 작성 전송
  $('.form-box button').on('click', function(event) {
    event.preventDefault();

    var form = $(this).closest('.form-box').children('form'),
        form_method = form.attr('method'),
        form_action = form.attr('action');
    
    $.ajax({
      type: form_method,
      url: form_action,
      data: form.serialize()
    })
    .done(function(responseData) {
      console.log(1);
    })
    .fail(function(responseData, status, xhr) {
      console.log(0);
    });
    
    

  });
});