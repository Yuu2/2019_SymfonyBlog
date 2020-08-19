// 버튼 클릭시 댓글 입력창 슬라이드 
$('.form-header').on('click', function(event) {

  var formbox = $('.form-box');
      formbox.css('display') === 'none' ? $(".form-box").slideDown() : $(".form-box").slideUp();
});

// 삭제, 수정 버튼 클릭시 검증 폼 호출
$('.modal-verify-comment').on('click', function(event) {
  
  $('#loading').show();

  var modal = $(this);

  $.get(modal.data('action'))
  .done(function(response) {
    $('#form-verify-comment').append(response);
  })
  .fail(function(err) {
    console.log(err);
  })
  .always(function() {
    $('#loading').hide();
  })
  ;
});

