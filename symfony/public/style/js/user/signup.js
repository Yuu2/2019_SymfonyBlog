/**
 * @author yuu2dev
 * updated 2020.06.29
 * 
 * @description 
 * signup : 커스텀 오브젝트. twig 템플릿 엔진을 통해 가공된 데이터가 필요합니다.
 */

// 썸네일 프리뷰
function signUpPreview(thumbnail_id) {
  $(thumbnail_id).change(function() {
    readURL(this, "#preview");
  });
}

// 이메일 중복확인
function signUpEmailCheck(signup) {

  // 버튼 클릭 시 비동기 통신
  $(signup.email_check_btn_id).click(function(e) {

    $.ajax({
      type: "POST",
      url:  signup.url.email_check,
      data: {'_email': $(signup.email_id).val()},
      beforeSend: function(xhr, opts) {
        validateEmailCheck(signup, xhr);
      }
    })
    .done(function(response) {
      renderBtnIfDone(signup, response);
    })
    .fail(function(response, status, xhr) {
      renderBtnIfFailed(signup);
    })
  });
  
  // 자바스크립트 유효성 검사
  function validateEmailCheck(signup, xhr) {
    
    $(signup.email_id).attr('readonly', true);
    $(signup.email_check_btn_id).attr('disabled', true);
    $(signup.email_check_btn_id).attr('class', 'btn-warning btn-sm btn');
    $(signup.email_check_btn_id).html(signup.button.email_checking);

    const email = $(signup.email_id).val();
    // 비어 있는가?
    if (isEmpty(email)) {
      alert(signup.alert.email_is_empty); 
      return xhr.abort();
    } 
    
    if (!isEmail(email)) {
      alert(signup.alert.email_is_email); 
      return xhr.abort();
    }
  }

  // ajax 성공시 버튼 렌더링
  function renderBtnIfDone(signup, response) {
    
    if (response.isDuplicated) {
      $(signup.email_id).val('');
      $(signup.email_id).attr('readonly', false);
      $(signup.email_check_btn_id).attr('disabled', false);
      $(signup.email_check_btn_id).attr('class', 'btn-outline-primary btn-sm btn');
      $(signup.email_check_btn_id).html(signup.button.email_check);
      alert(signup.alert.email_duplicated);
    } else {
      $(signup.email_check_id).val(1);
      $(signup.email_id).attr('readonly', true);
      $(signup.email_check_btn_id).attr('disabled', true);
      $(signup.email_check_btn_id).attr('class', 'btn-success btn-sm btn');
      $(signup.email_check_btn_id).html(signup.button.email_passed);
      alert(signup.alert.email_unduplicated);
    }
  }

  // ajax 실패시 버튼 렌더링
  function renderBtnIfFailed(signup) {
    $(signup.email_id).val('');
    $(signup.email_id).attr('readonly', false);
    $(signup.email_check_btn_id).attr('disabled', false);
    $(signup.email_check_btn_id).attr('class', 'btn-outline-primary btn-sm btn');
    $(signup.email_check_btn_id).html(signup.button.email_check);
    alert(signup.alert.email_check_failed);
  }
}