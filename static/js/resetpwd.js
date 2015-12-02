$(document).ready(function(){
  $('body').scrollTop(0);
  if (document.body.scrollHeight > 600) {
    $('.footer').css({'height': document.body.scrollHeight-550 + 'px', 'min-height' : document.body.scrollHeight-550 + 'px'});
  };
    
    if(_error) {
        alert(_error);
    }
});
function checkLogin() {
  clearError();
  var pwd1 = $("#pass").val();
  var pwd2 = $("#pass2").val();
  if (pwd1 != pwd2) {
    setError("两次输入密码不一致");
    return false;
  };
  if (pwd1.length <= 8) {
    setError("密码格式不正确，应为英文数字混合，长度8位以上");
    return false;
  };
  //同时包含数字和字母
  var flag1 = false, flag2 = false;
  for (var i = pwd1.length - 1; i >= 0; i--) {
    if((pwd1[i] <= 'Z'&& pwd1[i] >= 'A') || (pwd1[i] <= 'z'&& pwd1[i] >= 'a')) flag1 = true;
    if(pwd1[i] <= '9'&& pwd1[i] >= '0') flag2 = true;
    if (flag1 && flag2) {return true;};
  };
  setError("密码格式不正确，应为英文数字混合，长度8位以上");
  return false;
}
function setError(str) {
  $("#error").text(str).css('display', 'block');
}
function clearError() {$("#error").css('display', 'none');}