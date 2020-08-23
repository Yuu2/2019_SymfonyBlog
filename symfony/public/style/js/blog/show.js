var modal = $('#modal-verify-comment');
var box   = $('#box-verify-comment');
var load  = $('#loading');

// 버튼 클릭시 댓글 입력창 슬라이드 
$('.form-header').on('click', function(event) {

  var formbox = $('.form-box');
      formbox.css('display') === 'none' ? $(".form-box").slideDown() : $(".form-box").slideUp();
});

// 검증 폼 호출
$('.link-verify-comment').on('click', function(event) {
  
  load.show();
  
  $url = $(this).data('url');

  $.get($url)
  .done(function(response) {
    box.append(response.form);
  })
  .fail(function(err) {
    modalReset();
  })
  .always(function() {
    load.hide();
  });
});

// 검증 폼 전송
$(document).on('submit', '#form-verify-comment', function(event) {
  event.preventDefault();

  // 동적으로 생성된 폼
  var form = $('#form-verify-comment');
      form.hide();

  $('#loading').show();
  
  $.ajax({
    url: form.attr('action'), 
    type: form.attr('method'),
    data: form.serialize(),
    statusCode: {
      302: function(response) {
        /**
         * @refactoring responseJSON에 데이터가 있음... 
         */
        var data = response.responseJSON;
        switch(data.branch) {
          case 'DEL': commentDel(data.url); break;
          case 'EDIT': commentEdit(data.url); break;
          default: modalReset();
        }
      },
      400: function(response) {modal.hide()}
    }
  })
  .done(function(response) {
    form.remove(); // 기존 폼 제거
    box.append(response.form);
  })
  .fail(function(err) { 
    modalReset();
  })
  .always(function() {
    load.hide();
  });

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
      modalReset();
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
      modalReset();
    });
  }
  // 모달 리셋
  function modalReset() {
    load.show();
    form.remove();
    modal.modal('hide');
  }
});

