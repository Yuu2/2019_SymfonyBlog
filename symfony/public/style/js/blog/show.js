var modal    = $('#modal');
var formbox  = $('#modal-formbox');

// 폼 호출
$('.link-modal').on('click', function(event) {
  resetModal();

  $.get($(this).data('url'))
  .done(function(response) {
    resetModal(response.form);
  })
  .fail(function(err) {
    closeModal();
  });
});

// 폼 전송
$(document).on('submit', '#modal-form', function(event) {
  
  event.preventDefault();
  
  // 동적으로 생성된 폼
  var form = $('#modal-form');

  resetModal();

  $.ajax({
    url: form.attr('action'), 
    type: form.attr('method'),
    data: form.serialize(),
  })
  .done(function(response) {
    response.form != undefined ? resetModal(response.form) : reload();
  })
  .fail(function(err) {
    closeModal();
  })
});

/* 버튼 클릭시 댓글 입력창 슬라이드 
$('.form-header').on('click', function(event) {

  var formbox = $('.form-box');
      formbox.css('display') === 'none' ? $(".form-box").slideDown() : $(".form-box").slideUp();
});
*/

function resetModal(html = null) {
  
  formbox.empty();

  (html != null) ? formbox.append(html) : formbox.append("<div id='modal-loading'></div>");

  return;
}

function closeModal() {
  formbox.empty();
  modal.modal('hide');
  return;
}

function reload() {
  window.location.reload();
}



