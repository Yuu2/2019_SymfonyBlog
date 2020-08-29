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

/* 버튼 클릭시 댓글 입력창 슬라이드 
$('.form-header').on('click', function(event) {

  var formbox = $('.form-box');
      formbox.css('display') === 'none' ? $(".form-box").slideDown() : $(".form-box").slideUp();
});
*/

// 폼 전송
$(document).on('submit', '#modal-form', function(event) {
  
  event.preventDefault();

  resetModal(null, false);
  
  // 동적으로 생성된 폼
  var form = $('#modal-form');

  $.ajax({
    url: form.attr('action'), 
    type: form.attr('method'),
    data: form.serialize(),
    statusCode: {
      302: function(response) {
        
        var data = response.responseJSON;

        switch(data.branch) {
          case 'DEL' : commentDel(data.url);  break;
          case 'EDIT': commentEdit(data.url); break;
          default: closeModal();
        }
      },
      400: function(response) {
        closeModal();
      }
    }
  })
  .done(function(response) {
    resetModal(response.form);
  })
  .fail(function(err) { 
    closeModal();
  })

  // 댓글 수정
  function commentEdit(_url) {
    $.ajax({
      url: _url,
      method: 'PUT'
    })
    .done(function (response) {
      location.reload();
    })
    .fail(function(err) {
      closeModal();
    });
  }
  
  // 댓글 삭제
  function commentDel(_url) {
    $.ajax({
      url: _url,
      method: 'DELETE'
    })
    .done(function (response) {
      location.reload();
    })
    .fail(function(err) {
      closeModal();
    });
  }
});

function resetModal(html = null, clearFormbox = true) {
  
  if (clearFormbox) formbox.empty();

  (html != null) ? formbox.append(html) : formbox.append("<div id='modal-loading'></div>");

  return;
}

function closeModal() {
  formbox.empty();
  modal.hide();
  return;
}



