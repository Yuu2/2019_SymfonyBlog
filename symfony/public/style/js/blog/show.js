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
        if (response.form) {
            resetModal(response.form);
        } else {
            reload();
        }
    })
    .fail(function(err) {
        closeModal();
    })
});

// 댓글 작성 폼 헤더 클릭시 슬라이드 
$('.form-comments .form-header').on('click', function(event) {
  var formbox = $('.form-comments .form-box');
      formbox.css('display') === 'none' ? $(".form-box").slideDown(200) : $(".form-box").slideUp(200);
});


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



