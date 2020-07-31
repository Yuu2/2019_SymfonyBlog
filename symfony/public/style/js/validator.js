// 중복검사
function isDuplicated(target, obj) {
  return (Object.values(obj).indexOf(target)) != -1 ? true : false;
}

// 공백검사
function isEmpty(str) {
  return (!str || 0 === str.length);
}

// 키보드검사
function isKeyboard(keyCode) {
  return (keyCode == 32 | keyCode == 13 | keyCode == 188) ? true : false;
}

// 공백 검사
function isEmpty(value) {
  return (value.trim() == "") ? true : false;
}

// 이메일 정규식 검사
function isEmail(email) {
  var regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
  return regex.test(email);
}