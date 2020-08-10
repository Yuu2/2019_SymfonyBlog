// 버튼 클릭시 댓글 입력창 슬라이드 
$('.form-header').on('click', function(event) {

  var formbox = $('.form-box');
      formbox.css('display') === 'none' ? $(".form-box").slideDown() : $(".form-box").slideUp();
});

// 댓글 삭제 버튼 클릭시 모달 데이터 값 세팅
$('.modal-del-comment').on('click', function(event) {
  var modal = $(this);

  $('#form-del-comment').attr('action', modal.data('action'));
});



