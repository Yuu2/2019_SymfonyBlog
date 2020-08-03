// 버튼 클릭시 댓글 입력창 슬라이드 
$('.form-header').on('click', function(event) {

  var formbox = $('.form-box');
      formbox.css('display') === 'none' ? $(".form-box").slideDown() : $(".form-box").slideUp();
})

// 댓글 작성 전송
$('.form-box button').on('click', function(event) {
  event.preventDefault();

  var submit = $(this);
      submit.attr('disabled', true);
      submit.attr('class', 'btn btn-warning');
  var form = submit.closest('.form-box').children('form'),
      form_method = form.attr('method'),
      form_action = form.attr('action');
      
  $.ajax({
    type: form_method,
    url: form_action,
    data: form.serialize()
  })
  .done(function(responseData) {
    submit.attr('class', 'btn btn-success');
    submit.attr('disabled', false);
    alert(blog.article.comment.write.success);
    location.replace(blog.article.comment.redirect);
  })
  .fail(function(responseData, status, xhr) {
    alert(blog.article.comment.write.fail);
    submit.attr('class', 'btn btn-primary');
    submit.attr('disabled', false);
  });
});
